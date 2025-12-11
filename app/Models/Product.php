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
        'features', // mass assignment aman
        'condition',
        'price',
        'weight',
        'stock',
        'image',
    ];

    /**
     * Cast fields ke tipe yang sesuai saat diakses
     * features akan otomatis jadi array ketika diambil dari DB
     */
    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'weight' => 'integer',
        'stock' => 'integer',
    ];

    // Relasi ke ProductCategory
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // Relasi ke Store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // RELASI ProductImage
    public function productImages()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

}
