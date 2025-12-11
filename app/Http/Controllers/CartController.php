<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Tampilkan halaman cart
    public function index()
    {
        $cart = session()->get('cart', []);

        // hitung total
        $items = [];
        $total = 0;

        foreach ($cart as $productId => $meta) {
            $product = Product::find($productId);
            if (! $product) {
                continue;
            }

            $qty = $meta['qty'] ?? $meta['quantity'] ?? 1;
            $sub = $product->price * $qty;

            $items[] = [
                'product' => $product,
                'qty'     => $qty,
                'sub'     => $sub,
            ];

            $total += $sub;
        }

        return view('customer.cart.index', compact('items', 'total'));
    }

    // Tambah produk ke cart
    public function add(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);

        $qty = (int) $request->input('qty', 1);

        if (isset($cart[$product->id])) {
            // kalau sudah ada, tambahkan quantity
            $cart[$product->id]['qty'] += $qty;
        } else {
            $cart[$product->id] = [
                'qty' => $qty,
            ];
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart.');
    }

    // Update quantity
    public function update(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] = (int) $request->input('qty', 1);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart updated.');
    }

    // Hapus item dari cart
    public function remove(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product removed from cart.');
    }
}
