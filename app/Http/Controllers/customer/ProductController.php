<?php

namespace App\Http\Controllers\Customer;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function show($id)
    {
        // Eager-load productCategory dan productImages
        $product = Product::with(['productCategory', 'productImages'])->findOrFail($id);

        // Related products (eager-load juga untuk thumbnails)
        $relatedProducts = Product::with(['productCategory', 'productImages'])
            ->where('product_category_id', $product->product_category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();

        return view('customer.product.detail', compact('product', 'relatedProducts'));
    }
}
