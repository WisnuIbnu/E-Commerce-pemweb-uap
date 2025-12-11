<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'image', 'is_thumbnail'];

    protected $casts = ['is_thumbnail' => 'boolean'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}