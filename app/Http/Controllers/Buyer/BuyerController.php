<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    // List semua snack
    public function home() {
        $products = Product::all();
        return view('buyer.home', compact('products'));
    }

    // Detail snack
    public function productDetail($id) {
        $product = Product::findOrFail($id);
        return view('buyer.detail', compact('product'));
    }

    // Tambah ke keranjang
    public function addToCart($id) {
        Cart::create([
            'user_id' => auth()->id(),
            'product_id' => $id,
            'qty' => 1
        ]);
        return back()->with('success', 'Added to cart');
    }

    // Lihat keranjang
    public function cart() {
        $cart = Cart::where('user_id', auth()->id())->get();
        return view('buyer.cart', compact('cart'));
    }

    // Update jumlah item
    public function updateCart(Request $r, $id) {
        $item = Cart::findOrFail($id);
        $item->qty = $r->qty;
        $item->save();
        return back()->with('success', 'Cart updated');
    }

    // Hapus item dari keranjang
    public function removeFromCart($id) {
        Cart::findOrFail($id)->delete();
        return back()->with('success', 'Item removed');
    }

    // Halaman checkout
    public function checkout() {
        $cart = Cart::where('user_id', auth()->id())->get();
        return view('buyer.checkout', compact('cart'));
    }

    // Simpan order
    public function makeOrder(Request $r) {
        Order::create([
            'user_id' => auth()->id(),
            'seller_id' => $r->seller_id,
            'total' => $r->total,
            'status' => 'waiting',
        ]);

        Cart::where('user_id', auth()->id())->delete();

        return redirect()->route('buyer.myOrders')->with('success', 'Order placed');
    }

    // Lihat pesanan sendiri
    public function myOrders() {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('buyer.orders', compact('orders'));
    }
}