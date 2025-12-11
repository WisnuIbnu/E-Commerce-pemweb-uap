@extends('admin.layouts.layout')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-white">Dashboard Admin</h1>
            <p class="text-gray-400 mt-1">Selamat datang kembali, {{ Auth::user()->name }}</p>
        </div>
        <div class="text-right">
            <p class="text-sm text-gray-400">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total User</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_users']) }}</p>
                </div>
                <div class="bg-blue-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Toko Aktif</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_stores']) }}</p>
                </div>
                <div class="bg-green-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Toko Menunggu</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['pending_stores']) }}</p>
                </div>
                <div class="bg-yellow-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            @if($stats['pending_stores'] > 0)
            <a href="{{ route('admin.store-verification.index') }}" class="text-sm text-blue-400 hover:text-blue-300 font-medium mt-3 inline-block">
                Lihat semua →
            </a>
            @endif
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Produk</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_products']) }}</p>
                </div>
                <div class="bg-purple-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Transaksi</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['total_transactions']) }}</p>
                </div>
                <div class="bg-cyan-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-400">Total Pendapatan</p>
                    <p class="text-3xl font-bold text-white mt-2">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-amber-500/10 p-4 rounded-xl">
                    <svg class="h-8 w-8 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-white">User Terbaru</h2>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-blue-400 hover:text-blue-300 font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentUsers as $user)
                <div class="flex items-center justify-between p-3 bg-zinc-800/50 rounded-lg border border-zinc-700/50">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full bg-tumbloo-gray flex items-center justify-center text-white font-semibold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-medium text-white">{{ $user->name }}</p>
                            <p class="text-sm text-gray-400">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">{{ ucfirst($user->role) }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">Belum ada user terbaru</p>
                @endforelse
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-white">Toko Terbaru</h2>
                <a href="{{ route('admin.stores.index') }}" class="text-sm text-blue-400 hover:text-blue-300 font-medium">
                    Lihat Semua →
                </a>
            </div>
            <div class="space-y-3">
                @forelse($recentStores as $store)
                <div class="flex items-center justify-between p-3 bg-zinc-800/50 rounded-lg border border-zinc-700/50">
                    <div class="flex items-center space-x-3">
                        @if($store->logo)
                        <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="h-10 w-10 rounded-lg object-cover">
                        @else
                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-semibold">
                            {{ substr($store->name, 0, 1) }}
                        </div>
                        @endif
                        <div>
                            <p class="font-medium text-white">{{ $store->name }}</p>
                            <p class="text-sm text-gray-400">{{ $store->user->name }}</p>
                        </div>
                    </div>
                    @if($store->is_verified)
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Verified</span>
                    @else
                    <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pending</span>
                    @endif
                </div>
                @empty
                <p class="text-gray-400 text-center py-4">Belum ada toko terbaru</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-white">Transaksi Terbaru</h2>
            <a href="{{ route('admin.transactions.index') }}" class="text-sm text-blue-400 hover:text-blue-300 font-medium">
                Lihat Semua →
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-zinc-800">
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Invoice</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Pembeli</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Toko</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Total</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Status</th>
                        <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTransactions as $transaction)
                    <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                        <td class="py-3 px-4 font-medium text-white">{{ $transaction->invoice }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $transaction->buyer->name }}</td>
                        <td class="py-3 px-4 text-gray-300">{{ $transaction->store->name }}</td>
                        <td class="py-3 px-4 font-semibold text-white">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            @if($transaction->payment_status == 'delivered')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Selesai</span>
                            @elseif($transaction->payment_status == 'shipped')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20">Dikirim</span>
                            @elseif($transaction->payment_status == 'processing')
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Diproses</span>
                            @else
                            <span class="px-3 py-1 text-xs font-medium rounded-full bg-red-500/10 text-red-400 border border-red-500/20">{{ ucfirst($transaction->payment_status) }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-sm text-gray-400">{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-400 py-8">Belum ada transaksi</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection