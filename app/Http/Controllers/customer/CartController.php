<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display shopping cart page
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        $cartItems = [];
        $subtotal = 0;

        // Load product details untuk setiap item di cart
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            
            if ($product) {
                $itemTotal = $product->price * ($item['quantity'] ?? 1);
                $subtotal += $itemTotal;
                
                $cartItems[] = [
                    'product' => $product,
                    'qty' => $item['quantity'] ?? 1, // ✅ Changed to 'qty'
                    'item_total' => $itemTotal,
                ];
            }
        }

        // Calculate totals
        $shippingCost = 0;
        $tax = 0;
        $grandTotal = $subtotal + $shippingCost + $tax;

        return view('customer.cart', compact('cartItems', 'subtotal', 'shippingCost', 'tax', 'grandTotal'));
    }

    /**
     * Add product to cart (AJAX)
     */
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        // Check stock
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not available. Only ' . $product->stock . ' items left.'
            ], 400);
        }

        // Get cart from session
        $cart = Session::get('cart', []);
        $productId = $product->id;

        // Check if product already in cart
        if (isset($cart[$productId])) {
            // Update quantity
            $newQuantity = $cart[$productId]['quantity'] + $validated['quantity'];
            
            // Check stock again
            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot add more. Only ' . $product->stock . ' items available.'
                ], 400);
            }
            
            $cart[$productId]['quantity'] = $newQuantity;
        } else {
            // Add new item
            $cart[$productId] = [
                'quantity' => $validated['quantity'],
                'price' => $product->price,
            ];
        }

        // Save to session
        Session::put('cart', $cart);

        // Get total items in cart
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart!',
            'cart_count' => $totalItems,
        ]);
    }

    /**
     * Update cart item quantity (AJAX)
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $cart = Session::get('cart', []);

        // Check stock
        if ($product->stock < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Stock not available. Only ' . $product->stock . ' items left.'
            ], 400);
        }

        // Update quantity
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] = $validated['quantity'];
            Session::put('cart', $cart);

            // Calculate new totals
            $itemTotal = $product->price * $validated['quantity'];
            $subtotal = 0;
            
            foreach ($cart as $productId => $item) {
                $p = Product::find($productId);
                if ($p) {
                    $subtotal += $p->price * $item['quantity'];
                }
            }

            $grandTotal = $subtotal;

            return response()->json([
                'success' => true,
                'message' => 'Cart updated',
                'item_total' => $itemTotal,
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    /**
     * Remove item from cart (AJAX)
     */
    public function remove(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $cart = Session::get('cart', []);
        $productId = $validated['product_id'];

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

            // Calculate new totals
            $subtotal = 0;
            foreach ($cart as $pid => $item) {
                $p = Product::find($pid);
                if ($p) {
                    $subtotal += $p->price * $item['quantity'];
                }
            }

            $grandTotal = $subtotal;
            $totalItems = array_sum(array_column($cart, 'quantity'));

            return response()->json([
                'success' => true,
                'message' => 'Product removed from cart',
                'cart_count' => $totalItems,
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
                'cart_empty' => empty($cart),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    /**
     * Clear all cart
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared');
    }

    /**
     * Get cart count (for header badge)
     */
    public function count()
    {
        $cart = Session::get('cart', []);
        $totalItems = array_sum(array_column($cart, 'quantity'));

        return response()->json([
            'count' => $totalItems
        ]);
    }
}