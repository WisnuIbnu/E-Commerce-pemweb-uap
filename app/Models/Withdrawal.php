<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Withdrawal extends Model
{
    // Kolom yang boleh di–mass assign (create/update)
    protected $fillable = [
        'store_balance_id',
        'amount',
        'bank_account_name',
        'bank_account_number',
        'bank_name',
        'status',
    ];

    // Casting tipe data
    protected $casts = [
        'amount' => 'decimal:2',   // supaya selalu dibaca sebagai decimal 2 angka di belakang koma
    ];

    public const STATUS_PENDING  = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public function storeBalance()
    {
        return $this->belongsTo(StoreBalance::class);
    }
}
