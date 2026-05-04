<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Handle Secure Token from QR Code
        if ($request->has('token')) {
            $table = Table::where('secure_token', $request->token)->first();
            
            if ($table) {
                // Cek apakah meja sedang dipakai oleh orang lain
                if ($table->isOccupied() && session('table_id') != $table->id) {
                    return redirect()->route('customer.occupied');
                }
                session(['table_id' => $table->id, 'table_number' => $table->number]);
            } else {
                abort(403, 'Invalid or expired QR code. Please scan a valid table QR code.');
            }
        }

        // Legacy support for old table_id parameter (will be removed in future)
        if ($request->has('table_id') && !$request->has('token')) {
            return redirect()->route('customer.scan')->with('error', 'This QR code is outdated. Please ask staff for a new QR code.');
        }

        // REMOVED: Mandatory redirect to scan page. We now allow browsing without a table.
        // if (!session()->has('table_id')) {
        //      return redirect()->route('customer.scan');
        // }

        $categories = Category::with(['menus' => function($query) {
            $query->where('is_available', true);
        }])->get();

        // Validate existing session order
        if (session()->has('active_order_id')) {
            $sessionOrder = \App\Models\Order::find(session('active_order_id'));
            if ($sessionOrder && in_array($sessionOrder->status, ['completed', 'cancelled'])) {
                session()->forget('active_order_id');
            }
        }

        // Check for existing active order for this table
        $activeOrder = \App\Models\Order::where('table_id', session('table_id'))
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', now()->today()) // Only today's orders
            ->latest()
            ->first();

        // We still track the active order for the current table if it exists
        if ($activeOrder) {
            session(['active_order_id' => $activeOrder->id]);
        } else {
             // Double check: if no active order found in DB, clear session
            session()->forget('active_order_id');
        }

        return view('customer.index', compact('categories', 'activeOrder'));
    }

    public function scan()
    {
        // If a table is already set in session, don't allow switching
        if (session('table_id')) {
            return redirect()->route('customer.index')->with('error', 'Meja Anda sudah terdaftar. Silakan hubungi staf jika ingin pindah meja.');
        }

        $tables = Table::orderBy('number')->get()->map(function($table) {
            $table->is_occupied = $table->isOccupied();
            return $table;
        });

        return view('customer.scan', compact('tables'));
    }

    public function cart()
    {
        $tables = Table::orderBy('number')->get()->map(function($table) {
            $table->is_occupied = $table->isOccupied();
            return $table;
        });
        
        return view('customer.cart', compact('tables'));
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|json',
            'note' => 'nullable|string',
            'table_number' => 'nullable|exists:tables,number'
        ]);

        $items = json_decode($request->items, true);
        
        if (empty($items)) {
            return back()->with('error', 'Cart is empty');
        }

        $tableId = session('table_id');
        
        if (!$tableId) {
            if (!$request->table_number) {
                return back()->with('error', 'Please select a table to order.');
            }
            
            $table = \App\Models\Table::where('number', $request->table_number)->first();
            
            // Check occupancy before allowing this new order
            if ($table->isOccupied()) {
                return back()->with('error', 'Table is currently occupied by another customer.');
            }
            
            $tableId = $table->id;
            session(['table_id' => $table->id, 'table_number' => $table->number]);
        }
        
        // Final check to ensure we have a valid tableId
        if (!$tableId) {
            return back()->with('error', 'Table session lost. Please scan QR code again.');
        }
        
        // Calculate total
        $totalAmount = 0;
        foreach ($items as $item) {
            $totalAmount += $item['price'] * $item['quantity'];
        }
        
        // Add Tax (10%)
        $tax = $totalAmount * 0.1;
        $grandTotal = $totalAmount + $tax;

        // Check stock availability
        foreach ($items as $item) {
            $menu = \App\Models\Menu::find($item['id']);
            if (!$menu) {
                return back()->with('error', 'Menu item not found');
            }
            if ($menu->stock < $item['quantity']) {
                return back()->with('error', "Insufficient stock for {$menu->name}. Available: {$menu->stock}");
            }
        }

        // Create Order
        $order = \App\Models\Order::create([
            'table_id' => $tableId,
            'total_amount' => $grandTotal,
            'status' => 'pending',
            'payment_status' => 'pending',
        ]);

        // Create Order Items and Decrement Stock
        foreach ($items as $item) {
            $menu = \App\Models\Menu::find($item['id']);
            
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'note' => $request->note,
            ]);

            // Decrement stock
            $menu->decrement('stock', $item['quantity']);
            
            // Update availability if stock reaches 0
            if ($menu->stock <= 0) {
                $menu->update(['is_available' => false]);
            }
        }

        // Broadcast Event
        event(new \App\Events\OrderCreated($order));

        // Save active order to session for history tracking
        session(['active_order_id' => $order->id]);

        // Clear cart (frontend will handle this via redirect param or just clear it)
        // For now, redirect to payment page (placeholder)
        return redirect()->route('customer.payment', $order->id);
    }

    public function payment(\App\Models\Order $order)
    {
        return view('customer.payment', compact('order'));
    }

    public function setTable(Request $request)
    {
        // If a table is already set in session, don't allow switching
        if (session('table_id')) {
            return redirect()->route('customer.index')->with('error', 'Meja Anda sudah terdaftar.');
        }

        $request->validate([
            'table_number' => 'required|exists:tables,number'
        ]);
        
        $table = Table::where('number', $request->table_number)->first();

        // Check occupancy before setting session
        if ($table->isOccupied()) {
            return redirect()->route('customer.occupied');
        }

        session(['table_id' => $table->id, 'table_number' => $table->number]);
        
        return redirect()->route('customer.index');
    }

    public function status(\App\Models\Order $order)
    {
        // Cleanup active session if order is completed/cancelled
        if (in_array($order->status, ['completed', 'cancelled'])) {
            session()->forget('active_order_id');
        } else {
            // Ensure session is set if viewing an active order
            session(['active_order_id' => $order->id]);
        }

        // Calculate progress percentage for UI
        $progress = 0;
        switch ($order->status) {
            case 'pending': $progress = 0; break;
            case 'confirmed': $progress = 33; break;
            case 'preparing': $progress = 66; break;
            case 'ready': 
            case 'completed': $progress = 100; break;
        }

        return view('customer.status', compact('order', 'progress'));
    }
}
