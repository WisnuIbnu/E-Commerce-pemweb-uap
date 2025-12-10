<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $products = Product::with(['category', 'images'])
            ->where('store_id', $store->id)
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'about' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $store = Auth::user()->store;
        
        $validated['store_id'] = $store->id;
        $validated['slug'] = Str::slug($validated['name']);
        
        $product = Product::create($validated);
        
        // Upload images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0,
                ]);
            }
        }
        
        return redirect('/seller/products')
            ->with('success', 'Product created successfully!');
    }
    
    public function edit($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $categories = ProductCategory::all();
        
        return view('seller.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'about' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $product->update($validated);
        
        // Upload new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => false,
                ]);
            }
        }
        
        return back()->with('success', 'Product updated successfully!');
    }
    
    public function destroy($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }
        
        $product->delete();
        
        return back()->with('success', 'Product deleted successfully!');
    }
    
    // Delete single image
    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        
        // Check ownership through product
        $product = $image->product;
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }
        
        Storage::disk('public')->delete($image->image);
        $image->delete();
        
        return response()->json(['success' => true]);
    }
    
    // Category Management
    public function categories()
    {
        $categories = ProductCategory::withCount('products')->paginate(10);
        return view('seller.categories.index', compact('categories'));
    }
    
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }
        
        ProductCategory::create($validated);
        
        return back()->with('success', 'Category created successfully!');
    }
    
    public function updateCategory(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $id,
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }
        
        $category->update($validated);
        
        return back()->with('success', 'Category updated successfully!');
    }
    
    public function destroyCategory($id)
    {
        $category = ProductCategory::findOrFail($id);
        
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with products');
        }
        
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();
        
        return back()->with('success', 'Category deleted successfully!');
    }
}