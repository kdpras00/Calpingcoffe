<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Menu;
use App\Models\User;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_sales' => Order::whereDate('created_at', $today)->where('status', 'completed')->sum('total_amount'),
            'total_orders' => Order::whereDate('created_at', $today)->count(),
            'active_menus' => Menu::where('is_available', true)->count(),
            'active_users' => User::count(),
        ];

        // Fetch recent completed or cancelled orders for the dashboard history
        $recentOrders = Order::with(['items.menu', 'table'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders'));
    }
}
