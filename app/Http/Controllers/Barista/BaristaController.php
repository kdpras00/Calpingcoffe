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
        // Fetch active orders for barista (confirmed, preparing, ready)
        // Only show PAID orders (exclude pending payment)
        $orders = Order::where('payment_status', 'paid')
            ->whereIn('status', ['confirmed', 'preparing', 'ready'])
            ->with(['items.menu', 'table'])
            ->orderBy('updated_at', 'asc') // Oldest first
            ->get();

        $menus = Menu::all(); // For stock management

        return view('barista.dashboard', compact('orders', 'menus'));
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
