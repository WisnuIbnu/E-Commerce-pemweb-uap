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
        'condition',
        'price',
        'weight',
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'integer',
        'stock' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
     * Get the thumbnail image
     */
    public function thumbnail()
    {
        return $this->hasOne(ProductImage::class)->where('is_thumbnail', 1);
    }

    /**
     * Get the product image URL (thumbnail or first image)
     * Sesuaikan dengan lokasi penyimpanan gambar
     */
    public function getImageUrlAttribute()
    {
        $thumbnail = $this->thumbnail;
        if ($thumbnail) {
            return asset($thumbnail->image); 
        }

        $firstImage = $this->images()->first();
        if ($firstImage) {
            return asset($firstImage->image);
        }

        return asset('images/placeholder.png');
    }

    /**
     * Check if product is in stock
     */
    public function isInStock()
    {
        return $this->stock > 0;
    }

    /**
     * Check if product is low stock (less than 5)
     */
    public function isLowStock()
    {
        return $this->stock > 0 && $this->stock < 5;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get condition label in Indonesian
     */
    public function getConditionLabelAttribute()
    {
        return $this->condition === 'new' ? 'Baru' : 'Bekas';
    }

    /**
     * Get condition badge class
     */
    public function getConditionBadgeClassAttribute()
    {
        return $this->condition === 'new' 
            ? 'bg-green-500 bg-opacity-20 text-green-400' 
            : 'bg-yellow-500 bg-opacity-20 text-yellow-400';
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    /**
     * Scope untuk produk yang in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope untuk produk by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('product_category_id', $categoryId);
    }

    /**
     * Scope untuk produk by store
     */
    public function scopeByStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Scope untuk search produk
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where('name', 'like', '%' . $keyword . '%')
                     ->orWhere('description', 'like', '%' . $keyword . '%');
    }
}