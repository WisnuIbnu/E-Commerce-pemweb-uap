@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard Penjual</h1>

    <!-- Statistik Toko: Total Produk, Total Pesanan, Status Toko -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <!-- Total Produk -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Total Produk</h3>
            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
        </div>

        <!-- Total Pesanan -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Total Pesanan</h3>
            <p class="text-2xl font-bold">{{ $totalOrders }}</p>
        </div>

        <!-- Status Toko -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Status Toko</h3>
            <p class="text-xl font-semibold {{ $store->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                {{ $store->is_verified ? 'Terverifikasi' : 'Menunggu Verifikasi' }}
            </p>
        </div>
    </div>

    <!-- Kelola Toko -->
    <h2 class="text-xl font-semibold mb-4">Kelola Toko</h2>
    <div class="grid grid-cols-3 gap-6">
        <!-- Profil Toko -->
        <a href="{{ route('seller.store.edit') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">store</span>
            <h4 class="text-lg font-medium">Profil Toko</h4>
        </a>

        <!-- Kategori Produk -->
        <a href="{{ route('seller.categories.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">category</span>
            <h4 class="text-lg font-medium">Kategori Produk</h4>
        </a>

        <!-- Produk -->
        <a href="{{ route('seller.products.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">inventory_2</span>
            <h4 class="text-lg font-medium">Produk</h4>
        </a>

        <!-- Pesanan Masuk -->
        <a href="{{ route('seller.orders.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">receipt_long</span>
            <h4 class="text-lg font-medium">Pesanan Masuk</h4>
        </a>

        <!-- Saldo Toko -->
        <a href="{{ route('seller.balance.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">monetization_on</span>
            <h4 class="text-lg font-medium">Saldo Toko</h4>
        </a>

        <!-- Penarikan Dana -->
        <a href="{{ route('seller.withdrawals.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            <span class="material-icons">payment</span>
            <h4 class="text-lg font-medium">Penarikan Dana</h4>
        </a>
    </div>
</div>
@endsection
