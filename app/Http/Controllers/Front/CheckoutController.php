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
        
        $tax = $product->price * 0.11;
        $total = $product->price + $tax;

        return view('front.checkout', compact('product', 'tax', 'total'));
    }

    // Memproses pembelian
    public function store(Request $request, $slug)
    {
        // Validasi Input
        $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'shipping_type' => 'required|in:regular,express,instant',
        ]);

        // Ambil Data Produk
        $product = Product::with('store')->where('slug', $slug)->firstOrFail();

        // [CEK STOK] memastikan stok masih ada sebelum lanjut
        if($product->stock < 1) {
            return redirect()->back()->withErrors(['error' => 'Maaf, stok produk ini sudah habis.']);
        }

        // Hitung Biaya
        $shippingCost = match($request->shipping_type) {
            'express' => 50000,
            'instant' => 35000,
            default => 20000,
        };

        $tax = $product->price * 0.11;
        $grandTotal = $product->price + $tax + $shippingCost;

        // Proses Simpan
        DB::beginTransaction();

        try {
            // Buat/Ambil Buyer (Hanya user_id)
            $buyer = Buyer::firstOrCreate(
                ['user_id' => Auth::id()]
            );

            // Simpan Transaksi
            $transaction = Transaction::create([
                'code' => 'TRX-' . mt_rand(10000, 99999) . '-' . time(), 
                'buyer_id' => $buyer->id,
                'store_id' => $product->store_id,
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

            // Simpan Detail Produk
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => 1, 
                'subtotal' => $product->price, 
            ]);

            // Kurangi Stok Produk di Database
            $product->decrement('stock'); 

            DB::commit();

            // Arahkan ke halaman pembayaran
            return redirect()->route('front.payment', $transaction->code);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal memproses pesanan: ' . $e->getMessage()]);
        }
    }
}