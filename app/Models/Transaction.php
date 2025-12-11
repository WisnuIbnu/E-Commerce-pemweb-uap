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

    // Status pembayaran
    public const STATUS_PENDING              = 'pending';
    public const STATUS_WAITING_CONFIRMATION = 'waiting_confirmation';
    public const STATUS_PAID                 = 'paid';
    public const STATUS_FAILED               = 'failed';

    // Kalau pakai guarded, kosongin saja (boleh juga dihapus)
    protected $guarded = [];

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

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Label status buat ditampilkan di view
    public function getStatusLabelAttribute()
    {
        return match ($this->payment_status) {
            self::STATUS_PENDING              => 'Menunggu Pembayaran',
            self::STATUS_WAITING_CONFIRMATION => 'Menunggu Konfirmasi Admin',
            self::STATUS_PAID                 => 'Sudah Dibayar',
            self::STATUS_FAILED               => 'Gagal',
            default                           => ucfirst($this->payment_status),
        };
    }

    public function getStatusBadgeClassAttribute()
    {
        return match ($this->payment_status) {

            self::STATUS_PENDING => '
                inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                bg-orange-50 text-orange-700 border border-orange-200
            ',

            self::STATUS_WAITING_CONFIRMATION => '
                inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                bg-blue-50 text-blue-700 border border-blue-200
            ',

            self::STATUS_PAID => '
                inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                bg-green-50 text-green-700 border border-green-200
            ',

            self::STATUS_FAILED => '
                inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                bg-red-50 text-red-700 border border-red-200
            ',

            default => '
                inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                bg-gray-50 text-gray-700 border border-gray-200
            ',
        };
    }
}
