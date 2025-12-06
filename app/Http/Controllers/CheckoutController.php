<?php

namespace App\Http\Controllers;

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
     * Tampilkan form checkout untuk 1 produk.
     */
    public function create(Product $product)
    {
        $quantity = 1;
        $subtotal = $product->price * $quantity;

        return view('checkout', [
            'product'  => $product,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ]);
    }

    /**
     * Proses checkout: buat transaksi + transaction_details.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'address'        => ['required', 'string', 'max:255'],
            'city'           => ['required', 'string', 'max:255'],
            'postal_code'    => ['required', 'string', 'max:255'],
            'shipping'       => ['required', 'string', 'max:255'],   // nama kurir
            'shipping_type'  => ['required', 'string', 'max:100'],   // jenis layanan
            'shipping_cost'  => ['nullable', 'numeric', 'min:0'],
            'quantity'       => ['required', 'integer', 'min:1'],
        ]);

        $user  = Auth::user();
        $buyer = $user->buyer; // sudah dijamin ada oleh middleware buyer.profile

        $quantity     = (int) $request->quantity;
        $shippingCost = (float) ($request->shipping_cost ?? 0);
        $productPrice = (float) $product->price;
        $subtotal     = $productPrice * $quantity;
        $tax          = 0; // sementara
        $grandTotal   = $subtotal + $shippingCost + $tax;

        // Cek stok (ownership tidak relevan di sini, tapi stok wajib dicek)
        if ($product->stock < $quantity) {
            return back()
                ->withErrors('Stok produk tidak mencukupi.')
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Buat transaksi (header)
            $transaction = Transaction::create([
                'code'          => 'TRX-' . Str::upper(Str::random(8)),
                'buyer_id'      => $buyer->id,
                'store_id'      => $product->store_id,
                'address'       => $request->address,
                'address_id'    => 'ADDR-' . Str::upper(Str::random(8)),
                'city'          => $request->city,
                'postal_code'   => $request->postal_code,
                'shipping'      => $request->shipping,
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tax'           => $tax,
                'grand_total'   => $grandTotal,
                // payment_status pakai default 'unpaid' dari DB
            ]);

            // Buat detail transaksi (schema pakai kolom qty)
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $product->id,
                'qty'            => $quantity,
                'subtotal'       => $subtotal,
            ]);

            // Kurangi stok produk
            $product->decrement('stock', $quantity);

            DB::commit();

            return redirect()
                ->route('transactions.index')
                ->with('success', 'Checkout berhasil, transaksi sudah dibuat.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()->withErrors('Terjadi kesalahan saat memproses checkout.');
        }
    }
}
