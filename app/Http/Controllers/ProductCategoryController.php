<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    // ======================
    // HALAMAN KATEGORI (WEB)
    // ======================
    public function index()
    {
        $categories = ProductCategory::whereNull('parent_id')->get();

        return view('user.categories.index', compact('categories'));
    }

    // ======================
    // HALAMAN PRODUK PER KATEGORI
    // ======================
    public function listProducts($id)
    {
        $category = ProductCategory::with('products')->findOrFail($id);

        return view('user.categories.products', compact('category'));
    }

    // ======================
    // API STORE CATEGORY
    // ======================
    public function store(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string',
            'description' => 'required|string',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category = ProductCategory::create([
            'parent_id' => $request->parent_id,
            'image' => $imagePath,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'tagline' => $request->tagline,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan');
    }

    // ======================
    // UPDATE CATEGORY
    // ======================
    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string',
            'description' => 'required|string',
        ]);

        if ($request->hasFile('image')) {

            // hapus gambar lama
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'parent_id' => $request->parent_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'tagline' => $request->tagline,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Kategori diperbarui');
    }

    // ======================
    // DELETE
    // ======================
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori dihapus');
    }
}
