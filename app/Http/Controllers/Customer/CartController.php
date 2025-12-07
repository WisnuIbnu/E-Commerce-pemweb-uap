<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Check stock
        if ($product->stock < $validated['quantity']) {
            return back()->with('error', 'Not enough stock available');
        }

        // Get current cart
        $cart = session('cart', []);

        // Add or update product in cart
        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $validated['quantity'];
            
            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Not enough stock available');
            }
            
            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'quantity' => $validated['quantity'],
                'name' => $product->name,
                'price' => $product->price,
            ];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Product added to cart!');
    }

    public function index()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return view('customer.cart', ['items' => [], 'total' => 0]);
        }

        // Get products
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)
            ->with(['productImages', 'store'])
            ->get();

        $items = [];
        $total = 0;

        foreach ($products as $product) {
            $quantity = $cart[$product->id]['quantity'];
            $subtotal = $product->price * $quantity;
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'subtotal' => $subtotal
            ];
            $total += $subtotal;
        }
        return view('customer.cart', compact('items', 'total'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        $cart = session('cart', []);
        if (!isset($cart[$product->id])) {
            return back()->with('error', 'Product not in cart');
        }
        if ($validated['quantity'] > $product->stock) {
            return back()->with('error', 'Not enough stock available');
        }
        $cart[$product->id]['quantity'] = $validated['quantity'];
        session(['cart' => $cart]);
        return back()->with('success', 'Cart updated!');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            session(['cart' => $cart]);
            return back()->with('success', 'Product removed from cart');
        }
        return back()->with('error', 'Product not in cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return back()->with('success', 'Cart cleared');
    }
}