<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductSellerController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store')
                ->with('error', 'You must create a store first.');
        }

        $products = Product::where('store_id', $store->id)
            ->with('productImages')
            ->latest()
            ->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\ProductCategory::all(); // ambil semua kategori
        return view('seller.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $store = Auth::user()->store;

        // jika seller belum punya store
        if (!$store) {
            return back()->with('error', 'Create your store first.');
        }

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'nullable|image|max:2048'
        ]);

        // SIMPAN PRODUK DENGAN STORE ID
        $product = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        // SIMPAN GAMBAR
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('product_images', 'public');

                $product->productImages()->create([
                    'image' => $path,
                    'is_thumbnail' => $key === 0,
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $request->validate([
            'product_category_id' => 'required|exists:product_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . time()),
            'description' => $request->description,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated');
    }

    public function destroy($id)
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.store');
        }

        $product = Product::where('store_id', $store->id)->findOrFail($id);

        foreach ($product->productImages as $img) {
            \Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted');
    }
}
