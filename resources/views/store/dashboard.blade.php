@extends('layouts.app')

@section('title', 'Dashboard Seller - ' . $store->name)

@section('content')
<div class="bg-tumbloo-dark min-h-screen">
    
    <div class="bg-tumbloo-black border-b border-tumbloo-accent">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-6">
                    <!-- Store Logo -->
                    <div class="w-20 h-20 rounded-lg overflow-hidden bg-tumbloo-dark border-2 border-tumbloo-accent flex-shrink-0">
                        @if($store->logo)
                            <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-10 h-10 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h1 class="text-3xl font-bold text-tumbloo-white mb-2">{{ $store->name }}</h1>
                        <div class="flex items-center gap-4">
                            @if($store->is_verified)
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-green-500 bg-opacity-20 text-green-400 text-sm font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Terverifikasi
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-3 py-1 bg-yellow-500 bg-opacity-20 text-yellow-400 text-sm font-semibold rounded-full">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Menunggu Verifikasi
                                </span>
                            @endif
                            <span class="text-tumbloo-gray text-sm">{{ $store->city }}</span>
                        </div>
                    </div>
                </div>

                <div class="flex gap-3">
                    <a href="{{ route('store.profile.edit') }}" class="px-4 py-2 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-white border border-tumbloo-accent rounded-lg transition font-medium">
                        Edit Profil
                    </a>
                    <a href="{{ route('store.products.create') }}" class="px-4 py-2 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white rounded-lg transition font-semibold">
                        + Tambah Produk
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-green-500 bg-opacity-10 border-l-4 border-green-500 text-green-400 px-6 py-4 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-blue-500 bg-opacity-10 border-l-4 border-blue-500 text-blue-400 px-6 py-4 rounded-lg">
                {{ session('info') }}
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-tumbloo-white mb-1">{{ $stats['total_products'] }}</div>
                <div class="text-sm text-tumbloo-gray">Total Produk</div>
            </div>

            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-tumbloo-white mb-1">{{ $stats['active_products'] }}</div>
                <div class="text-sm text-tumbloo-gray">Produk Aktif</div>
            </div>

            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-tumbloo-white mb-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
                <div class="text-sm text-tumbloo-gray">Total Saldo</div>
            </div>

            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-500 bg-opacity-20 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
                <div class="text-3xl font-bold text-tumbloo-white mb-1">{{ $stats['pending_orders'] }}</div>
                <div class="text-sm text-tumbloo-gray">Pesanan Pending</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <h2 class="text-xl font-semibold text-tumbloo-white mb-4">Aksi Cepat</h2>
                <div class="space-y-3">
                    <a href="{{ route('store.products.create') }}" class="flex items-center gap-3 p-3 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                        <div class="w-10 h-10 bg-yellow-100 bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition">
                            <svg class="w-5 h-5 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Tambah Produk</div>
                            <div class="text-xs text-tumbloo-gray">Upload produk baru</div>
                        </div>
                    </a>

                    <a href="{{ route('store.orders.index') }}" class="flex items-center gap-3 p-3 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                        <div class="w-10 h-10 bg-blue-500 bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Kelola Pesanan</div>
                            <div class="text-xs text-tumbloo-gray">Lihat & proses pesanan</div>
                        </div>
                    </a>

                    <a href="{{ route('store.balance.index') }}" class="flex items-center gap-3 p-3 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                        <div class="w-10 h-10 bg-green-500 bg-opacity-20 rounded-lg flex items-center justify-center group-hover:bg-opacity-30 transition">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-tumbloo-white font-medium">Saldo & Penarikan</div>
                            <div class="text-xs text-tumbloo-gray">Kelola saldo toko</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="lg:col-span-2 bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-tumbloo-white">Produk Terbaru</h2>
                    <a href="{{ route('store.products.index') }}" class="text-sm text-tumbloo-accent hover:text-tumbloo-accent-light transition">
                        Lihat Semua →
                    </a>
                </div>

                @if($store->products->isEmpty())
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-tumbloo-gray mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-lg font-semibold text-tumbloo-white mb-2">Belum Ada Produk</h3>
                        <p class="text-tumbloo-gray mb-4">Mulai tambahkan produk pertama Anda</p>
                        <a href="{{ route('store.products.create') }}" class="inline-block px-6 py-3 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white rounded-lg transition font-semibold">
                            + Tambah Produk
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($store->products->take(5) as $product)
                            <div class="flex items-center gap-4 p-3 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                                <!-- Product Image -->
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-tumbloo-black flex-shrink-0">
                                    @if($product->images->isNotEmpty())
                                        <img src="{{ asset($product->images->first()->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 min-w-0">
                                    <h3 class="text-tumbloo-white font-medium truncate group-hover:text-tumbloo-accent transition">
                                        {{ $product->name }}
                                    </h3>
                                    <div class="flex items-center gap-3 mt-1">
                                        <span class="text-sm text-blue-400 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-tumbloo-gray">Stok: {{ $product->stock }}</span>
                                    </div>
                                </div>

                                <div class="flex gap-2">
                                    <a href="{{ route('store.products.edit', $product->id) }}" class="p-2 bg-tumbloo-black hover:bg-tumbloo-accent text-tumbloo-gray hover:text-white rounded-lg transition">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection