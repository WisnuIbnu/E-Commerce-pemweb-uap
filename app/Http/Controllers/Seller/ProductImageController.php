<?php

// app/Http/Controllers/Seller/ProductImageController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request, Product $product)
    {
        // Ensure product belongs to seller's store
        if ($product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        $request->validate([
            'images.*' => 'required|image|max:2048'
        ]);

        $lastOrder = $product->images()->max('order') ?? -1;

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                $product->images()->create([
                    'image_url' => $path,
                    'is_primary' => $product->images()->count() === 0,
                    'order' => ++$lastOrder
                ]);
            }
        }

        return back()->with('success', 'Images uploaded successfully!');
    }

    public function destroy(ProductImage $image)
    {
        // Ensure product belongs to seller's store
        if ($image->product->store_id !== auth()->user()->store->id) {
            abort(403);
        }

        Storage::disk('public')->delete($image->image_url);
        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
