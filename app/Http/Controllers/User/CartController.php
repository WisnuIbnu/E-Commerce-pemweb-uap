<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();
        return view('user.cart.cart', compact('carts'));
    }

    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if quantity exceeds stock
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            // Check if total quantity would exceed stock
            $newQuantity = $cart->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Adding this quantity would exceed available stock.');
            }

            $cart->update([
                'quantity' => $newQuantity
            ]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        // Use explicit URL redirect instead of route
        return redirect('/cart')->with('success', 'Product added to cart!');
    }

    public function buyNow(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if quantity exceeds stock
        if ($request->quantity > $product->stock) {
            return redirect()->back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Add to cart first
        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();

        if ($cart) {
            $newQuantity = $cart->quantity + $request->quantity;
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Adding this quantity would exceed available stock.');
            }
            $cart->update(['quantity' => $newQuantity]);
        } else {
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }

        // Use explicit URL redirect instead of route
        return redirect('/checkout')->with('success', 'Proceed to checkout.');
    }

    public function destroy(Cart $cart)
    {
        // Ensure user can only delete their own cart items
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }
        
        $cart->delete();
        
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    public function update(Request $request, Cart $cart)
    {
        // Ensure user can only update their own cart items
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        // Check stock availability
        if ($request->quantity > $cart->product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        $cart->update(['quantity' => $request->quantity]);

        return back()->with('success', 'Cart updated successfully.');
    }
}
