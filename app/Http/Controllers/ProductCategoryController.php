<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductCategoryController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request): View
    {
        $categories = ProductCategory::all();
        return view('store.create-category', ['categories' => $categories]);
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $categories = ProductCategory::all();
        $data = $request->validated();
        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_image', 'public');
        }
        $category = ProductCategory::create($data);
        return Redirect::route('store.edit')->with('status', 'New category created.');
    }

    public function edit(Request $request): View
    {
        $store = $request->user()->store;
        $categories = ProductCategory::all();
        return view('store.edit', [
            'category' => $category,
        ]);
    }

    public function update(CategoryRequest $request): RedirectResponse
    {
        $categories = ProductCategory::all();
        $data = $request->validated();
        if($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category_image', 'public');
        }
        $category = ProductCategory::update($data);
        return Redirect::route('store.display-store-product')->with('status', 'Category updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $category->delete();
        return Redirect::to('store.display-store-product')->with('status', 'Category deleted');
    }
}
