<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Buyer;
use App\Models\Store;
use App\Models\TransactionDetail;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'code',
        'buyer_id',
        'store_id',
        'address',
        'address_id',
        'city',
        'postal_code',
        'shipping',
        'shipping_type',
        'shipping_cost',
        'tracking_number',
        'tax',
        'grand_total',
        'payment_status',
        'payment_method',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_PAID    = 'paid';
    public const STATUS_FAILED  = 'failed';

    public function buyer()
    {
        return $this->belongsTo(Buyer::class, 'buyer_id');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            self::STATUS_PENDING => 'Menunggu Pembayaran',
            self::STATUS_PAID    => 'Sudah Dibayar',
            self::STATUS_FAILED  => 'Gagal',
            default              => ucfirst($this->payment_status),
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->payment_status) {
            self::STATUS_PENDING => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800',
            self::STATUS_PAID    => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800',
            self::STATUS_FAILED  => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800',
            default              => 'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800',
        };
    }
}
