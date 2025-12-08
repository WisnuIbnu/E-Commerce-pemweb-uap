@extends('layouts.app')

@section('title', 'Checkout - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-tumbloo-white mb-8">Checkout</h1>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-500 bg-opacity-10 border-l-4 border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 bg-opacity-10 border-l-4 border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            
            @if($isBuyNow)
                <input type="hidden" name="is_buy_now" value="1">
                <input type="hidden" name="product_id" value="{{ $items[0]->product->id }}">
                <input type="hidden" name="quantity" value="{{ $items[0]->quantity }}">
            @endif
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Shipping Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Address -->
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-4">Alamat Pengiriman</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="address" class="block text-sm font-medium text-tumbloo-white mb-2">
                                    Alamat Lengkap *
                                </label>
                                <textarea 
                                    id="address" 
                                    name="address" 
                                    rows="3"
                                    required
                                    class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light @error('address') border-red-500 @enderror"
                                    placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan"
                                >{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="city" class="block text-sm font-medium text-tumbloo-white mb-2">
                                        Kota *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="city" 
                                        name="city" 
                                        value="{{ old('city') }}"
                                        required
                                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light @error('city') border-red-500 @enderror"
                                        placeholder="Nama Kota"
                                    >
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-tumbloo-white mb-2">
                                        Kode Pos *
                                    </label>
                                    <input 
                                        type="text" 
                                        id="postal_code" 
                                        name="postal_code" 
                                        value="{{ old('postal_code') }}"
                                        required
                                        class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light @error('postal_code') border-red-500 @enderror"
                                        placeholder="12345"
                                    >
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Method -->
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-4">Metode Pengiriman</h2>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-tumbloo-dark rounded-lg border-2 border-tumbloo-accent cursor-pointer hover:border-tumbloo-accent-light transition">
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        name="shipping_type" 
                                        value="regular" 
                                        checked
                                        class="w-4 h-4 text-tumbloo-accent focus:ring-tumbloo-accent-light"
                                    >
                                    <div class="ml-3">
                                        <div class="text-tumbloo-white font-semibold">JNE Reguler</div>
                                        <div class="text-sm text-tumbloo-gray">Estimasi 3-5 hari</div>
                                    </div>
                                </div>
                                <div class="text-tumbloo-offwhite font-bold">Rp 15.000</div>
                            </label>

                            <label class="flex items-center justify-between p-4 bg-tumbloo-dark rounded-lg border-2 border-tumbloo-accent/30 cursor-pointer hover:border-tumbloo-accent transition">
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        name="shipping_type" 
                                        value="express"
                                        class="w-4 h-4 text-tumbloo-accent focus:ring-tumbloo-accent-light"
                                    >
                                    <div class="ml-3">
                                        <div class="text-tumbloo-white font-semibold">JNE Express</div>
                                        <div class="text-sm text-tumbloo-gray">Estimasi 1-2 hari</div>
                                    </div>
                                </div>
                                <div class="text-tumbloo-offwhite font-bold">Rp 25.000</div>
                            </label>
                        </div>
                        @error('shipping_type')
                            <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order Items -->
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-4">Produk yang Dibeli</h2>
                        
                        <div class="space-y-4">
                            @foreach($items as $item)
                                <div class="flex gap-4 pb-4 border-b border-tumbloo-accent last:border-0 last:pb-0">
                                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-tumbloo-dark flex-shrink-0">
                                        @if($item->product->images->isNotEmpty())
                                            <img src="{{ asset($item->product->images->first()->image) }}" 
                                                 alt="{{ $item->product->name }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="text-tumbloo-white font-semibold mb-1">{{ $item->product->name }}</h3>
                                        <p class="text-sm text-tumbloo-gray mb-2">{{ $item->product->store->name }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-blue-200 text-sm">{{ $item->quantity }}x Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                                            <span class="text-blue-500 font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-tumbloo-black rounded-lg border border-tumbloo-accent p-6 sticky top-24">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-tumbloo-gray">
                                <span>Subtotal Produk</span>
                                <span class="text-tumbloo-white">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-tumbloo-gray">
                                <span>Ongkir</span>
                                <span class="text-tumbloo-white">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-tumbloo-gray">
                                <span>Pajak (11%)</span>
                                <span class="text-tumbloo-white">Rp {{ number_format($tax, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="border-t border-tumbloo-accent pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold">
                                <span class="text-tumbloo-white">Total Pembayaran</span>
                                <span class="text-blue-500">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button 
                            type="submit"
                            class="w-full bg-green-400 hover:bg-green-500 text-white font-semibold py-3 px-4 rounded-lg transition transform hover:scale-105 mb-3"
                        >
                            Bayar Sekarang
                        </button>

                        @if($isBuyNow)
                            <a href="{{ route('product.show', $items[0]->product->id) }}" 
                               class="block w-full text-center text-red-500 hover:text-red-900 transition">
                                Kembali ke Produk
                            </a>
                        @else
                            <a href="{{ route('cart.index') }}" 
                               class="block w-full text-center text-tumbloo-gray hover:text-tumbloo-white transition">
                                Kembali ke Keranjang
                            </a>
                        @endif

                        <!-- Payment Info -->
                        <div class="mt-6 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent/30">
                            <div class="flex items-start gap-2">
                                <svg class="w-5 h-5 text-green-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                <div>
                                    <p class="text-xs text-tumbloo-gray">
                                        Pembayaran aman dan terenkripsi. Data Anda dilindungi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection