<?php

namespace App\Console\Commands;

use App\Models\Menu;
use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelExpiredOrders extends Command
{
    protected $signature   = 'orders:cancel-expired';
    protected $description = 'Auto-cancel pending orders older than 15 minutes and restore their stock.';

    public function handle(): void
    {
        $expiredOrders = Order::where('status', 'pending')
            ->where('payment_status', 'pending')
            ->where('created_at', '<', now()->subMinutes(15))
            ->with('items')
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired orders found.');
            return;
        }

        foreach ($expiredOrders as $order) {
            DB::transaction(function () use ($order) {
                // Restore stock for each item in the order
                foreach ($order->items as $orderItem) {
                    $menu = Menu::lockForUpdate()->find($orderItem->menu_id);

                    if ($menu) {
                        $menu->increment('stock', $orderItem->quantity);

                        // Re-enable availability if it was disabled due to zero stock
                        if (!$menu->is_available && $menu->fresh()->stock > 0) {
                            $menu->update(['is_available' => true]);
                        }
                    }
                }

                // Cancel the order
                $order->update([
                    'status'         => 'cancelled',
                    'payment_status' => 'cancelled',
                ]);
            });

            $this->info("Order #{$order->id} cancelled and stock restored.");
        }

        $this->info("Done. {$expiredOrders->count()} expired order(s) processed.");
    }
}
