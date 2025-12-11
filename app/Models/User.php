<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @property \App\Models\Buyer $buyer
     * @property \App\Models\Store $store
     */

    /**
     * Kolom yang dapat diisi mass-assignment
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // member | seller | admin
    ];

    /**
     * Kolom yang disembunyikan dari array/json
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi: 1 user mempunyai 1 buyer profile (role member)
     */
    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

    /**
     * Relasi: 1 user mempunyai 1 store (role seller)
     */
    public function store()
    {
        return $this->hasOne(Store::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSeller()
    {
        return $this->role === 'seller';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }
}