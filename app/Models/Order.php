<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'total_price',
        'status',
    ];

    /**
     * Order belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order belongs to Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}