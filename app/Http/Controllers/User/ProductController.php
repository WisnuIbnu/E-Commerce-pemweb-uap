<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['store', 'category', 'images', 'reviews.user'])
            ->findOrFail($id);

        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $product->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('user.product.show', compact('product', 'relatedProducts'));
    }
}
