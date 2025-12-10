<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryManagementController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::whereNull('parent_id')
            ->with('children')
            ->latest()
            ->paginate(10);

        return view('store.category.index', compact('categories'));
    }

    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->get();
        return view('store.category.create', compact('parentCategories'));
    }

    public function store(Request $request)
    {
        if ($request->ajax() || $request->wantsJson() || $request->expectsJson()) {
            $request->validate([
                'name' => 'required|string|max:255|unique:product_categories,name',
                'tagline' => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category = ProductCategory::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'tagline' => $request->tagline,
                'description' => $request->description,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'category' => [
                    'id' => $category->id,
                    'name' => $category->name,
                ]
            ]);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('images/stores', $imageName, 'public');
        }

        ProductCategory::create($data);

        return redirect()->route('store.categories.index')
            ->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = ProductCategory::findOrFail($id);
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $id)
            ->get();

        return view('store.category.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, $id)
    {
        $category = ProductCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:product_categories,name,' . $id,
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'parent_id' => $request->parent_id,
            'tagline' => $request->tagline,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            $data['image'] = $image->storeAs('images/stores', $imageName, 'public');
        }

        $category->update($data);

        return redirect()->route('store.categories.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = ProductCategory::findOrFail($id);

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with products');
        }

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('store.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}