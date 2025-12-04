<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductManagementController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $products = $store->products()
            ->with('category')
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
            'about' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $store = auth()->user()->store;

        Product::create([
            'store_id' => $store->id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'about' => $request->about,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return redirect()->route('store.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit($id)
    {
        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($id);
        $categories = ProductCategory::all();

        return view('store.product.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'about' => 'required|string',
            'condition' => 'required|in:new,used',
            'price' => 'required|numeric|min:0',
            'weight' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($id);

        $product->update([
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . Str::random(5),
            'about' => $request->about,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return redirect()->route('store.products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
    {
        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($id);

        // Delete product images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
            $image->delete();
        }

        $product->delete();

        return redirect()->route('store.products.index')
            ->with('success', 'Product deleted successfully');
    }
}