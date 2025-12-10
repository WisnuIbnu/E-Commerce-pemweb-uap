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

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Accessor to get the User who made the review
    public function getUserAttribute()
    {
        // Path: Review -> Transaction -> Buyer -> User
        return $this->transaction->buyer->user ?? null;
    }
}
