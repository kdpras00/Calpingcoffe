<?php

namespace App\Http\Controllers\Customer;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('token')) {
            $table = Table::where('secure_token', $request->token)->first();

            if ($table) {
                if ($table->isOccupied() && session('table_id') != $table->id) {
                    return redirect()->route('customer.occupied');
                }
                session(['table_id' => $table->id, 'table_number' => $table->number]);
            } else {
                abort(403, 'Invalid or expired QR code. Please scan a valid table QR code.');
            }
        }

        if ($request->has('table_id') && !$request->has('token')) {
            return redirect()->route('customer.scan')->with('error', 'This QR code is outdated. Please ask staff for a new QR code.');
        }

        $categories = Category::with(['menus' => function ($query) {
            $query->where('is_available', true);
        }])->get();

        if (session()->has('active_order_id')) {
            $sessionOrder = Order::find(session('active_order_id'));
            if ($sessionOrder && in_array($sessionOrder->status, ['completed', 'cancelled'])) {
                session()->forget('active_order_id');
            }
        }

        $activeOrder = Order::where('table_id', session('table_id'))
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', now()->today())
            ->latest()
            ->first();

        if ($activeOrder) {
            session(['active_order_id' => $activeOrder->id]);
        } else {
            session()->forget('active_order_id');
        }

        return view('customer.index', compact('categories', 'activeOrder'));
    }

    public function scan()
    {
        if (session('table_id')) {
            return redirect()->route('customer.index')->with('error', 'Meja Anda sudah terdaftar. Silakan hubungi staf jika ingin pindah meja.');
        }

        $tables = Table::orderBy('number')->get()->map(function ($table) {
            $table->is_occupied = $table->isOccupied();
            return $table;
        });

        return view('customer.scan', compact('tables'));
    }

    public function cart()
    {
        $tables = Table::orderBy('number')->get()->map(function ($table) {
            $table->is_occupied = $table->isOccupied();
            return $table;
        });

        return view('customer.cart', compact('tables'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'items'        => 'required|json',
            'note'         => 'nullable|string',
            'table_number' => 'nullable|exists:tables,number',
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

            $table = Table::where('number', $request->table_number)->first();

            if ($table->isOccupied()) {
                return back()->with('error', 'Table is currently occupied by another customer.');
            }

            $tableId = $table->id;
            session(['table_id' => $table->id, 'table_number' => $table->number]);
        }

        if (!$tableId) {
            return back()->with('error', 'Table session lost. Please scan QR code again.');
        }

        try {
            $order = DB::transaction(function () use ($items, $tableId, $request) {

                // Fetch & lock all menu rows atomically to prevent race conditions
                $menuIds = array_column($items, 'id');
                $menus   = Menu::whereIn('id', $menuIds)
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                // Validate using real DB values (not frontend data)
                foreach ($items as $item) {
                    if (!isset($menus[$item['id']])) {
                        throw new \Exception("Menu tidak ditemukan.");
                    }
                    $menu = $menus[$item['id']];
                    if (!$menu->is_available) {
                        throw new \Exception("Menu '{$menu->name}' sedang tidak tersedia.");
                    }
                    if ($menu->stock < $item['quantity']) {
                        throw new \Exception("Stok '{$menu->name}' tidak mencukupi. Sisa: {$menu->stock}");
                    }
                }

                // Calculate total from real DB prices (prevents price tampering)
                $totalAmount = 0;
                foreach ($items as $item) {
                    $totalAmount += $menus[$item['id']]->price * $item['quantity'];
                }
                $grandTotal = $totalAmount + ($totalAmount * 0.1);

                $order = Order::create([
                    'table_id'       => $tableId,
                    'total_amount'   => $grandTotal,
                    'status'         => 'pending',
                    'payment_status' => 'pending',
                ]);

                foreach ($items as $item) {
                    $menu = $menus[$item['id']];

                    OrderItem::create([
                        'order_id' => $order->id,
                        'menu_id'  => $item['id'],
                        'quantity' => $item['quantity'],
                        'price'    => $menu->price,
                        'note'     => $request->note,
                    ]);

                    $menu->decrement('stock', $item['quantity']);

                    if ($menu->fresh()->stock <= 0) {
                        $menu->update(['is_available' => false]);
                    }
                }

                return $order;
            });

            event(new OrderCreated($order));
            session(['active_order_id' => $order->id]);

            return redirect()->route('customer.payment', $order->id);

        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function payment(Order $order)
    {
        return view('customer.payment', compact('order'));
    }

    public function setTable(Request $request)
    {
        if (session('table_id')) {
            return redirect()->route('customer.index')->with('error', 'Meja Anda sudah terdaftar.');
        }

        $request->validate([
            'table_number' => 'required|exists:tables,number',
        ]);

        $table = Table::where('number', $request->table_number)->first();

        if ($table->isOccupied()) {
            return redirect()->route('customer.occupied');
        }

        session(['table_id' => $table->id, 'table_number' => $table->number]);

        return redirect()->route('customer.index');
    }

    public function status(Order $order)
    {
        if (in_array($order->status, ['completed', 'cancelled'])) {
            session()->forget('active_order_id');
        } else {
            session(['active_order_id' => $order->id]);
        }

        $progress = match ($order->status) {
            'confirmed'           => 33,
            'preparing'           => 66,
            'ready', 'completed'  => 100,
            default               => 0,
        };

        return view('customer.status', compact('order', 'progress'));
    }
}
