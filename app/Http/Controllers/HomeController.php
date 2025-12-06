<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get trending products (latest 6 products)
        $trendingProducts = Product::with(['images', 'category', 'store'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();
        
        return view('home', compact('trendingProducts'));
    }
}

