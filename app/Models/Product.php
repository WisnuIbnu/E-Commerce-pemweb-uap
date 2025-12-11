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
        'condition',
        'price',
        'weight',
        'stock',
        'description',
    ];

    // Relasi ke gambar
    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    // Alias supaya di view customer bisa panggil $product->images
    public function images()
    {
        return $this->productImages();
    }

    // Relasi kategori
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    // Relasi store
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
