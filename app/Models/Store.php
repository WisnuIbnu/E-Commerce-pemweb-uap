<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'about', // Sesuai DB (bukan description)
        'phone',
        'address_id', // Sesuai DB
        'city',
        'address',
        'postal_code',
        'is_verified', // 0 = pending, 1 = approved
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function balance()
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

    // Accessors
    public function getIsApprovedAttribute()
    {
        return $this->is_verified == 1;
    }

    public function getIsPendingAttribute()
    {
        return $this->is_verified == 0;
    }

    public function getStatusTextAttribute()
    {
        return $this->is_verified ? 'Approved' : 'Pending';
    }

    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('images/default-store.png');
        }
        
        if (str_starts_with($this->logo, ['http://', 'https://'])) {
            return $this->logo;
        }
        
        return asset('storage/' . $this->logo);
    }
}