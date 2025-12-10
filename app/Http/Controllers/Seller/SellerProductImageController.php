<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SellerProductImageController extends Controller
{
    public function index($productId)
    {
        $store = getSellerStore();
        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $images = $product->images;
        
        return view('seller.images.index', compact('product', 'images', 'store'));
    }

    public function create($productId)
    {
        $store = getSellerStore();
        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        
        return view('seller.images.create', compact('product', 'store'));
    }

    public function store(Request $request, $productId)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048',
        ]);

        $store = getSellerStore();
        $product = Product::where('store_id', $store->id)->findOrFail($productId);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        return redirect()->route('seller.products.images.index', $productId)
            ->with('success', 'Gambar berhasil diupload.');
    }

    public function destroy($productId, $imageId)
    {
        $store = getSellerStore();
        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $image = ProductImage::where('product_id', $product->id)->findOrFail($imageId);

        // Delete from storage
        Storage::disk('public')->delete($image->image_path);
        
        $image->delete();

        return redirect()->route('seller.products.images.index', $productId)
            ->with('success', 'Gambar berhasil dihapus.');
    }
}