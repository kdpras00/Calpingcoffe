<?php

namespace App\Http\Controllers\Barista;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;

class BaristaController extends Controller
{
    public function index()
    {
        $today = \Carbon\Carbon::today();
        
        $stats = [
            'total_sales_today' => Order::whereDate('created_at', $today)
                ->where('status', 'completed')
                ->sum('total_amount'),
            'active_orders' => Order::where('payment_status', 'paid')
                ->whereIn('status', ['confirmed', 'preparing', 'ready'])
                ->count(),
            'completed_orders_today' => Order::whereDate('created_at', $today)
                ->where('status', 'completed')
                ->count(),
            'menus_out_of_stock' => Menu::where(function($q) {
                    $q->where('stock', '<=', 0)->orWhere('is_available', false);
                })->count(),
            'total_menus' => Menu::count(),
        ];

        $recentOrders = Order::with(['items.menu', 'table'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->take(10)
            ->get();

        return view('barista.dashboard', compact('stats', 'recentOrders'));
    }

    public function orders()
    {
        // Fetch active orders for barista (confirmed, preparing, ready)
        // Only show PAID orders (exclude pending payment)
        $orders = Order::where('payment_status', 'paid')
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->with(['items.menu', 'table'])
            ->orderBy('updated_at', 'asc') // Oldest first
            ->get();

        return view('barista.orders', compact('orders'));
    }

    public function menus()
    {
        $menus = Menu::all(); // For stock management

        return view('barista.menus', compact('menus'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:preparing,ready,completed',
        ]);

        $order->update(['status' => $request->status]);

        event(new \App\Events\OrderStatusUpdated($order));

        return back()->with('success', 'Order status updated to ' . ucfirst($request->status));
    }

    public function updateStock(Request $request, Menu $menu)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $menu->update([
            'stock' => $request->stock,
            'is_available' => $request->stock > 0,
        ]);
        
        return back()->with('success', "Stock for {$menu->name} updated to {$request->stock}.");
    }
}
