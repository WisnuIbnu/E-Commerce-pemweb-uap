<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class StoreController extends Controller
{
    /* ============================================================
       STORE REGISTRATION METHODS (BARU DITAMBAHKAN)
       ============================================================ */
    
    /**
     * Tampilkan form registrasi toko
     */
    public function register()
    {
        // Cek apakah user sudah punya toko
        $existingStore = DB::table('stores')->where('user_id', Auth::id())->first();
        
        if ($existingStore) {
            return redirect()->route('store.dashboard')
                ->with('info', 'Anda sudah memiliki toko.');
        }

        return view('store.register');
    }

    /**
     * Proses registrasi toko baru
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'banner' => 'nullable|image|max:2048'
        ], [
            'name.required' => 'Nama toko wajib diisi.',
            'address.required' => 'Alamat toko wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'banner.image' => 'File harus berupa gambar.',
            'banner.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        // Cek apakah user sudah punya toko
        $existingStore = DB::table('stores')->where('user_id', Auth::id())->first();
        
        if ($existingStore) {
            return redirect()->route('store.dashboard')
                ->with('error', 'Anda sudah memiliki toko.');
        }

        // Cek apakah nama toko sudah digunakan
        $nameTaken = DB::table('stores')->where('name', $request->name)->exists();
        if ($nameTaken) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'Nama toko sudah digunakan.']);
        }

        // Upload banner jika ada
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('store_banners', 'public');
        }

        // Buat toko baru
        $storeId = DB::table('stores')->insertGetId([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'banner' => $bannerPath,
            'is_verified' => 0, // Belum terverifikasi
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Buat saldo toko (balance awal 0)
        DB::table('store_balances')->insert([
            'store_id' => $storeId,
            'balance' => 0,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // Update role user menjadi seller
        DB::table('users')
            ->where('id', Auth::id())
            ->update([
                'role' => 'seller',
                'updated_at' => now()
            ]);

        return redirect()->route('store.dashboard')
            ->with('success', 'Toko berhasil didaftarkan! Menunggu verifikasi admin.');
    }

    /**
     * Tampilkan form edit registrasi toko
     */
    public function edit()
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect()->route('store.register')
                ->with('error', 'Anda belum memiliki toko.');
        }

        return view('store.edit', compact('store'));
    }

    /**
     * Update data registrasi toko
     */
    public function update(Request $request)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('store.register')
                ->with('error', 'Anda belum memiliki toko.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:20',
            'banner' => 'nullable|image|max:2048'
        ], [
            'name.required' => 'Nama toko wajib diisi.',
            'address.required' => 'Alamat toko wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'banner.image' => 'File harus berupa gambar.',
            'banner.max' => 'Ukuran gambar maksimal 2MB.'
        ]);

        // Cek apakah nama toko sudah digunakan oleh toko lain
        $nameTaken = DB::table('stores')
            ->where('name', $request->name)
            ->where('id', '!=', $store->id)
            ->exists();
            
        if ($nameTaken) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['name' => 'Nama toko sudah digunakan.']);
        }

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'updated_at' => now()
        ];

        // Upload banner baru jika ada
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('store_banners', 'public');
            $data['banner'] = $bannerPath;
        }

        DB::table('stores')->where('id', $store->id)->update($data);

        return redirect()->route('store.edit')
            ->with('success', 'Data toko berhasil diperbarui.');
    }

    /* ============================================================
       EXISTING METHODS (TIDAK BERUBAH)
       ============================================================ */

    // Dashboard
    public function dashboard()
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect('/')->with('error', 'Store not found');
        }

        // Summary statistics
        $totalOrders = DB::table('transactions')
            ->where('store_id', $store->id)
            ->count();

        $completedOrders = DB::table('transactions')
            ->where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->count();

        $onProcess = DB::table('transactions')
            ->where('store_id', $store->id)
            ->whereIn('payment_status', ['pending', 'process'])
            ->count();

        $revenueThisMonth = DB::table('transactions')
            ->where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('grand_total');

        // Sales chart data (last 12 days)
        $salesData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = DB::table('transactions')
                ->where('store_id', $store->id)
                ->where('payment_status', 'paid')
                ->whereDate('created_at', $date->format('Y-m-d'))
                ->sum('grand_total');
            $salesData[] = [
                'date' => $date->format('d M'),
                'amount' => $sales
            ];
        }

        // Top selling products
        $topProducts = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('products', 'transaction_details.product_id', '=', 'products.id')
            ->leftJoin('product_images', function($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                     ->where('product_images.is_thumbnail', '=', 1);
            })
            ->where('transactions.store_id', $store->id)
            ->where('transactions.payment_status', 'paid')
            ->select('products.id', 'products.name', 'products.price', 'product_images.image',
                     DB::raw('SUM(transaction_details.qty) as total_sold'))
            ->groupBy('products.id', 'products.name', 'products.price', 'product_images.image')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Recent transactions
        $recentTransactions = DB::table('transactions')
            ->join('buyers', 'transactions.buyer_id', '=', 'buyers.id')
            ->join('users', 'buyers.user_id', '=', 'users.id')
            ->where('transactions.store_id', $store->id)
            ->select('transactions.*', 'users.name as buyer_name', 'users.email as buyer_email')
            ->orderBy('transactions.created_at', 'desc')
            ->limit(5)
            ->get();

        // Customer count
        $customerCount = DB::table('transactions')
            ->where('store_id', $store->id)
            ->distinct('buyer_id')
            ->count('buyer_id');

        // Available balance
        $balance = DB::table('store_balances')
            ->where('store_id', $store->id)
            ->first();

        return view('store.dashboard-seller', compact(
            'store', 'totalOrders', 'completedOrders', 'onProcess', 
            'revenueThisMonth', 'salesData', 'topProducts', 
            'recentTransactions', 'customerCount', 'balance'
        ));
    }

    // Orders Management
    public function orders(Request $request)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $status = $request->get('status', 'all');
        
        $query = DB::table('transactions')
            ->join('buyers', 'transactions.buyer_id', '=', 'buyers.id')
            ->join('users', 'buyers.user_id', '=', 'users.id')
            ->where('transactions.store_id', $store->id)
            ->select('transactions.*', 'users.name as buyer_name', 'users.email as buyer_email');

        if ($status != 'all') {
            $query->where('transactions.payment_status', $status);
        }

        $orders = $query->orderBy('transactions.created_at', 'desc')->paginate(10);

        return view('store.orders', compact('orders', 'status', 'store'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,process,paid,cancelled',
            'tracking_number' => 'nullable|string'
        ]);

        DB::table('transactions')
            ->where('id', $id)
            ->update([
                'payment_status' => $request->status,
                'tracking_number' => $request->tracking_number,
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    // Store Balance
    public function balance()
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $balance = DB::table('store_balances')
            ->where('store_id', $store->id)
            ->first();

        $histories = DB::table('store_balance_histories')
            ->where('store_balance_id', $balance->id ?? 0)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('store.balance', compact('store', 'balance', 'histories'));
    }

    // Withdrawal
    public function withdrawal()
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $balance = DB::table('store_balances')
            ->where('store_id', $store->id)
            ->first();

        $withdrawals = DB::table('withdrawals')
            ->where('store_balance_id', $balance->id ?? 0)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('store.withdrawal', compact('store', 'balance', 'withdrawals'));
    }

    public function withdrawalSubmit(Request $request)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $request->validate([
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'amount' => 'required|numeric|min:10000'
        ]);

        $balance = DB::table('store_balances')
            ->where('store_id', $store->id)
            ->first();

        if (!$balance || $request->amount > $balance->balance) {
            return redirect()->back()->with('error', 'Insufficient balance');
        }

        DB::table('withdrawals')->insert([
            'store_balance_id' => $balance->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'status' => 'pending',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted');
    }

    // Manage Store
    public function manage()
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $products = DB::table('products')
            ->leftJoin('product_images', function($join) {
                $join->on('products.id', '=', 'product_images.product_id')
                     ->where('product_images.is_thumbnail', '=', 1);
            })
            ->leftJoin('product_categories', 'products.product_category_id', '=', 'product_categories.id')
            ->where('products.store_id', $store->id)
            ->select('products.*', 'product_images.image', 'product_categories.name as category_name')
            ->paginate(12);

        $categories = DB::table('product_categories')->get();

        return view('store.manage', compact('store', 'products', 'categories'));
    }

    public function updateStore(Request $request)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner' => 'nullable|image|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => now()
        ];

        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('store_banners', 'public');
            $data['banner'] = $bannerPath;
        }

        DB::table('stores')->where('id', $store->id)->update($data);

        return redirect()->back()->with('success', 'Store updated successfully');
    }

    public function createProduct(Request $request)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:0',
            'category_id' => 'required|exists:product_categories,id',
            'images.*' => 'image|max:2048'
        ]);

        $productId = DB::table('products')->insertGetId([
            'store_id' => $store->id,
            'product_category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'condition' => 'new',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('product_images', 'public');
                DB::table('product_images')->insert([
                    'product_id' => $productId,
                    'image' => $imagePath,
                    'is_thumbnail' => $index == 0 ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        return redirect()->back()->with('success', 'Product created successfully');
    }

    public function deleteProduct($id)
    {
        $store = DB::table('stores')->where('user_id', Auth::id())->first();
        
        DB::table('products')
            ->where('id', $id)
            ->where('store_id', $store->id)
            ->delete();

        return redirect()->back()->with('success', 'Product deleted successfully');
    }
}