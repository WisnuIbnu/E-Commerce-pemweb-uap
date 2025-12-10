<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::with('thumbnail')
            ->where('stock', '>', 0)
            ->latest()
            ->get();

        return view('customer.home', compact('products'));
    }
}
