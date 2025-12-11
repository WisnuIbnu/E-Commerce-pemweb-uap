<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $fillable = ['store_id', 'balance'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function histories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }
}