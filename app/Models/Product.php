<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
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
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Product belongs to Store
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Product belongs to Category
     */
    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    /**
     * Product has many Images
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Product has many Reviews
     */
    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    /**
     * Get thumbnail image
     */
    public function getThumbnailAttribute()
    {
        return $this->images()->where('is_thumbnail', true)->first();
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }
}