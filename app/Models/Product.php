<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'about',
        'description',
        'condition',
        'price',
        'weight',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Relasi: product dimiliki store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Relasi: product milik kategori
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Relasi: product memiliki banyak gambar
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', 1);
    }

    /**
     * Relasi: product memiliki banyak review
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Relasi: product muncul di banyak transaction detail
     */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}