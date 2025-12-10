<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class SellerCategoryController extends Controller
{
    public function index()
    {
        $store = getSellerStore();
        $categories = Category::where('store_id', $store->id)
            ->withCount('products')
            ->latest()
            ->get();
        
        return view('seller.categories.index', compact('categories', 'store'));
    }

    public function create()
    {
        $store = getSellerStore();
        return view('seller.categories.create', compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = getSellerStore();

        Category::create([
            'store_id' => $store->id,
            'name' => $request->name,
        ]);

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $store = getSellerStore();
        $category = Category::where('store_id', $store->id)->findOrFail($id);
        
        return view('seller.categories.edit', compact('category', 'store'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $store = getSellerStore();
        $category = Category::where('store_id', $store->id)->findOrFail($id);

        $category->update(['name' => $request->name]);

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $store = getSellerStore();
        $category = Category::where('store_id', $store->id)->findOrFail($id);
        
        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('seller.categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        $category->delete();

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}