<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Tampilkan form pendaftaran toko.
     */
    public function create()
    {
        // kalau seller sudah punya toko, langsung lempar ke dashboard
        $store = Store::where('user_id', Auth::id())->first();
        if ($store) {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.form');
    }

    /**
     * Simpan data pendaftaran toko.
     */
    public function store(Request $request)
    {
        // 1. VALIDASI INPUT
        $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'logo'        => ['nullable'],
            'about'       => ['nullable', 'string'],
            'phone'       => ['required', 'string', 'max:20'],
            'city'        => ['required', 'string', 'max:100'],
            'address'     => ['required', 'string'],
            'postal_code' => ['required', 'string', 'max:10'],
        ]);

        // 2. UPLOAD LOGO (JIKA ADA & VALID)
        $logoPath = '';  // default string, bukan null

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $logoPath = $request->file('logo')->store('store_logos', 'public');
        }

        // 3. SIAPKAN DATA INSERT
        $data = [
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'logo'        => $logoPath,
            'about'       => $request->about,
            'phone'       => $request->phone,
            'address_id'  => 0,
            'city'        => $request->city,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => 0,
            'status'      => 'pending',
        ];

        // 4. INSERT KE DATABASE
        Store::create($data);

        // 5. REDIRECT KE DASHBOARD SELLER
        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Toko berhasil dibuat dan sedang menunggu verifikasi admin.');
    }

    /**
     * Dashboard seller.
     */
    public function dashboard()
    {
        $store = Store::where('user_id', Auth::id())->first();

        // kalau belum punya toko, lempar ke form pendaftaran
        if (! $store) {
            return redirect()->route('seller.form');
        }

        // 1. JUMLAH PRODUK AKTIF
        $productCount = Product::where('store_id', $store->id)->count();

        // 2. PESANAN HARI INI
        $todayOrders = Transaction::where('store_id', $store->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        // 3. SALDO TOKO (total paid - total withdrawal approved/paid)
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance'  => 0]
        );

        $totalSales = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = Withdrawal::whereHas('storeBalance', function ($q) use ($store) {
                $q->where('store_id', $store->id);
            })
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $saldoToko = max($totalSales - $totalWithdrawn, 0);

        return view('seller.dashboard', [
            'store'        => $store,
            'productCount' => $productCount,
            'todayOrders'  => $todayOrders,
            'saldoToko'    => $saldoToko,
        ]);
    }
}
