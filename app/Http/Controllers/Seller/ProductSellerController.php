<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
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

        $products = Product::where('store_id', $store->id)->with('category')->get();

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $store = Auth::user()->store;
        $categories = ProductCategory::all();

        return view('seller.products.create', compact('categories', 'store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_category_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|integer',
            'images.*' => 'image|max:2048'
        ]);

        $store = Auth::user()->store;

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

        if ($request->has('images')) {
            foreach ($request->images as $img) {
                $fileName = time() . '-' . $img->getClientOriginalName();
                $img->move(public_path('uploads/products'), $fileName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileName,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = ProductCategory::all();
        $images = ProductImage::where('product_id', $id)->get();

        return view('seller.products.edit', compact('product', 'categories', 'images'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_category_id' => 'required',
            'name' => 'required|max:255',
            'description' => 'required',
            'condition' => 'required',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|integer',
            'images.*' => 'image|max:2048'
        ]);

        $product = Product::findOrFail($id);

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

        if ($request->has('images')) {
            foreach ($request->images as $img) {
                $fileName = time() . '-' . $img->getClientOriginalName();
                $img->move(public_path('uploads/products'), $fileName);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $fileName,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // hapus gambar
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $img) {
            @unlink(public_path('uploads/products/' . $img->image));
            $img->delete();
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}
