<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
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
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Store belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Store has many Products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Store has one Balance
     */
    public function balance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    /**
     * Store has many Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}