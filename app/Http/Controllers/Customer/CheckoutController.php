<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:customer']);
    }

    // display checkout page (cart from session)
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) return redirect()->route('cart.index')->with('error','Keranjang kosong.');

        // build items
        $items = [];
        $total = 0;
        foreach ($cart as $productId => $meta) {
            $p = Product::find($productId);
            if (! $p) continue;
            $qty = $meta['quantity'] ?? $meta['qty'] ?? 1;
            $sub = $p->price * $qty;
            $items[] = ['product'=>$p,'qty'=>$qty,'sub'=>$sub];
            $total += $sub;
        }

        return view('customer.checkout.index', compact('items','total'));
    }

    // process checkout: create Transaction and TransactionDetails
    public function process(Request $request)
    {
        $request->validate([
            'shipping_address'=>'required|string',
            'shipping_type'=>'required|string',
            'phone'=>'required|string',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) return back()->with('error','Keranjang kosong.');

        DB::beginTransaction();
        try {
            $total = 0;
            // compute totals and check stock (lock rows)
            $productsLocked = [];
            foreach ($cart as $productId => $meta) {
                $p = Product::lockForUpdate()->find($productId);
                if (! $p) throw new \Exception('Produk tidak ditemukan.');
                $qty = $meta['quantity'] ?? $meta['qty'] ?? 1;
                if ($p->stock < $qty) throw new \Exception("Stok untuk {$p->name} tidak cukup.");
                $productsLocked[] = ['product'=>$p,'qty'=>$qty];
                $total += $p->price * $qty;
            }

            // create transaction
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'shipping_type' => $request->shipping_type,
                'phone' => $request->phone,
            ]);

            // create details and decrement stock
            foreach ($productsLocked as $row) {
                $p = $row['product'];
                $qty = $row['qty'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $p->id,
                    'price' => $p->price,
                    'quantity' => $qty,
                    'store_id' => $p->store_id, // useful for seller views
                ]);

                $p->decrement('stock', $qty);
            }

            DB::commit();

            // clear cart
            session()->forget('cart');

            return redirect()->route('transactions.index')->with('success','Pembelian berhasil. ID Order: '.$transaction->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Checkout gagal: '.$e->getMessage());
        }
    }
}
