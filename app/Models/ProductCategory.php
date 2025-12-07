<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    /**
     * Category has many Products
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'product_category_id');
    }

    /**
     * Parent Category
     */
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    /**
     * Child Categories
     */
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }
}