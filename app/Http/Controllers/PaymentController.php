<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        if (config('app.env') === 'local') {
            Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_HTTPHEADER => []
            ];
        }
    }

    public function getSnapToken(Order $order)
    {

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(), // Ensure unique ID for retries
                'gross_amount' => (int) $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => 'Table',
                'last_name' => $order->table->number,
                'email' => 'guest@calping.com',
                'phone' => '081234567890',
            ],
            'enabled_payments' => [
                'qris', 'bca_va', 'bni_va', 'bri_va', 'echannel', 'permata_va', 'other_va'
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $order->update([
                'snap_token' => $snapToken,
                'transaction_id' => $params['transaction_details']['order_id'] // Store the unique ID used
            ]);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function notification(Request $request)
    {
        try {
            $notif = new Notification();
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid notification'], 400);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraud = $notif->fraud_status;

        // Extract actual order ID (remove timestamp suffix)
        $realOrderId = explode('-', $orderId)[0];
        $order = Order::find($realOrderId);

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Create Payment Record
        Payment::create([
            'order_id' => $order->id,
            'transaction_id' => $orderId,
            'payment_type' => $type,
            'gross_amount' => $notif->gross_amount,
            'transaction_status' => $transaction,
            'fraud_status' => $fraud,
        ]);

        if ($transaction == 'capture') {
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    $order->update(['payment_status' => 'pending']);
                } else {
                    $order->update(['payment_status' => 'paid', 'status' => 'confirmed', 'paid_at' => now()]);
                    
                    // Broadcast event
                    if (class_exists('\App\Events\OrderCreated')) {
                        event(new \App\Events\OrderCreated($order));
                    }
                }
            }
        } else if ($transaction == 'settlement') {
            $order->update(['payment_status' => 'paid', 'status' => 'confirmed', 'paid_at' => now()]);
            
            // Broadcast event so cashier dashboard auto-refreshes
            if (class_exists('\App\Events\OrderCreated')) {
                event(new \App\Events\OrderCreated($order));
            }
        } else if ($transaction == 'pending') {
            $order->update(['payment_status' => 'pending']);
        } else if ($transaction == 'deny') {
            $order->restoreStock();
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        } else if ($transaction == 'expire') {
            $order->restoreStock();
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        } else if ($transaction == 'cancel') {
            $order->restoreStock();
            $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
        }

        return response()->json(['message' => 'Payment status updated']);
    }

    public function check(Order $order)
    {
        // If already paid, return status immediately
        if ($order->payment_status == 'paid') {
            return response()->json([
                'status' => 'paid',
                'order_status' => $order->status
            ]);
        }

        try {
            $status = \Midtrans\Transaction::status($order->transaction_id ?? $order->id);
            $transaction = $status->transaction_status;
            $type = $status->payment_type;
            $fraud = $status->fraud_status;

            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $order->update(['payment_status' => 'pending']);
                    } else {
                        $order->update(['payment_status' => 'paid', 'status' => 'confirmed', 'paid_at' => now()]);
                    }
                }
            } else if ($transaction == 'settlement') {
                $order->update(['payment_status' => 'paid', 'status' => 'confirmed', 'paid_at' => now()]);
            } else if ($transaction == 'pending') {
                $order->update(['payment_status' => 'pending']);
            } else if ($transaction == 'deny') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            } else if ($transaction == 'expire') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            } else if ($transaction == 'cancel') {
                $order->update(['payment_status' => 'failed', 'status' => 'cancelled']);
            }

            return response()->json([
                'status' => $order->payment_status,
                'order_status' => $order->status,
                'midtrans_status' => $transaction
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
