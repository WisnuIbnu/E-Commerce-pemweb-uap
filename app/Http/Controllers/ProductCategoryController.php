<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    //GET /categories/
    public function index()
    {
        $categories = ProductCategory::with('children')
            ->whereNull('parent_id')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories
        ]);
    }

    //GET /categories/{id}/products/
    public function listProducts($id)
    {
        $category = ProductCategory::with('products')->findOrFail($id);

        return response()->json([
            'success' => true,
            'category' => $category->name,
            'products' => $category->products
        ]);
    }

    //POST /categories
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

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dibuat',
            'data' => $category
        ], 201);
    }

    //PUT /categories/{id}
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

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ]);
    }

    // DELETE /categories/{id}
    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        // hapus image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus'
        ]);
    }
}
