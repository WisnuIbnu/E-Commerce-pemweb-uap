<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $total += $product->price * $quantity;
            }
        }

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);

        if ($product->stock < 1) {
            return response()->json([
                'success' => false,
                'message' => 'Product out of stock'
            ]);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id] >= $product->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more, stock limit reached'
                ]);
            }
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => count($cart)
        ]);
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::find($id);
            
            if ($request->quantity > $product->stock) {
                return back()->with('error', 'Quantity exceeds available stock');
            }

            if ($request->quantity <= 0) {
                unset($cart[$id]);
            } else {
                $cart[$id] = $request->quantity;
            }
            
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Product removed from cart');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }
}