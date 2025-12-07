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
        'features',
        'condition',
        'price',
        'weight',
        'stock',
        'image',
    ];

    protected $casts = [
        'features' => 'array',
        'price' => 'decimal:2',
        'weight' => 'integer',
        'stock' => 'integer',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}