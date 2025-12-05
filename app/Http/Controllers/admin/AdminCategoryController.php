<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:product_categories',
            'description' => 'required',
        ]);

        ProductCategory::create($request->all());

        return redirect()->route('admin.categories.index');
    }

    public function edit(ProductCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ProductCategory $category)
    {
        $category->update($request->all());
        return redirect()->route('admin.categories.index');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return back();
    }
}
