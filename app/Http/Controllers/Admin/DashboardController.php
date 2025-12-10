<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'member')->count(),
            'total_stores' => Store::where('is_verified', true)->count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('payment_status', 'delivered')->sum('grand_total'),
            'monthly_revenue' => Transaction::where('payment_status', 'delivered')
                ->whereYear('created_at', Carbon::now()->year)
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('grand_total'),
        ];
        
        $totalUsers = $stats['total_users'];
        $totalStores = $stats['total_stores'];
        $pendingStores = $stats['pending_stores'];
        $totalProducts = $stats['total_products'];
        $totalRevenue = $stats['total_revenue'];
        $monthlyRevenue = $stats['monthly_revenue'];
        
        $recentTransactions = Transaction::with(['buyer', 'store'])
            ->latest()
            ->take(10)
            ->get();
        
        $pendingVerifications = Store::where('is_verified', false)
            ->with('user')
            ->latest()
            ->take(5)
            ->get();
        
        $monthlyRevenueChart = Transaction::where('payment_status', 'delivered')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(grand_total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        $topProducts = Product::select('products.id', 'products.name', 'products.price', 'products.store_id')
            ->selectRaw('SUM(transaction_details.qty) as total_sold')
            ->join('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where('transactions.payment_status', 'delivered')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.store_id')
            ->with('store')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();
        
        $recentUsers = User::where('role', 'member')
            ->latest()
            ->take(5)
            ->get();
        
        $recentStores = Store::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'totalUsers',
            'totalStores',
            'pendingStores',
            'totalProducts',
            'totalRevenue',
            'monthlyRevenue',
            'recentTransactions',
            'pendingVerifications',
            'monthlyRevenueChart',
            'topProducts',
            'recentUsers',
            'recentStores'
        ));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['buyer', 'store', 'transactionDetails.product'])
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}