<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    //POST /products/{id}/images
    public function store(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'is_thumbnail' => 'nullable|boolean',
        ]);

        $imagePath = $request->file('image')->store('products', 'public');

        // jika gambar ini jadi thumbnail, nonaktifkan thumbnail lama
        if ($request->is_thumbnail == true) {
            ProductImage::where('product_id', $product->id)
                ->update(['is_thumbnail' => false]);
        }

        $image = ProductImage::create([
            'product_id' => $product->id,
            'image' => $imagePath,
            'is_thumbnail' => $request->is_thumbnail ?? false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Gambar produk berhasil ditambahkan',
            'data' => $image
        ], 201);
    }

    //DELETE /product-images/{id}
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // hapus file fisik
        Storage::disk('public')->delete($image->image);

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Gambar berhasil dihapus'
        ]);
    }
}
