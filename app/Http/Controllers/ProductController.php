<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // Menampilkan semua produk (Homepage Customer)
    public function index()
    {
        $products = Product::with('store', 'category')->latest()->get();
        return view('products.index', compact('products'));
    }

    // Menampilkan detail produk (Customer)
    public function show($slug)
    {
        $product = Product::with('store', 'category', 'reviews')->where('slug', $slug)->firstOrFail();
        return view('products.show', compact('product'));
    }

    // Menampilkan produk berdasarkan kategori (Customer)
    public function category($id)
    {
        $category = ProductCategory::findOrFail($id);
        $products = Product::with('store', 'category')
                           ->where('product_category_id', $id)
                           ->latest()
                           ->get();
        return view('products.category', compact('category', 'products'));
    }

    // Form tambah produk (Seller)
    public function create()
    {
        $categories = ProductCategory::all();
        return view('products.create', compact('categories'));
    }

    // Simpan produk (Seller)
    public function store(Request $request)
    {
        $data = $request->validate([
            'store_id' => 'required|exists:stores,id',
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric',
            'weight' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048', // optional upload gambar
        ]);

        // Handle upload gambar (opsional)
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug'] = Str::slug($request->name) . '-' . uniqid();

        Product::create($data);

        return redirect()->route('product.show', $data['slug'])->with('success', 'Product berhasil dibuat!');
    }
}
