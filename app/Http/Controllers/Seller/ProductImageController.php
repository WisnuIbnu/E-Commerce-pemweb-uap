<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductImageController extends Controller
{
    public function store(Request $request, $id)
    {
        $store = Auth::user()->store;

        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $path = $request->file('image')->store('product_images', 'public');

        $product->productImages()->create([
            'image' => $path,
            'is_thumbnail' => false
        ]);

        return back()->with('success', 'Image uploaded');
    }

    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        \Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted');
    }
}
