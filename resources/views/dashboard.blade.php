@extends('layouts.front')

@section('title', 'Dashboard Saya')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
             <i class="fa-solid fa-bag-shopping text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Akun Saya</h1>
            <p class="text-indigo-100 text-sm">Kelola profil, pesanan, dan informasi akun Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-64 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 text-primary flex items-center justify-center text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800">{{ Auth::user()->name }}</h3>
                        <p class="text-xs text-slate-500">{{ Auth::user()->email }}</p>
                    </div>
                    <nav class="p-4 space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl bg-primary/5 text-primary">
                            <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-user-gear w-5"></i> Edit Profil
                        </a>
                        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-600 rounded-xl hover:bg-slate-50 transition-colors">
                            <i class="fa-solid fa-box-open w-5"></i> Riwayat Pesanan
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="mt-4 pt-4 border-t border-slate-100">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-500 rounded-xl hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <div class="flex-1 space-y-6">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kredit Akun</p>
                            <p class="text-xl font-extrabold text-slate-800">Rp 0</p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pesanan Aktif</p>
                            <p class="text-xl font-extrabold text-slate-800">0 Pesanan</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Selamat Datang, {{ Auth::user()->name }}!</h2>
                    <p class="text-slate-600 mb-6">
                        Ini adalah halaman dashboard akun Anda. Anda dapat melihat riwayat pesanan terbaru dan mengelola informasi akun Anda dari sini.
                    </p>
                    
                    <div class="bg-slate-50 rounded-xl p-8 text-center border-2 border-dashed border-slate-200">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white text-slate-300 mb-4 shadow-sm">
                            <i class="fa-solid fa-box-open text-2xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800">Belum ada pesanan terbaru</h3>
                        <p class="text-slate-500 text-sm mt-1 mb-4">Yuk, mulai belanja dan temukan produk favoritmu!</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-primary text-white font-bold text-sm hover:bg-primary-dark transition-all shadow-lg shadow-indigo-500/20">
                            Mulai Belanja <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection