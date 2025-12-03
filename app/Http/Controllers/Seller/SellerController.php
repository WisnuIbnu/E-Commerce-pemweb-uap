<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function dashboard() {
        return view('seller.dashboard');
    }

    // Produk milik seller sendiri
    public function myProducts() {
        $products = Product::where('seller_id', auth()->id())->get();
        return view('seller.myProducts', compact('products'));
    }

    public function createProduct() {
        return view('seller.addProduct');
    }

    public function storeProduct(Request $r) {
        Product::create([
            'name' => $r->name,
            'price' => $r->price,
            'stock' => $r->stock,
            'seller_id' => auth()->id(),
        ]);

        return redirect()->route('seller.myProducts')->with('success', 'Product added');
    }

    public function editProduct($id) {
        $product = Product::findOrFail($id);
        return view('seller.editProduct', compact('product'));
    }

    public function updateProduct(Request $r, $id) {
        $product = Product::findOrFail($id);
        $product->update($r->all());
        return redirect()->route('seller.myProducts')->with('success', 'Product updated');
    }

    public function deleteProduct($id) {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted');
    }

    // Order masuk untuk seller ini
    public function incomingOrders() {
        $orders = Order::where('seller_id', auth()->id())->get();
        return view('seller.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $r, $id) {
        $order = Order::findOrFail($id);
        $order->status = $r->status;
        $order->save();

        return back()->with('success', 'Order status updated');
    }
}