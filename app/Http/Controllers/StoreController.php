<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * API: Ambil data profil store milik user login (JSON)
     */
    public function profile()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'success' => true,
            'data'    => $store
        ]);
    }

    /**
     * VIEW: halaman profil toko
     */
    public function profilePage()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();
        return view('seller.store.profile', compact('store'));
    }

    /**
     * Update Profil Toko
     */
    public function update(Request $request)
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'about'       => 'required|string',
            'phone'       => 'required|string|max:20',
            'address_id'  => 'nullable|string|max:100',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'postal_code' => 'required|string|max:10',
            'bank_name'   => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:50',
        ]);

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }

            $logoPath = $request->file('logo')->store('stores', 'public');
            $store->logo = $logoPath;
        }

        // Update Field
        $store->update([
            'name'        => $request->name,
            'about'       => $request->about,
            'phone'       => $request->phone,
            'address_id'  => $request->address_id,
            'city'        => $request->city,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'bank_name'   => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
        ]);

        return redirect()->back()->with('success', 'Profil toko berhasil diperbarui!');
    }

    /**
     * Halaman Toko Publik (Customer View)
     */
    public function showPublic($id)
    {
        $store = Store::findOrFail($id);
        $products = $store->products()->latest()->get();

        return view('seller.store-public', compact('store', 'products'));
    }

    /**
     * FORM Pendaftaran Toko (hanya member yang belum punya toko)
     */
    public function register()
    {
        $existing = Store::where('user_id', Auth::id())->first();

        if ($existing) {
            return redirect()->route('seller.dashboard')
                ->with('info', 'Anda sudah memiliki toko.');
        }

        return view('seller.store.register');
    }

    /**
     * Simpan Pendaftaran Toko Baru
     */
    public function storeRegister(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'about'       => 'required|string',
            'phone'       => 'required|string|max:20',
            'city'        => 'required|string|max:100',
            'address'     => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        $logo = $request->hasFile('logo')
            ? $request->file('logo')->store('stores', 'public')
            : null;

        $store = Store::create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'logo'        => $logo,
            'about'       => $request->about,
            'phone'       => $request->phone,
            'city'        => $request->city,
            'address'     => $request->address,
            'postal_code' => $request->postal_code,
            'status'      => 'pending',
        ]);

        /**
         * Ubah role user → seller
         */
        $user = User::find(Auth::id());

        try {
            $user->update(['role' => 'seller']);
        } catch (\Exception $e) {
            // Jika enum role belum support 'seller'
        }

        return redirect()->route('seller.dashboard')
            ->with('success', 'Toko berhasil dibuat! Menunggu verifikasi admin.');
    }

    /**
     * Seller Dashboard
     */
    public function dashboard()
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('seller.store.register-form')
                ->with('info', 'Anda belum memiliki toko. Silakan daftar terlebih dahulu.');
        }

        $totalProducts = $store->products()->count();
        $ordersCount = Transaction::where('store_id', $store->id)->count();

        return view('seller.dashboard', compact('store', 'totalProducts', 'ordersCount'));
    }

    /**
     * Wallet / Saldo
     */
    public function wallet()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        $balance = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        return view('seller.balance.index', compact('store', 'balance'));
    }

    /**
     * Wallet History
     */
    public function walletHistory()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        $history = []; // placeholder

        return view('seller.balance.history', compact('store', 'history'));
    }

    /**
     * Halaman Withdraw
     */
    public function withdrawPage()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();
        return view('seller.withdraw.index', compact('store'));
    }

    /**
     * Proses Permintaan Withdraw
     */
    public function withdrawRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000',
        ]);

        return back()->with('success', 'Permintaan penarikan berhasil diajukan.');
    }

    /**
     * Halaman Bank
     */
    public function bankPage()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();
        return view('seller.bank.index', compact('store'));
    }

    /**
     * Update Data Bank
     */
    public function bankUpdate(Request $request)
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'bank_name' => 'nullable|string|max:255',
            'bank_account_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:50',
        ]);

        $store->update([
            'bank_name'           => $request->bank_name,
            'bank_account_name'   => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
        ]);

        return back()->with('success', 'Data bank berhasil diperbarui.');
    }
}
