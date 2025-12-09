<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SellerCategoryController extends Controller
{
   
    /**
     * Helper: ambil toko milik seller yang login.
     */
    protected function sellerStore()
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }

    /**
     * List kategori milik toko.
     */
    public function index()
    {
        $store = $this->sellerStore();

        $categories = ProductCategory::where('store_id', $store->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('seller.categories.index', [
            'store'      => $store,
            'categories' => $categories,
        ]);
    }

    /**
     * Simpan kategori baru.
     */
    public function store(Request $request)
    {
        $store = $this->sellerStore();

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $data['store_id'] = $store->id;
        $data['slug']     = Str::slug($data['name']);

        ProductCategory::create($data);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit kategori (kalau mau pakai halaman terpisah).
     */
    public function edit(ProductCategory $category)
    {
        $store = $this->sellerStore();

        abort_if($category->store_id !== $store->id, 403);

        return view('seller.categories.edit', [
            'store'    => $store,
            'category' => $category,
        ]);
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, ProductCategory $category)
    {
        $store = $this->sellerStore();

        abort_if($category->store_id !== $store->id, 403);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $category->update($data);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(ProductCategory $category)
    {
        $store = $this->sellerStore();

        abort_if($category->store_id !== $store->id, 403);

        // Optional: blok kalau masih ada produk di kategori ini
        if (method_exists($category, 'products') && $category->products()->exists()) {
            return back()->withErrors([
                'category' => 'Kategori masih memiliki produk, pindahkan dulu produknya.',
            ]);
        }

        $category->delete();

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
