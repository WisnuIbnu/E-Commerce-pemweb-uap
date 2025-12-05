<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil produk dengan stok lebih dari 0 dan batasi 12 produk terbaru
        // Include relasi store dan images untuk menampilkan info toko dan gambar produk
        $products = Product::with(['store', 'images'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(12)
            ->get();
        
        // Filter manual produk yang memiliki toko (jika ada yang tidak punya toko)
        $products = $products->filter(function($product) {
            return $product->store !== null;
        });
        
        // Ambil semua kategori produk untuk ditampilkan di section kategori
        $categories = ProductCategory::all();
        
        // Kirim data produk dan kategori ke halaman welcome
        return view('welcome', compact('products', 'categories'));
    }
}