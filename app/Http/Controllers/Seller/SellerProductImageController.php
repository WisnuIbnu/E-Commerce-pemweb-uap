<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class SellerProductImageController extends Controller
{
    public function index($product)
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $product = Product::where('store_id', $store->id)
            ->findOrFail($product);

        $images = $product->images()->paginate(12);

        return view('seller.product-images.index', compact('product', 'images', 'store'));
    }

    public function create($product)
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $product = Product::where('store_id', $store->id)
            ->findOrFail($product);

        return view('seller.product-images.create', compact('product', 'store'));
    }

    public function store(Request $request, $product)
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $product = Product::where('store_id', $store->id)
            ->findOrFail($product);

        $validated = $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        foreach ($validated['images'] as $image) {
            $path = $image->store('products', 'public');
            $product->images()->create(['image_path' => $path]);
        }

        return redirect()->route('seller.products.images.index', $product->id)
            ->with('success', 'Gambar berhasil ditambahkan');
    }

    public function destroy($product, $image)
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $product = Product::where('store_id', $store->id)
            ->findOrFail($product);

        $image = $product->images()->findOrFail($image);

        if (\Storage::disk('public')->exists($image->image_path)) {
            \Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()->back()->with('success', 'Gambar berhasil dihapus');
    }
}