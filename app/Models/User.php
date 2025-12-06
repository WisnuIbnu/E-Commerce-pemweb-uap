<?php
// app/Models/User.php - ADD THIS RELATIONSHIP

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the store owned by the user
     */
    public function store(): HasOne
    {
        return $this->hasOne(Store::class, 'buyer_id');
    }

    /**
     * Get user's transactions (as buyer)
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }

    /**
     * Get user's reviews
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user has a store
     */
    public function hasStore(): bool
    {
        return $this->store !== null;
    }

    /**
     * Check if user has an approved store
     */
    public function hasApprovedStore(): bool
    {
        return $this->hasStore() && $this->store->isApproved();
    }
}
