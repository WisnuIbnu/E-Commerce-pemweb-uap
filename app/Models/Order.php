<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Tentukan tabel yang digunakan jika tidak mengikuti konvensi Laravel
    protected $table = 'orders';

    // Tentukan kolom yang dapat diisi (Mass Assignment)
    protected $fillable = [
        'store_id', 
        'user_id', // id pembeli atau user
        'total_price', 
        'status', 
        'shipping_address', 
        'payment_status', 
        'shipping_status',
        // tambahkan kolom lain yang relevan dengan pesanan
    ];

    // Relasi dengan tabel Store (setiap Order milik satu Store)
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // Relasi dengan tabel User (setiap Order dimiliki oleh satu User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan tabel OrderDetails atau produk dalam order (jika ada)
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
