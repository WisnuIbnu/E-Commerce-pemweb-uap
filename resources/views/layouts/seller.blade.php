@extends('layouts.front')

@section('title')
    @yield('title', 'Dashboard Penjual')
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    {{-- HEADER (Sama seperti Dashboard) --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
             <i class="fa-solid fa-store text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">@yield('title')</h1>
            <p class="text-indigo-100 text-sm">@yield('subtitle', 'Kelola toko dan bisnis Anda dengan mudah.')</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- SIDEBAR NAVIGASI (Disamakan dengan Dashboard) --}}
            <div class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    {{-- Profil User --}}
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->email }}</p>
                        
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-600">
                            Penjual
                        </span>
                    </div>
                    
                    {{-- MENU NAVIGASI --}}
                    <nav class="p-4 space-y-1">
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

                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Akun</div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('profile.edit') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
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
                @yield('seller-content')
            </div>

        </div>
    </div>
</div>
@endsection