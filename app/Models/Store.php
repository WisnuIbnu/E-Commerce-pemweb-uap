<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

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
        'is_verified' => 'boolean'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // 🔥 Relasi WAJIB untuk menghindari error
    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    // 🔥 Kamu pakai loadCount('transactions'), jadi relasi harus ada
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
