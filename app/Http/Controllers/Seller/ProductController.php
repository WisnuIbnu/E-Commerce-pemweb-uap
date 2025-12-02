<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    // List produk milik seller
    public function index()
    {
        $store = Auth::user()->store;
        $products = Product::where('store_id', $store->id)->paginate(15);
        return view('seller.products.index', compact('products'));
    }

    // Form create produk baru
    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:productcategory,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'condition' => 'required|string',
            'description' => 'nullable|string',
            // additional fields seperti size_available, color, material dll bisa ditambahkan
        ]);

        $store = Auth::user()->store;

        $product = new Product();
        $product->store_id = $store->id;
        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->slug = Str::slug($request->name) . '-' . Str::random(6);
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->condition = $request->condition;
        $product->description = $request->description;
        $product->save();

        // Jika ada gambar
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public'); // asumsikan storage disk 'public'
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => false,
                ]);
            }
        }

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit produk
    public function edit($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product','categories'));
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:productcategory,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'condition' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $product->product_category_id = $request->product_category_id;
        $product->name = $request->name;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->weight = $request->weight;
        $product->condition = $request->condition;
        $product->description = $request->description;
        $product->save();

        // handle gambar jika ada upload baru
        if ($request->hasFile('images')) {
            // Optional: hapus gambar lama dulu
            foreach ($product->images as $img) {
                // Storage::delete('public/' . $img->image);
                $img->delete();
            }
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => false,
                ]);
            }
        }

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy($id)
    {
        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);

        // Optional: delete images files
        foreach ($product->images as $img) {
            // Storage::delete('public/' . $img->image);
            $img->delete();
        }

        $product->delete();

        return redirect()->route('seller.products.index')
                         ->with('success', 'Produk berhasil dihapus.');
    }
}
