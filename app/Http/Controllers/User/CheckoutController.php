<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $id => $quantity) {
            $product = Product::find($id);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $product->price * $quantity
                ];
                $subtotal += $product->price * $quantity;
            }
        }

        $shippingCost = 15000;
        $tax = $subtotal * 0.11;
        $grandTotal = $subtotal + $shippingCost + $tax;

        return view('user.checkout.index', compact('cartItems', 'subtotal', 'shippingCost', 'tax', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'shipping_type' => 'required|in:regular,express',
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }

        // Group products by store
        $storeGroups = [];
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product && $product->stock >= $quantity) {
                $storeId = $product->store_id;
                if (!isset($storeGroups[$storeId])) {
                    $storeGroups[$storeId] = [];
                }
                $storeGroups[$storeId][] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }

        // Create transaction for each store
        foreach ($storeGroups as $storeId => $items) {
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['product']->price * $item['quantity'];
            }

            $shippingCost = $request->shipping_type === 'express' ? 25000 : 15000;
            $tax = $subtotal * 0.11;
            $grandTotal = $subtotal + $shippingCost + $tax;

            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(10)),
                'buyer_id' => auth()->id(),
                'store_id' => $storeId,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'JNE',
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => 'pending',
            ]);

            foreach ($items as $item) {
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product']->id,
                    'qty' => $item['quantity'],
                    'subtotal' => $item['product']->price * $item['quantity'],
                ]);

                // Reduce stock
                $item['product']->decrement('stock', $item['quantity']);
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('transactions.index')
            ->with('success', 'Order placed successfully!');
    }
}