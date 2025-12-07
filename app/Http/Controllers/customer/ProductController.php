<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with('productCategory')->findOrFail($id);
        
        // Related products (produk sejenis)
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();
        
        return view('customer.product.detail', compact('product', 'relatedProducts'));
    }
}