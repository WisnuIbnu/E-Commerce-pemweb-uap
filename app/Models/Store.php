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

    // Relasi ke Store Balance
    public function storeBalance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    // Relasi ke Transaction
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
    public function getStatusAttribute()
    {
        if ($this->deleted_at) {
            return 'rejected';
        }

        if ($this->is_verified) {
            return 'approved';
        }

        return 'pending';
    }
}