<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = [
        'user_id',
        'profile_picture',
        'phone_number',
    ];

    /**
     * Buyer belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Buyer has many Transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}