<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $carts = Cart::with('product.store')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        return view('front.carts', compact('carts'));
    }

    // Menyimpan produk ke keranjang
    public function store($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Cek apakah produk sudah ada di keranjang (opsional: hindari duplikat)
        $exists = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return redirect()->route('carts.index')->with('error', 'Produk sudah ada di keranjang Anda.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        return redirect()->route('carts.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Menghapus item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}