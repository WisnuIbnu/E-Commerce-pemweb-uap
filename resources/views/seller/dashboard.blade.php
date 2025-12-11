@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Welcome Section -->
    @if($store->is_verified)
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Welcome back, {{ $store->name }}!</h1>
        <p class="text-gray-600 mt-2">Here's what's happening with your store today.</p>
    </div>


        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Products</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalProducts }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Orders</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                </div>
            </div>

        <!-- Store Status -->
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Store Status</p>
                    <p class="text-2xl font-bold {{ $store->is_verified ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ $store->is_verified ? 'Verified' : 'Pending Verification' }}
                    </p>
                </div>
                <div class="{{ $store->is_verified ? 'bg-green-100' : 'bg-yellow-100' }} p-3 rounded-full">
                    <svg class="w-6 h-6 {{ $store->is_verified ? 'text-green-600' : 'text-yellow-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($store->is_verified)
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        @endif
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <h2 class="text-xl font-semibold mb-4 text-gray-900">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 mb-8">
        <!-- Products -->
        <a href="{{ route('seller.products.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
            <div class="flex flex-col items-center text-center">
                <div class="bg-blue-100 p-3 rounded-full mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <h3 class="font-semibold text-gray-900">Products</h3>
                <p class="text-sm text-gray-500 mt-1">Manage products</p>
            </div>
        </a>

            <!-- Orders -->
            <a href="{{ route('seller.orders.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-green-100 p-3 rounded-full mb-3">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Orders</h3>
                    <p class="text-sm text-gray-500 mt-1">View orders</p>
                </div>
            </a>

            <!-- Balance -->
            <a href="{{ route('seller.balance.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-purple-100 p-3 rounded-full mb-3">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Balance</h3>
                    <p class="text-sm text-gray-500 mt-1">Check balance</p>
                </div>
            </a>

            <!-- Withdrawals -->
            <a href="{{ route('seller.withdrawals.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-yellow-100 p-3 rounded-full mb-3">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Withdrawals</h3>
                    <p class="text-sm text-gray-500 mt-1">Request payout</p>
                </div>
            </a>

            <!-- Store Profile -->
            <a href="{{ route('seller.store.edit') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-pink-100 p-3 rounded-full mb-3">
                        <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Store Profile</h3>
                    <p class="text-sm text-gray-500 mt-1">Edit store info</p>
                </div>
            </a>

            <!-- Categories -->
            <a href="{{ route('seller.categories.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex flex-col items-center text-center">
                    <div class="bg-indigo-100 p-3 rounded-full mb-3">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">Categories</h3>
                    <p class="text-sm text-gray-500 mt-1">View categories</p>
                </div>
            </a>
        </div>

        <!-- Recent Products -->
        <div class="bg-white shadow-sm rounded-xl p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">Recent Products</h3>
                <a href="{{ route('seller.products.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all →</a>
            </div>
            <table class="min-w-full text-sm text-gray-700">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2 text-left">Product Name</th>
                        <th class="px-4 py-2 text-left">Price</th>
                        <th class="px-4 py-2 text-left">Stock</th>
                        <th class="px-4 py-2 text-left">Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($store->products->sortByDesc('created_at')->take(5) as $product)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $product->name }}</td>
                            <td class="px-4 py-2">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $product->stock }}</td>
                            <td class="px-4 py-2">{{ $product->productCategory->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">No products yet. <a href="{{ route('seller.products.create') }}" class="text-blue-600 hover:text-blue-800">Add your first product</a></td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <!-- Unverified Store State -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Store Verification Pending</h1>
            <p class="text-gray-600 mt-2">Your store is currently under review.</p>
        </div>

        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-yellow-700">
                        <strong class="font-medium text-yellow-800">Menunggu Konfirmasi Admin</strong><br>
                        Saat ini toko Anda sedang dalam proses verifikasi oleh Admin. Anda belum dapat mengelola produk, pesanan, atau melakukan penarikan dana sampai toko Anda diverifikasi.
                        Silakan cek kembali secara berkala.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mt-8 opacity-50 pointer-events-none grayscale select-none" aria-hidden="true">
            <!-- Mockup of what user would see (disabled) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                 <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                 </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900">0</p>
                 </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm">
                    <p class="text-sm text-gray-500">Store Balance</p>
                    <p class="text-2xl font-bold text-gray-900">Rp 0</p>
                 </div>
            </div>
            
             <h2 class="text-xl font-semibold mb-4 text-gray-900">Quick Actions</h2>
             <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                 <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center h-40">
                    <span class="text-gray-400">Products</span>
                 </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center h-40">
                    <span class="text-gray-400">Orders</span>
                 </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center h-40">
                    <span class="text-gray-400">Balance</span>
                 </div>
                 <div class="bg-white p-6 rounded-xl shadow-sm flex flex-col items-center justify-center h-40">
                    <span class="text-gray-400">Profile</span>
                 </div>
             </div>
        </div>
    @endif
</div>
</div>
@endsection
