<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMember()
    {
        return $this->role === 'member';
    }

    // Cek apakah user adalah seller (punya store yang status-nya active)
    public function isSeller()
    {
        return $this->store && $this->store->status === 'active';
        // atau kalau mau benar2 pakai query:
        // return $this->store()->where('status', 'active')->exists();
    }

    // relationships

    public function buyer()
    {
        return $this->hasOne(Buyer::class);
    }

    // Satu user punya satu store, foreign key = owner_id di tabel stores
    public function store()
    {
        return $this->hasOne(Store::class, 'owner_id');
    }
}
