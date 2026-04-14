<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Models\Menu;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

Route::get('/', function () {
    // Top 3 best sellers in last 30 days
    $topMenuIds = OrderItem::select('menu_id', DB::raw('SUM(quantity) as total_qty'))
        ->whereHas('order', function($q) {
            $q->where('payment_status', 'paid')
              ->where('created_at', '>=', Carbon::now()->subDays(30));
        })
        ->groupBy('menu_id')
        ->orderByDesc('total_qty')
        ->limit(3)
        ->pluck('menu_id');

    $highlights = Menu::with('category')
        ->whereIn('id', $topMenuIds)
        ->get()
        ->sortBy(function($menu) use ($topMenuIds) {
            return array_search($menu->id, $topMenuIds->toArray());
        });

    // Fallback logic
    if ($highlights->count() < 3) {
        $needed = 3 - $highlights->count();
        $moreMenus = Menu::with('category')
            ->whereNotIn('id', $highlights->pluck('id'))
            ->where('is_available', true)
            ->limit($needed)
            ->get();
        $highlights = $highlights->concat($moreMenus);
    }

    return view('welcome', compact('highlights'));
})->name('home');

Route::get('/location', function () {
    return view('location');
})->name('location');

Route::get('/ourstory', function () {
    return view('ourstory');
})->name('ourstory');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('menus', \App\Http\Controllers\Admin\MenuController::class)->names('admin.menus');
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->names('admin.users');
    
    // Table specific routes (must be before resource routes)
    Route::get('tables/{table}/qr', [\App\Http\Controllers\Admin\TableController::class, 'showQr'])->name('admin.tables.qr');
    Route::get('tables/{table}/print', [\App\Http\Controllers\Admin\TableController::class, 'printQr'])->name('admin.tables.print');
    Route::get('tables/{table}/download', [\App\Http\Controllers\Admin\TableController::class, 'downloadQr'])->name('admin.tables.download');
    Route::post('tables/{table}/clear', [\App\Http\Controllers\Admin\TableController::class, 'clear'])->name('admin.tables.clear');
    Route::resource('tables', \App\Http\Controllers\Admin\TableController::class)->names('admin.tables');
    
    Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
});

// Customer Routes
Route::get('/menu', [\App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.index');
Route::get('/scan', [\App\Http\Controllers\Customer\OrderController::class, 'scan'])->name('customer.scan');
Route::get('/occupied', function() { return view('customer.occupied'); })->name('customer.occupied');
Route::post('/scan', [\App\Http\Controllers\Customer\OrderController::class, 'setTable'])->name('customer.setTable');
Route::get('/cart', [\App\Http\Controllers\Customer\OrderController::class, 'cart'])->name('customer.cart');
Route::post('/checkout', [\App\Http\Controllers\Customer\OrderController::class, 'checkout'])->name('customer.checkout');
Route::get('/payment/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'payment'])->name('customer.payment');
Route::get('/payment/snap-token/{order}', [\App\Http\Controllers\PaymentController::class, 'getSnapToken'])->name('payment.snap-token');
Route::get('/payment/check/{order}', [\App\Http\Controllers\PaymentController::class, 'check'])->name('payment.check');
Route::post('/payment/notification', [\App\Http\Controllers\PaymentController::class, 'notification'])->name('payment.notification');
Route::get('/order/{order}', [\App\Http\Controllers\Customer\OrderController::class, 'status'])->name('customer.order.status');
Route::middleware(['auth', 'role:kasir'])->prefix('cashier')->group(function () {
    Route::get('/', function () {
        return redirect()->route('cashier.dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\Cashier\CashierController::class, 'index'])->name('cashier.dashboard');
    Route::get('/orders/{order}/print', [\App\Http\Controllers\Cashier\CashierController::class, 'printReceipt'])->name('cashier.print');
    Route::post('/orders/{order}/confirm-payment', [\App\Http\Controllers\Cashier\CashierController::class, 'confirmPayment'])->name('cashier.confirm-payment');
    Route::post('/orders/{order}/cancel', [\App\Http\Controllers\Cashier\CashierController::class, 'cancelOrder'])->name('cashier.cancel');
    Route::post('/tables/{table}/vacate', [\App\Http\Controllers\Cashier\CashierController::class, 'vacateTable'])->name('cashier.tables.vacate');
});

// Barista Routes
Route::middleware(['auth', 'role:barista'])->prefix('barista')->group(function () {
    Route::get('/', function () {
        return redirect()->route('barista.dashboard');
    });
    Route::get('/dashboard', [\App\Http\Controllers\Barista\BaristaController::class, 'index'])->name('barista.dashboard');
    Route::post('/orders/{order}/status', [\App\Http\Controllers\Barista\BaristaController::class, 'updateStatus'])->name('barista.update-status');
    Route::post('/menus/{menu}/stock', [\App\Http\Controllers\Barista\BaristaController::class, 'updateStock'])->name('barista.update-stock');
});


