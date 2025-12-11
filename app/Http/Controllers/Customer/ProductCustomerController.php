<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductCustomerController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        $products = Product::with('images', 'category')
            ->latest()
            ->get();

        return view('customer.products.index', compact('products'));
    }

    // Tampilkan detail satu produk berdasarkan slug
    public function show($slug)
    {
        $product = Product::with('images', 'category')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('customer.products.show', compact('product'));
    }

    // Tampilkan produk berdasarkan kategori
    public function category($id)
    {
        $products = Product::with('images', 'category')
            ->where('product_category_id', $id)
            ->latest()
            ->get();

        return view('customer.products.index', compact('products'));
    }
}
