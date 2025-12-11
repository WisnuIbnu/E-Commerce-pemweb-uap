<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'image',
        'name',
        'slug',
        'tagline',
        'description',
    ];

    // RELASI KE PRODUK
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // RELASI KE SUB CATEGORY
    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    // RELASI KE PARENT CATEGORY
    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }
}
