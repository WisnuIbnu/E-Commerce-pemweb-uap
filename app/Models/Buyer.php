<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
    ];

    /**
     * Relasi: buyer dimiliki oleh user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: buyer memiliki banyak transaksi
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}