<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function index($productId)
    {
        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($productId);
        $images = $product->images;

        return view('store.product-image.index', compact('product', 'images'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $store = auth()->user()->store;
        $product = $store->products()->findOrFail($request->product_id);

        $uploaded = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                    'is_thumbnail' => $product->images()->count() == 0,
                ]);
                
                $uploaded++;
            }
        }

        return back()->with('success', "$uploaded image(s) uploaded successfully");
    }

    public function setThumbnail($id)
    {
        $image = ProductImage::findOrFail($id);
        $store = auth()->user()->store;

        // Verify ownership
        if ($image->product->store_id != $store->id) {
            abort(403);
        }

        ProductImage::where('product_id', $image->product_id)
            ->update(['is_thumbnail' => false]);

        $image->update(['is_thumbnail' => true]);

        return back()->with('success', 'Thumbnail updated successfully');
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $store = auth()->user()->store;

        // Verify ownership
        if ($image->product->store_id != $store->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }
}