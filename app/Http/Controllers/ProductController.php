<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::with([
            'productImages',
            'productCategory',
            'store',
            'productReviews.buyer.user'
        ])->where('slug', $slug)->firstOrFail();

        return view('product', compact('product'));
    }
}
