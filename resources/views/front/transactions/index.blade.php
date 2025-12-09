@extends('layouts.front')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
            <h1 class="text-2xl font-bold text-slate-900">Riwayat Transaksi</h1>
            <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-full bg-white border border-slate-200 text-slate-600 text-sm font-bold hover:border-primary hover:text-primary transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
            </a>
        </div>

        @if($transactions->count() > 0)
            <div class="flex flex-col gap-5">
                @foreach($transactions as $trx)
                    <a href="{{ route('transactions.details', $trx->code) }}" class="group bg-white p-6 rounded-3xl border border-slate-200 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                    <i class="fa-solid fa-bag-shopping"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Belanja</p>
                                    <p class="text-sm font-bold text-slate-900">{{ $trx->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-3">
                                @if($trx->payment_status == 'paid')
                                    <span class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold border border-green-100">
                                        Berhasil
                                    </span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-orange-50 text-orange-700 text-xs font-bold border border-orange-100">
                                        Menunggu Pembayaran
                                    </span>
                                @endif
                            </div>
                        </div>

                        <hr class="border-slate-100 mb-4">

                        <div class="flex items-center gap-4">
                            @php 
                                // AMBIL ITEM PERTAMA (BISA JADI NULL JIKA DATA RUSAK)
                                $firstItem = $trx->transactionDetails->first(); 
                            @endphp

                            @if($firstItem && $firstItem->product)
                                <div class="w-16 h-16 rounded-xl bg-slate-50 overflow-hidden border border-slate-100 flex-shrink-0">
                                    <img src="{{ asset('storage/' . $firstItem->product->thumbnail) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-slate-900 text-sm line-clamp-1">{{ $firstItem->product->name }}</h3>
                                    <p class="text-xs text-slate-500 mb-1">{{ $firstItem->product->store->name ?? 'Toko' }}</p>
                                    @if($trx->transactionDetails->count() > 1)
                                        <p class="text-xs text-slate-400">+ {{ $trx->transactionDetails->count() - 1 }} produk lainnya</p>
                                    @endif
                                </div>
                            @else
                                <div class="w-16 h-16 rounded-xl bg-red-50 flex items-center justify-center border border-red-100 text-red-400 flex-shrink-0">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-red-500 text-sm">Data Produk Tidak Ditemukan</h3>
                                    <p class="text-xs text-slate-400">Hubungi admin untuk cek transaksi ini.</p>
                                </div>
                            @endif
                            
                            <div class="text-right">
                                <p class="text-xs text-slate-400 mb-1">Total Belanja</p>
                                <p class="text-lg font-black text-primary">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-receipt text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Transaksi</h3>
                <p class="text-slate-500 mb-6 text-sm text-center max-w-xs">Kamu belum pernah belanja nih. Yuk mulai cari barang impianmu!</p>
                <a href="{{ route('home') }}" class="px-6 py-2.5 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection