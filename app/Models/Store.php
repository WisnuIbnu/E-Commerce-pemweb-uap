<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $table = 'stores';

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about',
        'phone',
        'address_id',
        'city',
        'address',
        'postal_code',
        'is_verified'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
    ];

    /* ============================================
       RELASI
    ============================================ */

    // User pemilik toko
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Produk toko
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Saldo toko
    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    // Transaksi toko
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    // Withdrawals (has many through store_balance)
    public function withdrawals()
    {
        return $this->hasManyThrough(
            \App\Models\Withdrawal::class,
            \App\Models\StoreBalance::class,
            'store_id',
            'store_balance_id',
            'id',
            'id'
        );
    }

    /* ============================================
       ACCESSOR STATUS (auto)
    ============================================ */
    public function getStatusAttribute()
    {
        if ($this->deleted_at !== null) {
            return 'rejected';
        }

        return $this->is_verified ? 'approved' : 'pending';
    }
}
