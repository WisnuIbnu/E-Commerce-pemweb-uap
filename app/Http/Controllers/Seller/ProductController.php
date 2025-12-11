<?php

namespace App\Http\Controllers\Seller;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // ambil store milik user seller yg login
    protected function currentStore(): Store
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $store = $this->currentStore();

        $products = Product::with(['category', 'productImages'])
            ->where('store_id', $store->id)
            ->latest()
            ->get();

        return view('seller.products.index', compact('store', 'products'));
    }

    public function create()
    {
        $store = $this->currentStore();
        $categories = ProductCategory::all();

        return view('seller.products.create', compact('store', 'categories'));
    }

    public function store(Request $request)
    {
        $store = $this->currentStore();

        // Validasi input tanpa slug, condition, dan weight
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'price'               => ['required', 'numeric', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
            'image'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi gambar
        ]);

        // Menyimpan gambar produk jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Menyimpan produk baru
        $product = Product::create([
            'store_id'            => $store->id,
            'product_category_id' => $validated['product_category_id'],
            'name'                => $validated['name'],
            'slug'                => Str::slug($validated['name']) . '-' . uniqid(),
            'description'         => $validated['description'],
            'price'               => $validated['price'],
            'stock'               => $validated['stock'],
        ]);

        if ($imagePath) {
             ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
                'is_thumbnail' => true, 
             ]);
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('store', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        // Validasi input tanpa slug, condition, dan weight
        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'price'               => ['required', 'numeric', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
            'image'               => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Validasi gambar
        ]);

        // Jika gambar baru di-upload, hapus gambar lama dan simpan gambar baru
        // Jika gambar baru di-upload, hapus gambar lama dan simpan gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            $oldImage = $product->productImages()->where('is_thumbnail', true)->first();
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage->image);
                $oldImage->delete();
            }
            
            // Simpan gambar baru
            $imagePath = $request->file('image')->store('product_images', 'public');
            
             ProductImage::create([
                'product_id' => $product->id,
                'image' => $imagePath,
                'is_thumbnail' => true, 
             ]);
        }

        // Memperbarui data produk
        $product->update([
            'product_category_id' => $validated['product_category_id'],
            'name'                => $validated['name'],
            'slug'                => Str::slug($validated['name']) . '-' . uniqid(),
            'description'         => $validated['description'],
            'price'               => $validated['price'],
            'stock'               => $validated['stock'],
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        // Hapus gambar produk jika ada
        // Hapus gambar produk jika ada
        foreach($product->productImages as $img) {
             Storage::disk('public')->delete($img->image);
             $img->delete();
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted.');
    }
}
