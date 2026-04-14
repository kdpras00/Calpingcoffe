<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'table_id',
        'total_amount',
        'status',
        'payment_status',
        'transaction_id',
        'snap_token',
        'paid_at',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function restoreStock()
    {
        // Prevent double restoration if already cancelled
        if ($this->status === 'cancelled') {
            return;
        }

        foreach ($this->items as $item) {
            if ($item->menu) {
                $item->menu->increment('stock', $item->quantity);
                
                if (!$item->menu->is_available && $item->menu->stock > 0) {
                    $item->menu->update(['is_available' => true]);
                }
            }
        }
    }
}
