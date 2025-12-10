<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    protected $fillable = [
        'store_id',
        'balance',
    ];

    // biar setiap kali diambil, balance jadi decimal 2 angka di belakang koma
    protected $casts = [
        'balance' => 'decimal:2',
    ];

    // 1 saldo dimiliki oleh 1 store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // riwayat perubahan saldo (kalau kamu pakai StoreBalanceHistory)
    public function histories() // boleh juga namanya storeBalanceHistories()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    // semua withdrawal dari saldo ini
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }
}
