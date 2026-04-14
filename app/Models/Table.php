<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Table extends Model
{
    protected $fillable = ['number', 'qr_code', 'status', 'secure_token'];

    /**
     * Boot method to auto-generate secure token
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($table) {
            if (empty($table->secure_token)) {
                $table->secure_token = self::generateSecureToken($table->number);
            }
        });
    }

    /**
     * Generate a unique secure token using SHA256
     */
    public static function generateSecureToken($tableNumber)
    {
        return hash('sha256', Str::random(40) . $tableNumber . now()->timestamp);
    }

    /**
     * Get the QR code URL with secure token
     */
    public function getSecureUrl()
    {
        return rtrim(config('app.url'), '/') . '/menu?token=' . $this->secure_token;
    }

    /**
     * Get all orders for this table
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /**
     * Rotate the secure token and update status to available
     */
    public function rotateToken()
    {
        $this->update([
            'secure_token' => self::generateSecureToken($this->number),
            'status' => 'available'
        ]);

        // Also update the QR code URL with the new token
        $this->update([
            'qr_code' => $this->getSecureUrl()
        ]);
    }

    /**
     * Check if table is occupied based on status AND active orders
     */
    public function isOccupied()
    {
        if ($this->status === 'occupied') {
            return true;
        }

        return \App\Models\Order::where('table_id', $this->id)
            ->whereIn('status', ['pending', 'confirmed', 'preparing', 'ready'])
            ->whereDate('created_at', now()->today())
            ->exists();
    }
}
