<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBalance extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function history()
    {
        return $this->hasMany(StoreBalanceHistory::class);
    }

    // ✅ Tambahkan relasi ke withdrawals
    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class, 'store_balance_id', 'id');
    }

    // Method untuk menambah saldo
    public function addBalance($amount, $referenceType, $referenceId, $remarks = null)
    {
        $this->increment('balance', $amount);

        // Catat ke history
        $this->history()->create([
            'type' => 'income',
            'reference_id' => $referenceId,
            'reference_type' => $referenceType,
            'amount' => $amount,
            'remarks' => $remarks,
        ]);

        return $this;
    }

    // Method untuk mengurangi saldo
    public function deductBalance($amount, $referenceType, $referenceId, $remarks = null)
    {
        if ($this->balance >= $amount) {
            $this->decrement('balance', $amount);

            // Catat ke history
            $this->history()->create([
                'type' => 'withdraw',
                'reference_id' => $referenceId,
                'reference_type' => $referenceType,
                'amount' => $amount,
                'remarks' => $remarks,
            ]);

            return true;
        }
        return false;
    }
}