@extends('layouts.front')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="bg-slate-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-slate-900 mb-8">Keranjang Belanja Saya</h1>

        @if(session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Berhasil!</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Info:</span> {{ session('error') }}
            </div>
        @endif

        @if($carts->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="divide-y divide-slate-100">
                    @foreach($carts as $cart)
                        <div class="p-6 flex flex-col sm:flex-row items-center gap-6">
                            <div class="w-24 h-24 flex-shrink-0 bg-slate-50 rounded-xl overflow-hidden border border-slate-100">
                                <img src="{{ asset('storage/' . $cart->product->thumbnail) }}" class="w-full h-full object-cover">
                            </div>

                            <div class="flex-1 text-center sm:text-left">
                                <h3 class="font-bold text-slate-900 text-lg">{{ $cart->product->name }}</h3>
                                <p class="text-sm text-slate-500 mb-2">Toko: {{ $cart->product->store->name }}</p>
                                <p class="text-primary font-bold text-xl">Rp {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                            </div>

                            <div class="flex flex-col gap-3 w-full sm:w-auto">
                                <a href="{{ route('front.checkout', $cart->product->slug) }}" class="px-6 py-2 bg-primary text-white text-sm font-bold rounded-full hover:bg-primary-dark transition-colors text-center">
                                    Beli Ini
                                </a>

                                <form action="{{ route('carts.destroy', $cart->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-full px-6 py-2 border border-slate-200 text-slate-500 text-sm font-bold rounded-full hover:border-red-500 hover:text-red-500 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-2xl border border-dashed border-slate-300">
                <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-slate-50 text-slate-300 mb-4">
                    <i class="fa-solid fa-cart-shopping text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900">Keranjang Masih Kosong</h3>
                <p class="text-slate-500 mb-6">Yuk, cari produk impianmu sekarang!</p>
                <a href="{{ route('home') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-xl hover:bg-primary-dark transition-colors shadow-lg shadow-indigo-500/30">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</div>
@endsection