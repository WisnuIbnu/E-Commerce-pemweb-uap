<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $fillable = [
        'transaction_id',
        'product_id',
        'rating',
        'review',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relationships
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get buyer through transaction
    public function buyer()
    {
        return $this->hasOneThrough(
            Buyer::class,
            Transaction::class,
            'id',
            'id',
            'transaction_id',
            'buyer_id'
        );
    }

    // Get user who made review
    public function user()
    {
        return $this->buyer->user ?? null;
    }
}