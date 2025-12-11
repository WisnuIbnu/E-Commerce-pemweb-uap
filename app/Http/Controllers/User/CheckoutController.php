<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display checkout page
     */
    public function index(Request $request)
    {
        $items = [];
        $subtotal = 0;
        $isBuyNow = false;

        // If buy now flow
        if ($request->has('buy_now')) {
            $isBuyNow = true;

            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'required|integer|min:1',
            ]);

            $product = Product::with(['store', 'images'])->findOrFail($validated['product_id']);

            if ($product->stock < $validated['quantity']) {
                return back()->with('error', 'Stok produk tidak mencukupi!');
            }

            $items[] = (object)[
                'id' => null,
                'product' => $product,
                'quantity' => $validated['quantity'],
                'subtotal' => $product->price * $validated['quantity']
            ];

            $subtotal = $product->price * $validated['quantity'];
        }
        else {
            // From cart
            $cartItems = Cart::where('user_id', Auth::id())
                ->with(['product.store', 'product.images'])
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong!');
            }

            foreach ($cartItems as $cartItem) {
                if ($cartItem->product->stock < $cartItem->quantity) {
                    return redirect()->route('cart.index')
                        ->with('error', 'Stok produk "' . $cartItem->product->name . '" tidak mencukupi!');
                }
            }

            $items = $cartItems;
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        }

        $shippingCost = 15000;
        $tax = $subtotal * 0.11;
        $grandTotal = $subtotal + $shippingCost + $tax;

        return view('user.checkout.index', compact(
            'items', 'subtotal', 'shippingCost', 'tax', 'grandTotal', 'isBuyNow'
        ));
    }

    /**
     * Process checkout & create transactions
     */
    public function process(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:10',
            'shipping_type' => 'required|in:regular,express',
            'is_buy_now' => 'nullable|boolean',
            'product_id' => 'required_if:is_buy_now,1|exists:products,id',
            'quantity' => 'required_if:is_buy_now,1|integer|min:1',
        ]);

        //
        // 🔥 FIX UTAMA – Pastikan buyer ada
        //
        $buyer = Auth::user()->buyer;

        if (!$buyer) {
            // Auto-create buyer profile
            $buyer = Buyer::create([
                'user_id' => Auth::id(),
                'profile_picture' => null,
                'phone_number' => null,
            ]);
        }

        $buyerId = $buyer->id;

        DB::beginTransaction();

        try {
            $isBuyNow = $request->is_buy_now == 1;
            $storeGroups = [];

            // BUY NOW FLOW
            if ($isBuyNow) {
                $product = Product::findOrFail($validated['product_id']);

                if ($product->stock < $validated['quantity']) {
                    return back()->with('error', 'Stok tidak mencukupi!');
                }

                $storeGroups[$product->store_id][] = [
                    'product' => $product,
                    'quantity' => $validated['quantity']
                ];
            }
            else {
                // CART FLOW
                $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

                if ($cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
                }

                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;

                    if ($product->stock < $cartItem->quantity) {
                        return back()->with('error', 'Stok produk "' . $product->name . '" tidak mencukupi!');
                    }

                    $storeGroups[$product->store_id][] = [
                        'product' => $product,
                        'quantity' => $cartItem->quantity
                    ];
                }
            }

            //
            // 🔥 CREATE TRANSACTIONS
            //
            $transactionCode = null;

            foreach ($storeGroups as $storeId => $items) {
                $subtotal = 0;

                foreach ($items as $item) {
                    $subtotal += $item['product']->price * $item['quantity'];
                }

                $shippingCost = $validated['shipping_type'] === 'express' ? 25000 : 15000;
                $tax = $subtotal * 0.11;
                $grandTotal = $subtotal + $shippingCost + $tax;

                $transaction = Transaction::create([
                    'code' => 'TRX-' . strtoupper(Str::random(10)),
                    'buyer_id' => $buyerId, // 🔥 FIXED
                    'store_id' => $storeId,
                    'address' => $validated['address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'shipping' => 'JNE',
                    'shipping_type' => $validated['shipping_type'],
                    'shipping_cost' => $shippingCost,
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => 'pending',
                ]);

                if (!$transactionCode) {
                    $transactionCode = $transaction->code;
                }

                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product']->id,
                        'qty' => $item['quantity'],
                        'subtotal' => $item['product']->price * $item['quantity'],
                    ]);

                    // Kurangi stok
                    $item['product']->decrement('stock', $item['quantity']);
                }
            }

            // CLEAR CART
            if (!$isBuyNow) {
                Cart::where('user_id', Auth::id())->delete();
            }

            DB::commit();

            return redirect()->route('payment.show', $transactionCode)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display payment page
     */
    public function payment($code)
    {
        $transaction = Transaction::with([
            'transactionDetails.product.images',
            'store',
            'buyer'
        ])
            ->where('code', $code)
            ->where('buyer_id', Auth::user()->buyer->id)
            ->firstOrFail();

        return view('user.payment.show', compact('transaction'));
    }

    /**
     * Confirm payment
     */
    public function confirmPayment($code)
    {
        $buyer = Auth::user()->buyer;

        $transaction = Transaction::where('code', $code)
            ->where('buyer_id', $buyer->id)
            ->firstOrFail();

        $transaction->update([
            'payment_status' => 'paid'
        ]);

        return redirect()->route('payment.show', $code)
            ->with('success', 'Pembayaran berhasil dikonfirmasi!');
    }

    /**
     * Order success redirect
     */
    public function success()
    {
        $buyer = Auth::user()->buyer;

        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->with(['store', 'transactionDetails.product'])
            ->latest()
            ->first();

        if (!$transaction) {
            return redirect()->route('dashboard');
        }

        return redirect()->route('payment.show', $transaction->code);
    }
}
