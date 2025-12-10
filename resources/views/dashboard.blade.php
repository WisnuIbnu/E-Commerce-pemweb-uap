@extends('layouts.front')

@section('title', 'Dashboard')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    {{-- HEADER --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
             <i class="fa-solid fa-bag-shopping text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">
                @if(Auth::user()->role === 'seller')
                    Dashboard Toko
                @else
                    Akun Saya
                @endif
            </h1>
            <p class="text-indigo-100 text-sm">
                @if(Auth::user()->role === 'seller')
                    Pantau penjualan, kelola produk, dan atur keuangan toko Anda.
                @else
                    Selamat datang kembali, {{ Auth::user()->name }}!
                @endif
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        
        {{-- CALL TO ACTION (KHUSUS MEMBER) --}}
        @if(Auth::user()->role === 'member')
        <div class="bg-white rounded-xl shadow-lg border border-indigo-100 p-5 mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="bg-indigo-100 p-3 rounded-full text-indigo-600 hidden md:block">
                    <i class="fa-solid fa-store text-xl"></i>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Tertarik berjualan?</h2>
                    <p class="text-slate-600 text-sm">Buka toko gratis dan mulai hasilkan cuan!</p>
                </div>
            </div>
            <a href="{{ route('stores.create') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white font-bold text-sm rounded-full hover:bg-indigo-700 transition shadow-md shadow-indigo-200 whitespace-nowrap">
                Buka Toko <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
        @endif

        {{-- STATISTIK RINGKAS (KHUSUS SELLER) --}}
        @if(Auth::user()->role === 'seller')
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            {{-- 1. Saldo Toko (Interaktif) --}}
            <a href="{{ route('seller.balance.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:border-indigo-500 hover:shadow-md transition group">
                <div>
                    <div class="text-sm text-slate-500 mb-1 group-hover:text-indigo-600 transition font-bold">Saldo Toko <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></div>
                    <div class="text-2xl font-bold text-slate-800">Rp {{ number_format($store_balance ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 group-hover:bg-emerald-200 transition">
                    <i class="fa-solid fa-wallet text-xl"></i>
                </div>
            </a>

            {{-- 2. Total Produk (Dibuat Interaktif) --}}
            <a href="{{ route('seller.products.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:border-indigo-500 hover:shadow-md transition group">
                <div>
                    <div class="text-sm text-slate-500 mb-1 group-hover:text-indigo-600 transition font-bold">Total Produk <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></div>
                    <div class="text-2xl font-bold text-slate-800">{{ $products_count ?? 0 }}</div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 group-hover:bg-blue-200 transition">
                    <i class="fa-solid fa-box text-xl"></i>
                </div>
            </a>

            {{-- 3. Pesanan Baru (Dibuat Interaktif) --}}
            <a href="{{ route('seller.orders.index') }}" class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center justify-between hover:border-indigo-500 hover:shadow-md transition group">
                <div>
                    <div class="text-sm text-slate-500 mb-1 group-hover:text-indigo-600 transition font-bold">Pesanan Baru <i class="fa-solid fa-chevron-right text-[10px] ml-1"></i></div>
                    <div class="text-2xl font-bold text-slate-800">0</div>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600 group-hover:bg-orange-200 transition">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                </div>
            </a>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR NAVIGASI --}}
            <div class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    {{-- Profil User --}}
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->email }}</p>
                        
                        <span class="text-xs font-bold px-3 py-1 rounded-full 
                            @if(Auth::user()->role === 'seller') bg-emerald-100 text-emerald-600
                            @elseif(Auth::user()->role === 'admin') bg-rose-100 text-rose-600
                            @else bg-slate-100 text-slate-600 border border-slate-200
                            @endif">
                            {{ Auth::user()->role === 'seller' ? 'Penjual' : (Auth::user()->role === 'admin' ? 'Administrator' : 'Pelanggan') }}
                        </span>
                    </div>
                    
                    {{-- MENU NAVIGASI --}}
                    <nav class="p-4 space-y-1">
                        {{-- MENU KHUSUS SELLER --}}
                        @if(Auth::user()->role === 'seller')
                            <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Penjual</div>
                            
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                                <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                            </a>

                            <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.orders.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                                <i class="fa-solid fa-clipboard-list w-5"></i> Manajemen Pesanan
                            </a>

                            <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.products.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                                <i class="fa-solid fa-box-open w-5"></i> Kelola Produk
                            </a>

                            <a href="{{ route('seller.store.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.store.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                                <i class="fa-solid fa-store w-5"></i> Edit Profil Toko
                            </a>

                            <a href="{{ route('seller.withdraw.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.withdraw.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                                <i class="fa-solid fa-money-bill-transfer w-5"></i> Penarikan Saldo
                            </a>
                            
                            <div class="border-t border-slate-100 my-2"></div>
                        @endif

                        {{-- Menu Umum --}}
                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Akun</div>

                        @if(Auth::user()->role === 'member')
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-indigo-600 bg-indigo-50 rounded-xl font-medium transition">
                                <i class="fa-solid fa-clock-rotate-left w-5"></i> Riwayat Pesanan
                            </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition">
                            <i class="fa-solid fa-user-pen w-5"></i> Edit Akun User
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition mt-4">
                                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- KONTEN UTAMA --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-800">
                            @if(Auth::user()->role === 'seller')
                                Pesanan Terbaru
                            @else
                                Riwayat Pesanan Saya
                            @endif
                        </h2>
                        @if(Auth::user()->role === 'seller')
                            <a href="{{ route('seller.orders.index') }}" class="text-sm font-bold text-primary hover:underline">Lihat Semua</a>
                        @endif
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-10 text-center border-2 border-dashed border-slate-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white text-slate-300 mb-4 shadow-sm">
                            <i class="fa-solid fa-clipboard-list text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">Belum ada pesanan</h3>
                        <p class="text-slate-500 mt-2 mb-6">
                            @if(Auth::user()->role === 'seller')
                                Pesanan baru akan muncul di sini. Pastikan produkmu menarik!
                            @else
                                Yuk, mulai belanja dan temukan produk favoritmu!
                            @endif
                        </p>
                        @if(Auth::user()->role !== 'seller')
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-8 py-3 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-lg shadow-indigo-500/20">
                                Mulai Belanja <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection