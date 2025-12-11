<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class Product extends Model
{

    protected $table = 'products';
    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'condition',
        'price',
        'weight',
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }
     public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', true);

    }
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
    public function productReviews()
    {
        return $this->hasMany(ProductReview::class);
    }
    public function averageRating()
    {
        // Mengambil rata-rata rating dari tabel product_reviews
        return round($this->productReviews()->avg('rating') ?? 0, 1);
    }
    public function totalReviews()
    {
        // Mengambil total ulasan
        return $this->productReviews()->count();
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
