<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products (latest 8 products)
        $products = Product::with(['category', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->limit(8)
            ->get();
        
        // Get all categories with product count
        $categories = ProductCategory::withCount('products')
            ->orderBy('name')
            ->get();
        
        return view('home', compact('products', 'categories'));
    }
    
    public function about()
    {
        return view('about');
    }
    
    public function contact()
    {
        return view('contact');
    }
}