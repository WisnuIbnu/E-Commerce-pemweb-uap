<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class BuyerDashboardController extends Controller
{
    public function index()
    {
        // Ambil semua kategori
        $categories = ProductCategory::all();
        
        // Ambil produk terbaru yang ada stock (limit 8 untuk homepage)
        $products = Product::with(['store', 'images', 'category'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(8)
            ->get();
        
        return view('buyer.dashboard', compact('categories', 'products'));
    }
}