<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    // Sesuaikan dengan nama tabel di database Anda: 'withdrawals'
    protected $table = 'withdrawals'; 

    protected $fillable = [
        'store_balance_id', 
        'amount', 
        'bank_name', 
        'bank_account_name', 
        'bank_account_number', 
        'status'
    ];

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}