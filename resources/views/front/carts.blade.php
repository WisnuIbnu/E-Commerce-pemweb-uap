@extends('layouts.front')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-slate-900">Keranjang Belanja</h1>
            <span class="px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-bold text-slate-600">
                {{ $carts->count() }} Item
            </span>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-2xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check"></i>
                <span class="font-bold text-sm">{{ session('success') }}</span>
            </div>
        @endif

        @if($carts->count() > 0)
            <div class="flex flex-col gap-4">
                @php $totalGrand = 0; @endphp
                @foreach($carts as $cart)
                    @php
                        // Logika Harga: Prioritas Harga Varian
                        $price = $cart->variant && $cart->variant->price > 0 ? $cart->variant->price : $cart->product->price;
                        $subtotal = $price * $cart->quantity;
                        $totalGrand += $subtotal;
                    @endphp

                    <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col sm:flex-row items-center gap-5 transition-all hover:shadow-md">
                        
                        <div class="w-20 h-20 flex-shrink-0 bg-slate-50 rounded-2xl overflow-hidden border border-slate-100 relative group">
                            <img src="{{ asset('storage/' . $cart->product->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>

                        <div class="flex-1 w-full text-center sm:text-left">
                            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-base line-clamp-1">{{ $cart->product->name }}</h3>
                                    <div class="flex items-center justify-center sm:justify-start gap-2 text-xs text-slate-500 mt-1 mb-2">
                                        <i class="fa-solid fa-store text-slate-300"></i>
                                        <span>{{ $cart->product->store->name }}</span>
                                    </div>
                                    
                                    <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                        @if($cart->variant)
                                            @if($cart->variant->color)
                                                <span class="px-2 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-600">
                                                    {{ $cart->variant->color }}
                                                </span>
                                            @endif
                                            @if($cart->variant->size)
                                                <span class="px-2 py-0.5 rounded-full bg-slate-100 border border-slate-200 text-[10px] font-bold text-slate-600">
                                                    {{ $cart->variant->size }}
                                                </span>
                                            @endif
                                        @endif

                                        <span class="text-xs text-slate-400 font-medium ml-1">
                                            {{ $cart->quantity }} x Rp {{ number_format($price, 0, ',', '.') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-row sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-4 sm:gap-1">
                            
                            <div class="text-right">
                                <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total</span>
                                <span class="text-lg font-black text-primary">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>

                            <div class="flex items-center gap-2 mt-1">
                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-full flex items-center justify-center border border-slate-200 text-slate-400 hover:border-red-500 hover:text-red-500 hover:bg-red-50 transition-all" title="Hapus">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>

                                <a href="{{ route('front.checkout', $cart->product->slug) }}" class="px-4 py-1.5 rounded-full bg-primary text-white text-xs font-bold flex items-center gap-2 hover:bg-primary-dark transition-all shadow-md shadow-primary/30">
                                    Beli Ini
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                @endforeach

                <div class="mt-4 bg-white p-5 rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 sticky bottom-4 z-10">
                    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                        <div class="text-center sm:text-left flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-bag-shopping text-lg"></i>
                            </div>
                            <div>
                                <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">Total Estimasi</p>
                                <h2 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalGrand, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                        
                        <button class="w-full sm:w-auto px-6 py-3 bg-primary text-white font-bold rounded-full hover:bg-primary-dark transition-all shadow-lg shadow-primary/30 flex items-center justify-center gap-2 text-sm">
                            Checkout Semua
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>

            </div>
        @else
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-3xl border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                    <i class="fa-solid fa-basket-shopping text-3xl text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Keranjang Kosong</h3>
                <p class="text-slate-500 mb-6 text-sm text-center max-w-xs">Belum ada barang nih. Yuk cari produk impianmu!</p>
                <a href="{{ route('home') }}" class="px-6 py-2.5 bg-slate-900 text-white text-sm font-bold rounded-full hover:bg-primary transition-all shadow-lg">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection