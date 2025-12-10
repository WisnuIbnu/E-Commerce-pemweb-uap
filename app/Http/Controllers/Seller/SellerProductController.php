<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index()
    {
        // PERBAIKAN 1: Menggunakan 'productCategory' sesuai nama fungsi di Model
        $products = Product::where('store_id', Auth::user()->store->id)
            ->with('productCategory') 
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
        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'category_id'   => 'required|exists:product_categories,id', // Input form tetap 'category_id' tidak apa-apa
            'about'         => 'required|string',
            'thumbnail'     => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048', 
        ]);

        DB::transaction(function () use ($request) {
            
            $thumbnailPath = $request->file('thumbnail')->store('product_thumbnails', 'public');
            $slug = Str::slug($request->name) . '-' . Str::random(5);

            Product::create([
                'store_id'            => Auth::user()->store->id,
                
                // PERBAIKAN 2: Masukkan ke kolom 'product_category_id'
                'product_category_id' => $request->category_id, 
                
                'name'                => $request->name,
                'slug'                => $slug,
                'price'               => $request->price,
                'stock'               => $request->stock,
                'about'               => $request->about,
                'thumbnail'           => $thumbnailPath,
            ]);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('product_photos', 'public');
                    ProductImage::create([
                        'product_id' => $product->id ?? Product::where('slug', $slug)->first()->id, // Fallback ID retrieval
                        'photo'      => $path,
                    ]);
                }
            }
        });

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $request->validate([
            'name'          => 'required|string|max:255',
            'price'         => 'required|numeric|min:0',
            'stock'         => 'required|integer|min:0',
            'category_id'   => 'required|exists:product_categories,id',
            'about'         => 'required|string',
            'thumbnail'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photos.*'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($request, $product) {
            
            $data = [
                'name'                => $request->name,
                'slug'                => Str::slug($request->name) . '-' . Str::random(5),
                'price'               => $request->price,
                'stock'               => $request->stock,
                'about'               => $request->about,
                
                // PERBAIKAN 3: Update ke kolom 'product_category_id'
                'product_category_id' => $request->category_id,
            ];

            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $request->file('thumbnail')->store('product_thumbnails', 'public');
            }

            $product->update($data);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('product_photos', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'photo'      => $path,
                    ]);
                }
            }
        });

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        $product->delete();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}