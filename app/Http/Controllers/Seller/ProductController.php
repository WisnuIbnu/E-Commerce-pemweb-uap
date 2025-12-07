<?php

namespace App\Http\Controllers\Seller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ambil store milik user seller yg login
    protected function currentStore(): Store
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }


    public function index()
    {
        $store = $this->currentStore();

        $products = Product::with('category')
            ->where('store_id', $store->id)
            ->latest()
            ->get();

        return view('seller.products.index', compact('store', 'products'));
    }

    public function create()
    {
        $store = $this->currentStore();
        $categories = ProductCategory::all();

        return view('seller.products.create', compact('store', 'categories'));
    }

    public function store(Request $request)
    {
        $store = $this->currentStore();

        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'condition'           => ['required', 'in:new,second'],
            'price'               => ['required', 'numeric', 'min:0'],
            'weight'              => ['required', 'integer', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
        ]);

        Product::create([
            'store_id'            => $store->id,
            'product_category_id' => $validated['product_category_id'],
            'name'                => $validated['name'],
            'slug'                => Str::slug($validated['name'] . '-' . uniqid()),
            'description'         => $validated['description'],
            'condition'           => $validated['condition'],
            'price'               => $validated['price'],
            'weight'              => $validated['weight'],
            'stock'               => $validated['stock'],
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        $categories = ProductCategory::all();

        return view('seller.products.edit', compact('store', 'product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        $validated = $request->validate([
            'name'                => ['required', 'string', 'max:255'],
            'description'         => ['required', 'string'],
            'product_category_id' => ['required', 'exists:product_categories,id'],
            'condition'           => ['required', 'in:new,second'],
            'price'               => ['required', 'numeric', 'min:0'],
            'weight'              => ['required', 'integer', 'min:0'],
            'stock'               => ['required', 'integer', 'min:0'],
        ]);

        $product->update([
            'product_category_id' => $validated['product_category_id'],
            'name'                => $validated['name'],
            'description'         => $validated['description'],
            'condition'           => $validated['condition'],
            'price'               => $validated['price'],
            'weight'              => $validated['weight'],
            'stock'               => $validated['stock'],
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $store = $this->currentStore();

        if ($product->store_id !== $store->id) {
            abort(403, 'Unauthorized.');
        }

        $product->delete();

        return redirect()->route('seller.products.index')
            ->with('success', 'Product deleted.');
    }
}
