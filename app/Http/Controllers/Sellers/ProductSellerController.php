<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductSellerController extends Controller
{
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->store->id)
            ->with('images', 'category')
            ->latest()
            ->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
            'images.*' => 'image|max:2048'
        ]);

        $store = Auth::user()->store;
        if (!$store) {
            return back()->with('error', 'You need to create a store first.');
        }

        $product = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach($request->file('images') as $index => $img) {
                $path = $img->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $index === 0 ? 1 : 0
                ]);
            }
        }

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)
            ->with('images')
            ->findOrFail($id);

        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);

        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|numeric',
            'description' => 'required',
        ]);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Product updated.');
    }

    public function destroy($id)
    {
        $product = Product::where('store_id', Auth::user()->store->id)->findOrFail($id);

        foreach ($product->images as $img) {
            Storage::disk('public')->delete($img->image);
            $img->delete();
        }

        $product->delete();

        return back()->with('success', 'Product deleted.');
    }
}
