<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ============================================
    // RELATIONSHIPS
    // ============================================

    /**
     * User bisa punya 1 Store (untuk seller)
     */
    public function store()
    {
        return $this->hasOne(Store::class, 'user_id');
    }

    /**
     * User bisa punya 1 Buyer profile
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class, 'user_id');
    }

    /**
     * User bisa punya banyak Orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * User punya banyak Transactions (melalui Buyer)
     */
    public function transactions()
    {
        return $this->hasManyThrough(
            Transaction::class,
            Buyer::class,
            'user_id',      // Foreign key on buyers table
            'buyer_id',     // Foreign key on transactions table
            'id',           // Local key on users table
            'id'            // Local key on buyers table
        );
    }

    // ============================================
    // ACCESSORS (untuk helper attributes)
    // ============================================

    /**
     * Cek apakah user adalah admin
     */
    public function getIsAdminAttribute()
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user punya store (seller)
     */
    public function getIsSellerAttribute()
    {
        return $this->store()->exists();
    }

    /**
     * Get cart items count (untuk badge di header)
     * Nanti sesuaikan kalau sudah buat Cart model
     */
    public function getCartItemsCountAttribute()
    {
        // Sementara return 0, nanti ganti dengan:
        // return $this->cartItems()->count();
        return 0;
    }
}