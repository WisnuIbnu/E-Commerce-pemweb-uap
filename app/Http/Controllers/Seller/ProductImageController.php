<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;

class ProductImageController extends Controller
{
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);

        // delete file
        @unlink(public_path('uploads/products/' . $image->image));

        $image->delete();

        return back()->with('success', 'Image deleted successfully!');
    }
}
