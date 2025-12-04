<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'buyer_id',
        'store_id',
        'address_id',
        'address',
        'city',
        'postal_code',
        'shipping',
        'shipping_type',
        'shipping_cost',
        'tracking_number',
        'tax',
        'grand_total',
        'payment_status',
    ];

    protected $casts = [
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    public function scopeProcessing($query)
    {
        return $query->where('payment_status', 'processing');
    }

    public function scopeShipped($query)
    {
        return $query->where('payment_status', 'shipped');
    }

    public function scopeDelivered($query)
    {
        return $query->where('payment_status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('payment_status', 'cancelled');
    }
}