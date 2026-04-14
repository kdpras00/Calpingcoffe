<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        // Fetch orders with pending payment only
        // Paid orders will automatically go to barista (status: confirmed)
        $orders = Order::where('payment_status', 'pending')
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->with(['items.menu', 'table'])
            ->latest()
            ->get();

        // Fetch all tables for the Table Map view
        $tables = \App\Models\Table::orderBy('number')->get()->map(function($table) {
            $table->is_occupied = $table->isOccupied();
            return $table;
        });

        return view('cashier.dashboard', compact('orders', 'tables'));
    }

    public function confirmPayment(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Order is already paid.');
        }

        $order->update([
            'payment_status' => 'paid',
            'status' => 'confirmed', // Move to confirmed so barista sees it
            'paid_at' => now(),
        ]);

        // Mark table as occupied when payment is confirmed (if not already)
        $order->table->update(['status' => 'occupied']);

        // Create a cash payment record
        \App\Models\Payment::create([
            'order_id' => $order->id,
            'transaction_id' => 'CASH-' . $order->id . '-' . time(),
            'payment_type' => 'cash',
            'gross_amount' => $order->total_amount,
            'transaction_status' => 'settlement',
        ]);

        return back()->with('success', 'Payment confirmed successfully.');
    }

    public function vacateTable(\App\Models\Table $table)
    {
        // Check if there are any UNPAID orders for this table today
        $unpaidCount = Order::where('table_id', $table->id)
            ->where('payment_status', 'pending')
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', now()->today())
            ->count();

        if ($unpaidCount > 0) {
            return back()->with('error', "Ada {$unpaidCount} pesanan belum dibayar. Selesaikan pembayaran atau batalkan pesanan sebelum mengosongkan meja.");
        }

        // Mark all active orders as completed (if they were already served/ready)
        Order::where('table_id', $table->id)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', now()->today())
            ->update(['status' => 'completed']);

        // Rotate token and set status to available
        $table->rotateToken();

        return back()->with('success', "Meja {$table->number} telah berhasil dikosongkan dan token QR telah diperbarui.");
    }

    public function printReceipt(Order $order)
    {
        return view('cashier.receipt', compact('order'));
    }

    public function cancelOrder(Order $order)
    {
        if ($order->status === 'cancelled') {
            return back()->with('error', 'Order is already cancelled.');
        }

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Cannot cancel paid order.');
        }

        $order->restoreStock();
        
        $order->update([
            'status' => 'cancelled',
            'payment_status' => 'failed'
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }
}
