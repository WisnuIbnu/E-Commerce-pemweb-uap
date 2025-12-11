<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['store', 'images', 'category', 'reviews.user'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

        // Get related products from same store or category
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
                $query->where('store_id', $product->store_id)
                      ->orWhere('product_category_id', $product->product_category_id);
            })
            ->with(['store', 'images'])
            ->limit(4)
            ->get();

        return view('user.product.show', compact('product', 'relatedProducts'));
    }
}