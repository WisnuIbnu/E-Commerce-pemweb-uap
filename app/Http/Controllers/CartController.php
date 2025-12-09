<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // tampilkan isi cart user
    public function index()
    {
        $cartItems = CartItem::with([
                'product.store',
                'product.productImages'
            ])
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn($item) => $item->product->price * $item->qty);

        return view('cart.index', compact('cartItems', 'total'));
    }

    // tambah ke cart
    public function add(Product $product, Request $request)
    {
        $qty = $request->input('qty', 1);

        // cek apakah sudah ada di cart
        $cartItem = CartItem::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('qty', $qty);
        } else {
            CartItem::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'qty'        => $qty,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // update qty
    public function update($id, Request $request)
    {
        $cartItem = CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $cartItem->update([
            'qty' => $request->qty
        ]);

        return back()->with('success', 'Keranjang diperbarui');
    }

    // hapus item
    public function remove($id)
    {
        CartItem::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Produk dihapus dari keranjang');
    }
}
