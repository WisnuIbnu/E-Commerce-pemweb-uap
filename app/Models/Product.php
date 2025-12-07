<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'store_id',
        'product_category_id',
        'name',
        'slug',
        'description',
        'condition', // new or second (sesuai DB)
        'price',
        'weight', // gram
        'stock',
    ];

    protected $casts = [
        'price' => 'decimal:2', // Sesuai DB decimal(26,2)
        'weight' => 'integer',
        'stock' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            
            // Default condition untuk snack adalah 'new'
            if (empty($product->condition)) {
                $product->condition = 'new';
            }
        });
    }

    // Relationships
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

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Accessors
    public function getThumbnailAttribute()
    {
        $thumbnail = $this->images()->where('is_thumbnail', true)->first();
        
        if ($thumbnail) {
            return $thumbnail->image_url;
        }
        
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }
        
        return 'https://via.placeholder.com/300x300/98bad5/ffffff?text=Snack';
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?? 4.5, 1);
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->count();
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getIsAvailableAttribute()
    {
        return $this->stock > 0;
    }

    public function getConditionTextAttribute()
    {
        return $this->condition === 'new' ? 'Baru' : 'Bekas';
    }
}