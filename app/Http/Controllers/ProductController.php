<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // --- PUBLIC METHODS ---
    public function publicHome()
        {
            // Ambil 4 kategori teratas
            $categories = \App\Models\ProductCategory::take(6)->get();
            
            // Ambil 8 produk terbaru dengan gambarnya
            $products = \App\Models\Product::with('images')->latest()->take(8)->get();

            return view('landing', compact('categories', 'products'));
        }
    // public function publicHome()
    // {
    //     // Task 1: 8 Produk terbaru dengan Eager Loading (N+1 Solution)
    //     $products = Product::with(['category', 'images'])
    //         ->latest()
    //         ->take(8)
    //         ->get();
        
    //     $categories = ProductCategory::all();

    //     return view('landing', compact('products', 'categories'));
    // }

    public function index()
    {
        // Task 1: List Produk dengan Pagination
        $products = Product::with(['category', 'images'])
            ->latest()
            ->paginate(12);
            
        return view('user.products.index', compact('products'));
    }

    public function show($id)
    {
        // Task 2: Detail Produk
        $product = Product::with(['images', 'category', 'store'])
            ->findOrFail($id);

        return view('user.products.show', compact('product'));
    }

    // --- SELLER METHODS (Task 7) ---

    public function sellerIndex()
    {
        $storeId = Auth::user()->store->id;
        $products = Product::where('store_id', $storeId)
            ->with(['category', 'images'])
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Ensure Seller logic
        $storeId = $user->store->id;

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        // Generate Unique Slug
        $slug = Str::slug($request->name);
        $count = Product::where('slug', $slug)->count();
        if($count > 0) {
            $slug = $slug . '-' . time();
        }

        Product::create([
            'store_id' => $storeId,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dibuat.');
    }

    public function edit($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Otorisasi Ketat: Hanya produk milik toko user yang bisa diedit
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
        ]);

        $data = $request->except(['slug', 'store_id']); // Protect critical fields

        // Update Slug jika nama berubah
        if ($request->name !== $product->name) {
            $slug = Str::slug($request->name);
            $count = Product::where('slug', $slug)->where('id', '!=', $id)->count();
            if($count > 0) $slug .= '-' . time();
            $data['slug'] = $slug;
        }

        $product->update($data);

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);
        // Hapus gambar jika perlu (logic di ProductImageController lebih spesifik)
        $product->delete();
        return back()->with('success', 'Produk dihapus.');
    }
}