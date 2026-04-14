<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CleanupPendingOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel pending orders older than 30 minutes and restore stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting order cleanup...');

        $expiredOrders = Order::where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(30))
            ->with('items.menu')
            ->get();

        $count = 0;

        foreach ($expiredOrders as $order) {
            DB::transaction(function () use ($order) {
                // Restore stock
                $order->restoreStock();

                // Update status
                $order->update([
                    'status' => 'cancelled',
                    'payment_status' => 'failed' // or 'expired'
                ]);
            });

            $this->info("Cancelled order #{$order->id}");
            $count++;
        }

        $this->info("Cleanup complete. Cancelled {$count} orders.");
    }
}
