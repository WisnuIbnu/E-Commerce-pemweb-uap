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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id', 'id');
    }

    public function getNameAttribute()
    {
        return $this->user->name ?? 'Guest';
    }

    public function getEmailAttribute()
    {
        return $this->user->email ?? '-';
    }
}