<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * CART PAGE
     */
    public function showCart()
    {
        $cart = session()->get('cart', []);

        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('user.cart.index', compact('products', 'cart'));
    }

    /**
     * REMOVE ONE ITEM
     */
    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Item berhasil dihapus.');
    }

    /**
     * CLEAR CART
     */
    public function clearCart()
    {
        session()->forget('cart');
        return back()->with('success', 'Keranjang dikosongkan.');
    }

    /**
     * CHECKOUT PAGE
     */
    public function showCheckout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Keranjang masih kosong.');
        }

        $products = Product::whereIn('id', array_keys($cart))->get();

        return view('user.checkout.index', compact('products', 'cart'));
    }

    /**
     * PROCESS CHECKOUT
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'address'      => 'required',
            'city'         => 'required',
            'postal_code'  => 'required',
            'shipping_type'=> 'required',
        ]);

        $cart = session()->get('cart', []);

        if (!$cart) {
            return redirect('/cart')->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            // Buyer auto-create
            $buyer = auth()->user()->buyer;
            if (!$buyer) {
                $buyer = Buyer::create([
                    'user_id' => auth()->id(),
                ]);
            }

            $products = Product::whereIn('id', array_keys($cart))->get();

            $subtotal = 0;
            $storeId = null;

            foreach ($products as $p) {
                $qty = $cart[$p->id]['qty'];

                if ($p->stock < $qty) {
                    return redirect('/cart')->with('error', "Stok {$p->name} tidak cukup.");
                }

                $subtotal += $p->price * $qty;
                $storeId = $p->store_id;
            }

            $shipping_cost = $request->shipping_type == "express" ? 35000 : 20000;
            $tax = $subtotal * 0.10;
            $grand_total = $subtotal + $shipping_cost + $tax;

            // Create Transaction
            $transaction = Transaction::create([
                'code'          => 'TRX-' . strtoupper(Str::random(8)),
                'buyer_id'      => $buyer->id,
                'store_id'      => $storeId,
                'address'       => $request->address,
                'city'          => $request->city,
                'postal_code'   => $request->postal_code,
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shipping_cost,
                'tax'           => $tax,
                'grand_total'   => $grand_total,
                'payment_status'=> 'paid',
            ]);

            // Create Transaction Details + reduce stock
            foreach ($products as $p) {
                $qty = $cart[$p->id]['qty'];
                $subtotalPerItem = $qty * $p->price;

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $p->id,
                    'qty'            => $qty,
                    'subtotal'       => $subtotalPerItem,
                ]);

                $p->stock -= $qty;
                $p->save();
            }

            session()->forget('cart');

            DB::commit();

            return redirect()->route('transactions.show', $transaction->id)
                ->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * TRANSACTION HISTORY
     */
    public function index()
    {
        $buyer = auth()->user()->buyer;
        $transactions = Transaction::where('buyer_id', $buyer->id)
                                   ->latest()
                                   ->get();

        return view('user.transactions.index', compact('transactions'));
    }

    /**
     * TRANSACTION RECEIPT
     */
    public function show($id)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);

        return view('user.transactions.show', compact('transaction'));
    }
}
