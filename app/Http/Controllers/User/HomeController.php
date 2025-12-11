<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    /**
     * Dashboard - Halaman utama setelah login
     */
    public function dashboard(Request $request)
    {
        $query = Product::with(['store', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('stock', '>', 0); // Hanya produk yang ada stoknya

        // Filter berdasarkan kategori jika ada
        if ($request->has('category') && $request->category) {
            $query->where('product_category_id', $request->category);
        }

        // Search jika ada
        if ($request->has('q') && $request->q) {
            $keyword = $request->q;
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                  ->orWhere('description', 'LIKE', "%{$keyword}%");
            });
        }

        $products = $query->latest('created_at')->paginate(12);
        $categories = ProductCategory::all();

        return view('pages.dashboard', compact('products', 'categories'));
    }

    /**
     * Marketplace - Halaman kategori/brand tumbler
     */
    public function marketplace()
    {
        // Ambil semua kategori dengan jumlah produk
        $categories = ProductCategory::withCount('products')
            ->orderBy('name')
            ->get();

        return view('pages.marketplace', compact('categories'));
    }

    /**
     * Category Show - Tampilkan produk berdasarkan kategori
     */
    public function category($slug)
    {
        $category = ProductCategory::where('slug', $slug)->firstOrFail();
        
        $products = Product::where('product_category_id', $category->id)
            ->with(['store', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        $allCategories = ProductCategory::all();

        return view('pages.category-products', compact('category', 'products', 'allCategories'));
    }

    /**
     * Search - Pencarian produk
     */
    public function search(Request $request)
    {
        $keyword = $request->get('q');
        
        $products = Product::where(function($query) use ($keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")
                      ->orWhere('description', 'LIKE', "%{$keyword}%");
            })
            ->with(['store', 'images'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        $categories = ProductCategory::all();

        return view('pages.dashboard', compact('products', 'categories', 'keyword'));
    }

    /**
     * Categories - Halaman semua kategori
     */
    public function categories()
    {
        $categories = ProductCategory::withCount('products')
            ->orderBy('name')
            ->get();

        return view('pages.categories', compact('categories'));
    }
}