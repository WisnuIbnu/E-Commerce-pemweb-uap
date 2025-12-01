<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // GET all products
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'message' => 'List of products',
            'data' => $products
        ]);
    }

    // GET product by ID
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Product detail',
            'data' => $product
        ]);
    }

    // POST product
    public function store(Request $request)
    {
        $request->validate([
            'store_id' => 'required',
            'product_category_id' => 'required',
            'name' => 'required|string|max:255',
            'about' => 'required',
            'condition' => 'required|in:new,second',
            'price' => 'required|numeric',
            'weight' => 'required|numeric',
            'stock' => 'required|integer'
        ]);

        $product = Product::create([
            'store_id' => $request->store_id,
            'product_category_id' => $request->product_category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name . '-' . uniqid()),
            'about' => $request->about,
            'condition' => $request->condition,
            'price' => $request->price,
            'weight' => $request->weight,
            'stock' => $request->stock,
        ]);

        return response()->json([
            'message' => 'Product created',
            'data' => $product
        ], 201);
    }

    // PUT product/{id}
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'about' => 'sometimes',
            'condition' => 'sometimes|in:new,second',
            'price' => 'sometimes|numeric',
            'weight' => 'sometimes|numeric',
            'stock' => 'sometimes|integer'
        ]);

        // Agar slug tidak berubah otomatis kalau nama tidak diubah
        $data = $request->only([
            'name', 'about', 'condition', 'price', 'weight', 'stock'
        ]);

        if ($request->has('name')) {
            $data['slug'] = Str::slug($request->name . '-' . uniqid());
        }

        $product->update($data);

        return response()->json([
            'message' => 'Product updated',
            'data' => $product
        ]);
    }

    // DELETE product/{id}
    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found'
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted'
        ]);
    }
}
