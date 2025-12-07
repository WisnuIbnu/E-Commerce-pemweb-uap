<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    // halaman /products
    public function index()
    {
        $products = Product::with(['store', 'category'])
            ->latest()
            ->paginate(9);

        return view('user.products.products', compact('products'));
        // sesuaikan dengan path blade kamu
    }
}
