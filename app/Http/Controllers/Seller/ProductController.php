<?php
// app/Http/Controllers/Seller/ProductController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = $store->products()
            ->with(['category', 'images'])
            ->latest()
            ->paginate(12);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'season' => 'required|in:summer,winter,spring,fall,all',
            'images.*' => 'nullable|image|max:2048'
        ]);

        $validated['store_id'] = auth()->user()->store->id;
        
        $product = Product::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $index === 0,
                    'order' => $index
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully!');
    }

    public function edit(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'season' => 'required|in:summer,winter,spring,fall,all'
        ]);

        $product->update($validated);

        return redirect()->route('seller.products.edit', $product)
            ->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    public function show(Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $product->load(['category', 'images', 'reviews.user']);
        
        return view('seller.products.show', compact('product'));
    }
}

