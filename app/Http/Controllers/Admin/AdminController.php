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
            'total_sales_all' => Order::where('status', 'completed')->sum('total_amount'),
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

    public function exportSales(Request $request)
    {
        $date = $request->input('date', Carbon::today()->format('Y-m-d'));
        
        // Filter from 00:00:00 to 23:59:59 of the selected date
        $startOfDay = Carbon::parse($date)->startOfDay();
        $endOfDay = Carbon::parse($date)->endOfDay();

        $orders = Order::with(['items.menu', 'table'])
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->where('payment_status', 'paid')
            ->latest()
            ->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.sales-report', compact('orders', 'date'));
        
        return $pdf->download('laporan-penjualan-' . $date . '.pdf');
    }
}
