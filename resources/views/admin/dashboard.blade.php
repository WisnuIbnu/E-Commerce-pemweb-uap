@extends('admin.layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-tumbloo-black">Dashboard Admin</h1>
            <p class="text-tumbloo-gray mt-1">Selamat datang kembali, {{ Auth::user()->name }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-tumbloo-gray">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Total Users -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Total User</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Stores -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Toko Aktif</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">{{ number_format($stats['total_stores']) }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pending Stores -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Toko Menunggu</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">{{ number_format($stats['pending_stores']) }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            @if($stats['pending_stores'] > 0)
            <a href="{{ route('admin.store-verification.index') }}" class="text-sm text-tumbloo-black hover:text-tumbloo-dark font-medium mt-3 inline-block">
                Lihat semua →
            </a>
            @endif
        </div>

        <!-- Total Products -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Total Produk</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">{{ number_format($stats['total_products']) }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Transactions -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Total Transaksi</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">{{ number_format($stats['total_transactions']) }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-tumbloo-black mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                    <svg class="h-8 w-8 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Data -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-tumbloo-black">User Terbaru</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-tumbloo-black hover:text-tumbloo-dark font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between p-3 bg-tumbloo-offwhite rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-tumbloo-black">{{ $user->name }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="badge badge-info">{{ ucfirst($user->role) }}</span>
                </div>
                @empty
                <p class="text-tumbloo-gray text-center py-4">Belum ada user terbaru</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Stores -->
        <div class="card p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-tumbloo-black">Toko Terbaru</h2>
                <a href="{{ route('admin.stores.index') }}" class="text-sm text-tumbloo-black hover:text-tumbloo-dark font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentStores as $store)
                <div class="flex items-center justify-between p-3 bg-tumbloo-offwhite rounded-lg">
                    <div class="flex items-center space-x-3">
                        @if($store->logo)
                        <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="h-10 w-10 rounded-lg object-cover">
                        @else
                        <div class="h-10 w-10 rounded-lg bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                            {{ substr($store->name, 0, 1) }}
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-tumbloo-black">{{ $store->name }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $store->user->name }}</p>
                        </div>
                    </div>
                    @if($store->is_verified)
                    <span class="badge badge-success">Verified</span>
                    @else
                    <span class="badge badge-warning">Pending</span>
                    @endif
                </div>
                @empty
                <p class="text-tumbloo-gray text-center py-4">Belum ada toko terbaru</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-tumbloo-black">Transaksi Terbaru</h2>
            <a href="{{ route('admin.transactions') }}" class="text-sm text-tumbloo-black hover:text-tumbloo-dark font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Pembeli</th>
                        <th>Toko</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                    <tr>
                        <td class="font-medium text-tumbloo-black">{{ $transaction->invoice }}</td>
                        <td>{{ $transaction->buyer->name }}</td>
                        <td>{{ $transaction->store->name }}</td>
                        <td class="font-semibold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                        <td>
                            @if($transaction->payment_status == 'delivered')
                            <span class="badge badge-success">Selesai</span>
                            @elseif($transaction->payment_status == 'shipped')
                            <span class="badge badge-info">Dikirim</span>
                            @elseif($transaction->payment_status == 'processing')
                            <span class="badge badge-warning">Diproses</span>
                            @else
                            <span class="badge badge-danger">{{ ucfirst($transaction->payment_status) }}</span>
                            @endif
                        </td>
                        <td class="text-sm text-tumbloo-gray">{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-tumbloo-gray py-8">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection