<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'code', 'buyer_id', 'store_id', 'address', 'city', 'postal_code',
        'shipping', 'shipping_type', 'shipping_cost', 'tracking_number',
        'tax', 'grand_total', 'payment_status'
    ];

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}