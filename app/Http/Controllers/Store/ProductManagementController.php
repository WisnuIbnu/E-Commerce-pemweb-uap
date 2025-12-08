<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductManagementController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = $store->products()
            ->with('category', 'images')
            ->latest()
            ->paginate(10);

        return view('store.product.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('store.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'image.required' => 'Foto produk wajib diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $store = auth()->user()->store;

        // Create product
        $product = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        // Upload and save image to product_images table
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/stores', $imageName, 'public');
            
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
                'is_thumbnail' => 1, // Set as thumbnail since it's the first/only image
            ]);
        }

        return redirect()->route('store.products.index')
            ->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;
        $product = $store->products()->with('images')->findOrFail($id);
        $categories = ProductCategory::all();

        return view('store.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'description' => 'required|string',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($id);

        // Update product
        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        // If new image uploaded, replace the old one
        if ($request->hasFile('image')) {
            // Delete old images
            foreach ($product->images as $oldImage) {
                Storage::disk('public')->delete($oldImage->image);
                $oldImage->delete();
            }

            // Upload new image
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $imagePath = $image->storeAs('images/stores', $imageName, 'public');
            
            ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
                'is_thumbnail' => 1,
            ]);
        }

        return redirect()->route('store.products.index')
            ->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($id);

        // Delete all product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('store.products.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}