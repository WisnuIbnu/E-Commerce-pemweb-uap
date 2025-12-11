@extends('layouts.front')

@section('title', 'Penarikan Saldo')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    
    {{-- HEADER --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
             <i class="fa-solid fa-money-bill-transfer text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Penarikan Saldo</h1>
            <p class="text-indigo-100 text-sm">Kelola rekening bank dan tarik pendapatan hasil penjualan Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- ================= SIDEBAR ================= --}}
            <div class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->email }}</p>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-600">Penjual</span>
                    </div>
                    
                    <nav class="p-4 space-y-1">
                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Penjual</div>
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition"><i class="fa-solid fa-gauge-high w-5"></i> Dashboard</a>
                        <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.orders.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition"><i class="fa-solid fa-clipboard-list w-5"></i> Manajemen Pesanan</a>
                        <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.products.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition"><i class="fa-solid fa-box-open w-5"></i> Kelola Produk</a>
                        <a href="{{ route('seller.store.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.store.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition"><i class="fa-solid fa-store w-5"></i> Edit Profil Toko</a>
                        <a href="{{ route('seller.withdraw.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.withdraw.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition"><i class="fa-solid fa-money-bill-transfer w-5"></i> Penarikan Saldo</a>
                        
                        <div class="border-t border-slate-100 my-2"></div>
                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Akun</div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition"><i class="fa-solid fa-user-pen w-5"></i> Edit Akun User</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition mt-4"><i class="fa-solid fa-right-from-bracket w-5"></i> Logout</button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- ================= KONTEN UTAMA ================= --}}
            <div class="flex-1 space-y-6">

                {{-- Notifikasi --}}
                @if(session('success'))
                    <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3"><i class="fa-solid fa-circle-xmark"></i> {{ session('error') }}</div>
                @endif
                @error('amount')
                    <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3"><i class="fa-solid fa-circle-xmark"></i> {{ $message }}</div>
                @enderror

                {{-- 1. KARTU SALDO & FORM TARIK DANA --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Kartu Saldo --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between h-full bg-gradient-to-br from-indigo-600 to-indigo-800 text-white">
                        <div>
                            <p class="text-indigo-100 text-sm font-medium mb-1">Saldo Aktif</p>
                            <h2 class="text-4xl font-bold">Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}</h2>
                        </div>
                        <div class="mt-6 text-indigo-100 text-xs bg-white/10 p-3 rounded-lg">
                            <i class="fa-solid fa-info-circle mr-1"></i> Penarikan akan diproses maksimal 1x24 jam kerja.
                        </div>
                    </div>

                    {{-- Form Tarik Dana --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                        <h3 class="font-bold text-slate-800 mb-4">Ajukan Penarikan</h3>
                        <form action="{{ route('seller.withdraw.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-sm text-slate-600 mb-2">Jumlah Penarikan (Rp)</label>
                                <input type="number" name="amount" min="10000" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Min. 10.000">
                            </div>
                            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                <i class="fa-solid fa-paper-plane mr-2"></i> Tarik Sekarang
                            </button>
                        </form>
                    </div>
                </div>

                {{-- 2. FORM PENGATURAN BANK --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                        <h3 class="font-bold text-slate-800 text-lg">Rekening Bank Tujuan</h3>
                        <span class="text-xs text-slate-500">Pastikan data valid</span>
                    </div>
                    <form action="{{ route('seller.withdraw.updateBank') }}" method="POST" class="p-6">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Bank</label>
                                <select name="bank_name" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Pilih Bank...</option>
                                    @foreach(['BCA', 'BRI', 'BNI', 'Mandiri', 'BSI', 'CIMB Niaga', 'Jago', 'Seabank'] as $bank)
                                        <option value="{{ $bank }}" {{ ($store->bank_name ?? '') == $bank ? 'selected' : '' }}>{{ $bank }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Rekening</label>
                                <input type="number" name="bank_account_number" value="{{ $store->bank_account_number }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: 1234567890">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Atas Nama</label>
                                <input type="text" name="bank_account_name" value="{{ $store->bank_account_name }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Sesuai buku tabungan">
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button type="submit" class="text-indigo-600 font-bold text-sm hover:underline">Simpan Detail Bank</button>
                        </div>
                    </form>
                </div>

                {{-- 3. RIWAYAT PENARIKAN --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h3 class="font-bold text-slate-800 text-lg">Riwayat Penarikan</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="bg-slate-50 text-slate-500 uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-3">Tanggal</th>
                                    <th class="px-6 py-3">Bank Tujuan</th>
                                    <th class="px-6 py-3">Jumlah</th>
                                    <th class="px-6 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($withdrawals as $wd)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4">{{ $wd->created_at->format('d M Y H:i') }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $wd->bank_name }}</div>
                                        <div class="text-xs text-slate-500">{{ $wd->bank_account_number }} - {{ $wd->bank_account_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-800">Rp {{ number_format($wd->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @if($wd->status == 'pending')
                                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">Menunggu</span>
                                        @elseif($wd->status == 'processed')
                                            <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">Berhasil</span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">Belum ada riwayat penarikan.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4">
                        {{ $withdrawals->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection