<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_balance_id',  // ✅ Ubah dari 'store_id' ke 'store_balance_id'
        'amount',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    // ✅ Relasi ke StoreBalance (bukan ke Store langsung)
    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class, 'store_balance_id');
    }

    // ✅ Relasi ke Store melalui StoreBalance
    public function store()
    {
        return $this->hasOneThrough(
            Store::class,
            StoreBalance::class,
            'id',              // Foreign key di store_balances
            'id',              // Foreign key di stores
            'store_balance_id', // Local key di withdrawals
            'store_id'         // Local key di store_balances
        );
    }
}