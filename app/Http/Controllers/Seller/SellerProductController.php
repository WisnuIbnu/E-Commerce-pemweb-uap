<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    /**
     * Ambil store milik seller yang sedang login.
     */
    protected function sellerStore()
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * Tampilkan daftar produk milik seller.
     */
    public function index()
    {
        $store = $this->sellerStore();

        $products = \App\Models\Product::with('category')
        ->where('store_id', $store->id)
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('seller.products.index', compact('store', 'products'));
    }

    /**
     * Form tambah produk baru.
     */
    public function create()
    {
        $store = $this->sellerStore();
        $categories = ProductCategory::all(); // sesuaikan nama model kategori kamu

        return view('seller.products.create', compact('store', 'categories'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request)
    {
        $store = $this->sellerStore();

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:product_categories,id'], // sesuaikan nama tabel
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'weight'      => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // Handle upload gambar utama (opsional)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // Generate slug (bisa disesuaikan)
        $slugBase = Str::slug($validated['name']);
        $slug = $slugBase;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $counter++;
        }

        Product::create([
            'store_id'     => $store->id,
            'product_category_id'  => $validated['category_id'],
            'name'         => $validated['name'],
            'slug'         => $slug,
            'price'        => $validated['price'],
            'stock'        => $validated['stock'],
            'weight'       => $validated['weight'],
            'description'  => $validated['description'] ?? null,
            'image'        => $imagePath,
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Form edit produk.
     */
    public function edit(Product $product)
    {
        $store = $this->sellerStore();

        // Pastikan produk ini milik store yang login
        if ($product->store_id !== $store->id) {
            abort(403);
        }

        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('store', 'product', 'categories'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Product $product)
    {
        $store = $this->sellerStore();

        if ($product->store_id !== $store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:product_categories,id'],
            'price'       => ['required', 'numeric', 'min:0'],
            'stock'       => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // Kalau upload gambar baru, hapus yang lama
        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->name        = $validated['name'];
        $product->product_category_id = $validated['category_id'];
        $product->price       = $validated['price'];
        $product->stock       = $validated['stock'];
        $product->description = $validated['description'] ?? null;

        $product->save();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Product $product)
    {
        $store = $this->sellerStore();

        if ($product->store_id !== $store->id) {
            abort(403);
        }

        // Hapus gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()
            ->route('seller.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
