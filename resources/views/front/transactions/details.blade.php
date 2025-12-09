@extends('layouts.front')

@section('title', 'Detail Transaksi #' . $transaction->code)

@section('content')
<div class="bg-slate-50 border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <nav class="flex items-center gap-2 text-sm text-slate-500 font-medium">
            <a href="{{ route('transactions.index') }}" class="hover:text-primary transition-colors">Transaksi</a>
            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
            <span class="text-slate-900">Detail</span>
        </nav>
    </div>
</div>

<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Detail Transaksi</h1>
                <p class="text-slate-500 text-sm mt-1">Kode: #{{ $transaction->code }}</p>
            </div>
            
            @if($transaction->payment_status == 'paid')
                <span class="px-4 py-2 rounded-full bg-green-100 text-green-700 text-sm font-bold border border-green-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-check"></i> Pembayaran Berhasil
                </span>
            @else
                <span class="px-4 py-2 rounded-full bg-orange-100 text-orange-700 text-sm font-bold border border-orange-200 flex items-center gap-2">
                    <i class="fa-solid fa-clock"></i> Menunggu Pembayaran
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h2 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-box text-slate-400"></i> Daftar Produk
                    </h2>
                    
                    <div class="flex flex-col gap-6">
                        @foreach($transaction->transactionDetails as $detail)
                            <div class="flex gap-4">
                                <div class="w-20 h-20 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $detail->product->thumbnail) }}" class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-slate-900 text-sm">{{ $detail->product->name }}</h3>
                                    <p class="text-xs text-slate-500 mt-1 mb-2">{{ $transaction->store->name }}</p>
                                    <div class="flex justify-between items-end">
                                        <p class="text-sm font-bold text-slate-700">Rp {{ number_format($detail->price, 0, ',', '.') }}</p>
                                        </div>
                                </div>
                            </div>
                            @if(!$loop->last) <hr class="border-slate-100"> @endif
                        @endforeach
                    </div>
                </div>

                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                    <h2 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-truck-fast text-slate-400"></i> Info Pengiriman
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Kurir</p>
                            <p class="text-sm font-bold text-slate-900 capitalize">{{ $transaction->shipping_type }}</p>
                            <p class="text-xs text-slate-500 mt-1">Biaya: Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">No. Resi</p>
                            <p class="text-sm font-bold text-slate-900 tracking-wider">
                                {{ $transaction->tracking_number ?? '-' }}
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-xs font-bold text-slate-400 uppercase mb-1">Alamat Tujuan</p>
                            <p class="text-sm text-slate-700 leading-relaxed">
                                {{ $transaction->address }}, {{ $transaction->city }}, {{ $transaction->postal_code }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm sticky top-6">
                    <h2 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-receipt text-slate-400"></i> Rincian Biaya
                    </h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Total Harga Barang</span>
                            <span class="font-bold text-slate-900">
                                @php 
                                    $subtotal = $transaction->grand_total - $transaction->shipping_cost - $transaction->tax; 
                                @endphp
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Biaya Pengiriman</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-500">Pajak (11%)</span>
                            <span class="font-bold text-slate-900">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-slate-900">Total Bayar</span>
                            <span class="text-xl font-black text-primary">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($transaction->payment_status == 'unpaid')
                        <button class="w-full mt-6 py-3 rounded-full bg-primary text-white font-bold hover:bg-primary-dark transition-all shadow-lg shadow-primary/30">
                            Bayar Sekarang
                        </button>
                    @endif
                    
                    <a href="https://wa.me/6285895311686?text=Halo%20kak%20saya%20mau%20tanya%20transaksi%20{{ $transaction->code }}" target="_blank" class="w-full mt-3 py-3 rounded-full border border-slate-200 text-slate-600 font-bold hover:bg-slate-50 transition-all flex justify-center items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-green-500 text-lg"></i> Hubungi Penjual
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection