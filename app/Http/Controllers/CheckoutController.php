<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyer;

        if (!$buyer) {
            return redirect()->route('cart')->with('error', 'Buyer data not found!');
        }

        $cartItems = Cart::where('buyer_id', $buyer->id)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Your cart is still empty!');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->qty);
        $serviceFee = 4000;

        return view('checkout', compact('cartItems', 'subtotal', 'serviceFee'));
    }

    private function shippingCost($type)
    {
        return match ($type) {
            'regular'  => 15000,
            'express'  => 25000,
            default    => 15000,
        };
    }

    public function process(Request $request)
    {
        $request->validate([
            'shipping_type' => 'required',
            'payment_method' => 'required',
        ]);

        $buyer = auth()->user()->buyer;
        if (!$buyer) {
            return redirect()->route('cart.index')->with('error', 'Buyer data not found!');
        }

        $selectedIds = $request->input('selected_items', []);
        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->with('error', 'Please select at least one product to checkout.');
        }
        
        $cartItems = Cart::where('buyer_id', $buyer->id)->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is still empty!');
        }

        $subtotal = $cartItems->sum(fn($c) => $c->product->price * $c->qty);
        $serviceFee = 4000;
        $shippingCost = $this->shippingCost($request->shipping_type);

        $transaction = Transaction::create([
            'buyer_id' => $buyer->id,
            'store_id' => $cartItems->first()->product->store_id,
            'address'  => auth()->user()->address ?? 'No Address',
            'city'     => auth()->user()->city ?? '-',
            'postal_code' => auth()->user()->postal_code ?? '-',
            'shipping_type' => $request->shipping_type,
            'shipping_cost' => $shippingCost,
            'tax' => $serviceFee,
            'grand_total' => $subtotal + $serviceFee + $shippingCost,
            'payment_status' => 'pending'
        ]);

        foreach ($cartItems as $item) {
            $transaction->transactionDetails()->create([
                'product_id' => $item->product_id,
                'qty' => $item->qty,
                'subtotal' => $item->product->price * $item->qty,
            ]);
        }

        Cart::where('buyer_id', $buyer->id)->delete();

        return redirect()->route('transactions.show', $transaction->id);
    }
}
