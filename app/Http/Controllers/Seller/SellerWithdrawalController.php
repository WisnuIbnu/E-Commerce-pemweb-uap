<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerWithdrawalController extends Controller
{
    protected function sellerStore(): Store
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }

    public function index()
    {
        $store = $this->sellerStore();

        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance'  => 0]
        );

        $totalSales = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $availableBalance = max($totalSales - $totalWithdrawn, 0);

        $withdrawals = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->latest()
            ->paginate(10);

        return view('seller.withdrawals.index', [
            'store'            => $store,
            'availableBalance' => $availableBalance,
            'withdrawals'      => $withdrawals,
        ]);
    }

    public function store(Request $request)
    {
        $store = $this->sellerStore();

        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance'  => 0]
        );

        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:50000'],
            'note'   => ['nullable', 'string', 'max:255'],
        ]);

        // Hitung saldo tersedia
        $totalSales = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $availableBalance = max($totalSales - $totalWithdrawn, 0);

        if ($data['amount'] > $availableBalance) {
            return back()->withErrors([
                'amount' => 'Saldo tidak mencukupi untuk penarikan ini.',
            ])->withInput();
        }

        if (
            empty($store->bank_name) ||
            empty($store->bank_account_number) ||
            empty($store->bank_account_name)
        ) {
            return back()
                ->with('error', 'Data bank Anda masih kosong, harap isi di halaman Pengaturan Toko.');
        }


        Withdrawal::create([
            'store_balance_id'    => $storeBalance->id,
            'amount'              => $data['amount'],
            'status'              => Withdrawal::STATUS_PENDING,
            'bank_name'           => $store->bank_name,
            'bank_account_number' => $store->bank_account_number,
            'bank_account_name'   => $store->bank_account_name,
            'note'                => $data['note'] ?? null,
        ]);

        return back()->with('success', 'Pengajuan penarikan berhasil dikirim. Menunggu persetujuan admin.');
    }
}
