<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'about',
        'phone',
        'city',
        'postal_code',
        'address',
        'address_id',
        'logo',
        'owner_id',
        'status',
    ];

    // Satu toko dimiliki satu user (owner)
    public function owner()
    {
        // pakai kolom owner_id sebagai foreign key
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function storeBallance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
