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
        'description',
        'features', // <-- tambahkan ini supaya mass assignment aman
        'condition',
        'price',
        'weight',
        'stock',
    ];

    /**
     * Cast fields ke tipe yang sesuai saat diakses
     * features akan otomatis jadi array ketika diambil dari DB
     */
    protected $casts = [
        'features' => 'array',
    ];

    // Relasi ke ProductCategory
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // ✅ RELASI ProductImage
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // Relasi lain jika ada
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
