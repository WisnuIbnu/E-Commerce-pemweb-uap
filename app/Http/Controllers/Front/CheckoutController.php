<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // Menampilkan halaman checkout
    public function index(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        
        // Simulasi hitung pajak (misal 11% PPN)
        $tax = $product->price * 0.11;
        $total = $product->price + $tax;

        return view('front.checkout', compact('product', 'tax', 'total'));
    }

    // Memproses pembelian
    public function store(Request $request, $slug)
    {
        // Validasi Input sesuai kolom di migration transactions
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'shipping_type' => 'required|in:regular,express,instant',
        ]);

        $product = Product::with('store')->where('slug', $slug)->firstOrFail();

        // Menentukan Biaya Ongkir 
        $shippingCost = match($request->shipping_type) {
            'express' => 50000,
            'instant' => 35000,
            default => 20000, // regular
        };

        // 3. Hitung Total Akhir
        $tax = $product->price * 0.11;
        $grandTotal = $product->price + $tax + $shippingCost;

        // 4. Mulai Transaksi Database
        DB::beginTransaction();

        try {
            $buyer = Buyer::firstOrCreate(
                ['user_id' => Auth::id()],
                ['name' => Auth::user()->name, 'address' => $request->address] 
            );

            // Simpan ke tabel transactions
            $transaction = Transaction::create([
                'code' => 'TRX-' . mt_rand(10000, 99999) . '-' . time(), 
                'buyer_id' => $buyer->id, //
                'store_id' => $product->store_id, //
                'address' => $request->address,
                'address_id' => 0,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'shipping' => 'Manual', 
                'shipping_type' => $request->shipping_type,
                'shipping_cost' => $shippingCost,
                'tracking_number' => null,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'payment_status' => 'unpaid',
            ]);

            // Simpan detail produk ke tabel transaction_details
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'price' => $product->price,
                // Tambahkan kolom lain jika ada di migration details (misal quantity)
            ]);

            DB::commit();

            // Redirect ke dashboard atau halaman sukses
            return redirect()->route('dashboard')->with('success', 'Pembelian berhasil! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem: ' . $e->getMessage()]);
        }
    }
}