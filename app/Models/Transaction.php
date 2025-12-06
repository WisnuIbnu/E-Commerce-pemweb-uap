<?php

// app/Models/Transaction.php - ADD IF NOT EXISTS

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'buyer_id',
        'total',
        'status',
        'shipping_address',
        'payment_method'
    ];

    protected $casts = [
        'total' => 'decimal:2'
    ];

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }
}

