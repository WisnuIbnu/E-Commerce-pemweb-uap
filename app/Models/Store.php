<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function balance()
    {
        return $this->hasOne(StoreBalance::class);
    }

    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo && file_exists(public_path($this->logo))) {
            return asset($this->logo);
        }
        return asset('images/default-store-logo.png');
    }

    public static function hasStore($userId)
    {
        return self::where('user_id', $userId)->exists();
    }
}