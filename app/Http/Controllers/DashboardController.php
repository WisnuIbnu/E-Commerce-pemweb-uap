<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data kategori (kode asli Anda)
        $categories = ProductCategory::withCount('products')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->take(6)
            ->get();
        
        // Tambahkan data produk dengan relasi kategori, ambil 12 terbaru
        $products = Product::with('productCategory')->latest()->take(12)->get();
        
        return view('dashboard', compact('categories', 'products'));
    }
}