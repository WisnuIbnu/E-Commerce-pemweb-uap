<?php

namespace App\Http\Controllers;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
    public function create(Request $request): View
    {
        $this->authorize('create', Product::class);
        $categories = ProductCategory::all();
        return view('store.create-product', ['categories' => $categories]);
    }

    public function store(ProductRequest $request): RedirectResponse
    {
        $this->authorize('create', Product::class);
        $categories = ProductCategory::all();
        $data = $request->validated();
        $data['store_id'] = auth()->user()->store->id;
        $product = Product::create($data);
        if($request->hasFile('image')) {
            $dataImage = $request->file('image')->store('product_image', 'public');
        }
        $product->productImages()->create([
            'product_id' => $product->id,
            'image' => $dataImage,
        ]);
        return Redirect::route('store.display-store-product')->with('status', 'Product added.');
    }

    public function edit(Product $product): View
    {
        $this->authorize('update', Product::class);
        $categories = ProductCategory::all();
        return view('store.update-product', ['categories' => $categories, 'product' => $product]);
    }

    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        $this->authorize('create', Product::class);
        $categories = ProductCategory::all();
        $data = $request->validated();
        $data['store_id'] = auth()->user()->store->id;
        $product = Product::update($data);
        if($request->hasFile('image')) {
            $dataImage['image'] = $request->file('image')->store('product_image', 'public');
        }
        $product->productImages()->update([
            'image_path' => 'product_images/example.jpg'
        ]);
        return Redirect::route('store.display-store-product')->with('status', 'Product changes saved.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', Product::class);
        $product->delete();
        return Redirect::to('store.edit')->with('status', 'Product deleted');
    }
    public function show($slug)
    {
        $product = Product::with([
            'productImages',
            'productCategory',
            'store',
            'productReviews.buyer.user'
        ])->where('slug', $slug)->firstOrFail();

        return view('product', compact('product'));
        }
    
}
