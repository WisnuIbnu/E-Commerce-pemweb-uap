<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori.
     */
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        // Cek apakah toko sudah terverifikasi
        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        $categories = ProductCategory::with('parent', 'children')
            ->latest()
            ->paginate(15);

        return view('seller.categories.index', compact('categories', 'store'));
    }

    /**
     * Tampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        // Ambil semua kategori untuk dropdown kategori induk
        $parentCategories = ProductCategory::whereNull('parent_id')->get();

        return view('seller.categories.create', compact('store', 'parentCategories'));
    }

    /**
     * simpan kategori yang baru dibuat ke storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'parent_id'   => ['nullable', 'exists:product_categories,id'],
            'tagline'     => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // Generate slug unik
        $slug = Str::slug($validated['name']);
        $count = ProductCategory::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $validated['slug'] = $slug;

        // tambahkan gambar jika ada
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        ProductCategory::create($validated);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dibuat.');
    }

    /**
     * Tampilkan form untuk mengedit kategori yang ditentukan.
     */
    public function edit(ProductCategory $category)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        // Ambil parent categories (exclude kategori yang sedang diedit dan anak-anaknya)
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->get();

        return view('seller.categories.edit', compact('category', 'parentCategories', 'store'));
    }

    /**
     * update kategori yang ditentukan di storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'parent_id'   => ['nullable', 'exists:product_categories,id'],
            'tagline'     => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'max:2048'],
        ]);

        // update slug jika nama diubah
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $count = ProductCategory::where('slug', 'LIKE', "{$slug}%")
                ->where('id', '!=', $category->id)
                ->count();
            if ($count > 0) {
                $slug = $slug . '-' . ($count + 1);
            }
            $validated['slug'] = $slug;
        }

        // tambahkan gambar jika ada
        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * hapus kategori dari storage.
     */
    public function destroy(ProductCategory $category)
    {
        $user = Auth::user();
        $store = $user->store;

        if (!$store || !$store->is_verified) {
            return redirect()->route('store.pending.verification');
        }

        // cek jika kategori ini punya produk
        if ($category->products()->count() > 0) {
            return redirect()
                ->route('seller.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        // cek jika kategori ini punya sub-kategori
        if ($category->children()->count() > 0) {
            return redirect()
                ->route('seller.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki sub-kategori.');
        }

        // hapus gambar jika ada
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()
            ->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}