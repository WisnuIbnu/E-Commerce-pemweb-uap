@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8 text-gray-800">Seller Dashboard</h1>

    <!-- Statistik Toko: Total Produk, Total Pesanan, Status Toko -->
    <div class="grid grid-cols-3 gap-6 mb-6">
        <!-- Total Produk -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Total Product</h3>
            <p class="text-2xl font-bold">{{ $totalProducts }}</p>
        </div>

        <!-- Total Pesanan -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Total Orders</h3>
            <p class="text-2xl font-bold">{{ $totalOrders }}</p>
        </div>

        <!-- Status Toko -->
        <div class="flex flex-col items-center bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-medium text-gray-900">Status</h3>
            <p class="text-xl font-semibold {{ $store->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                {{ $store->is_verified ? 'Verified' : 'Pending Verification' }}
            </p>
        </div>
    </div>

    <!-- Kelola Toko -->
    <h2 class="text-xl font-semibold mb-4">Manage Store</h2>
    <div class="grid grid-cols-3 gap-6">
        <!-- Profil Toko -->
        <a href="{{ route('seller.store.edit') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Profile</h4>
        </a>

        <!-- Kategori Produk -->
        <a href="{{ route('seller.categories.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Categories</h4>
        </a>

        <!-- Produk -->
        <a href="{{ route('seller.products.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Products</h4>
        </a>

        <!-- Pesanan Masuk -->
        <a href="{{ route('seller.orders.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Orders</h4>
        </a>

        <!-- Saldo Toko -->
        <a href="{{ route('seller.balance.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Balance</h4>
        </a>

        <!-- Penarikan Dana -->
        <a href="{{ route('seller.withdrawals.index') }}" class="flex flex-col items-center bg-gray-200 p-6 rounded-lg shadow-md text-center">
            
            <h4 class="text-lg font-medium">Withdrawal</h4>
        </a>
    </div>
</div>
@endsection
