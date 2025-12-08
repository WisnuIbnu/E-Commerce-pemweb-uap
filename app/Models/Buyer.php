<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Transaction;

class Buyer extends Model
{
    protected $table = 'buyers';

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
        // kalau di tabel buyers kamu ada kolom lain (address, city, postal_code),
        // bisa ditambah di sini juga
        // 'address',
        // 'city',
        // 'postal_code',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }
}
