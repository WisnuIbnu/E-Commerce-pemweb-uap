<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Menghitung status 'unpaid' DAN 'paid' sebagai Pesanan Aktif
        $activeOrders = Transaction::whereHas('buyer', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereIn('payment_status', ['unpaid', 'paid']) 
            ->count();

        // Ambil 3 Transaksi Terbaru
        $recentTransactions = Transaction::with('transactionDetails.product')
            ->whereHas('buyer', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->take(3)
            ->get();
        
        return view('dashboard', compact('user', 'activeOrders', 'recentTransactions'));
    }
}