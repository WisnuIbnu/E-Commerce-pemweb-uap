<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $products = Product::where('store_id', $store->id)
            ->with('images')
            ->latest()
            ->paginate(10);

        return view('seller.products.index', compact('products', 'store'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        return view('seller.products.create', compact('store'));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|numeric|min:0',
            'desc' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product = Product::create([
            'store_id' => $store->id,
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->desc,
        ]);

        // SIMPAN GAMBAR
        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $store = auth()->user()->store;

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }

        return view('seller.products.edit', compact('product', 'store'));
    }

    public function update(Request $request, Product $product)
    {
        $store = auth()->user()->store;

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|numeric|min:0',
            'desc' => 'nullable|string',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->desc,
        ]);

        // TAMBAH GAMBAR BARU
        if ($request->hasFile('images')) {
            foreach ($request->images as $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $path
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        $store = auth()->user()->store;

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized');
        }

        // HAPUS FILE GAMBAR
        foreach ($product->images as $img) {
            Storage::delete('public/' . $img->image_url);
        }

        // HAPUS RECORD GAMBAR
        $product->images()->delete();

        // HAPUS PRODUK
        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
