<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori produk
        $categories = ProductCategory::all();

        // Tampilkan view dengan data kategori produk
        return view('seller.categories.index', compact('categories'));
    }
}
