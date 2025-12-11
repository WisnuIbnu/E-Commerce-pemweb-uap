@extends('admin.layouts.layout')

@section('title', 'Detail Toko')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.stores.index') }}" 
                class="text-sm text-gray-400 hover:text-white inline-flex items-center mb-2 transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Toko
            </a>
            <h1 class="text-3xl font-bold text-white">{{ $store->name }}</h1>
        </div>
        <div class="flex items-center space-x-3">
            @if($store->is_verified)
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-green-500/10 text-green-400 border border-green-500/20">Verified</span>
            <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors" 
                    onclick="return confirm('Apakah Anda yakin ingin menangguhkan toko ini?')">
                    <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tangguhkan
                </button>
            </form>
            @else
            <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Not Verified</span>
            <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors" 
                    onclick="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?')">
                    <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Aktifkan
                </button>
            </form>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total Produk</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $stats['total_products'] }}</p>
                </div>
                <div class="bg-purple-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total Transaksi</p>
                    <p class="text-2xl font-bold text-white mt-1">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="bg-cyan-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-white mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-amber-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-400">Saldo</p>
                    <p class="text-2xl font-bold text-white mt-1">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-emerald-500/10 p-3 rounded-lg">
                    <svg class="h-6 w-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi Toko</h2>
                
                <div class="flex items-start space-x-4 mb-6">
                    @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" 
                        class="h-20 w-20 rounded-lg object-cover border-2 border-zinc-700">
                    @else
                    <div class="h-20 w-20 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-white">{{ $store->name }}</h3>
                        <p class="text-gray-400 mt-1">{{ $store->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <div class="border-t border-zinc-800 my-6"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($store->address)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Alamat</label>
                        <p class="text-white">{{ $store->address }}</p>
                    </div>
                    @endif

                    @if($store->phone)
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Nomor Telepon</label>
                        <p class="text-white">{{ $store->phone }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Terdaftar Sejak</label>
                        <p class="text-white">{{ $store->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Terakhir Diupdate</label>
                        <p class="text-white">{{ $store->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Produk Toko</h2>
                
                @if($store->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($store->products->take(6) as $product)
                    <div class="flex items-center space-x-3 p-3 bg-zinc-800/50 rounded-lg border border-zinc-700/50">
                        @if($product->images->first())
                        <img src="{{ Storage::url($product->images->first()->image) }}" alt="{{ $product->name }}" 
                            class="h-16 w-16 rounded-lg object-cover">
                        @else
                        <div class="h-16 w-16 rounded-lg bg-zinc-700 flex items-center justify-center">
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-white truncate">{{ $product->name }}</p>
                            <p class="text-sm text-gray-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($store->products->count() > 6)
                <p class="text-sm text-gray-400 mt-4 text-center">
                    Dan {{ $store->products->count() - 6 }} produk lainnya
                </p>
                @endif
                @else
                <p class="text-gray-400 text-center py-8">Belum ada produk</p>
                @endif
            </div>

            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Transaksi Terbaru</h2>
                
                @if($store->transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-zinc-800">
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Invoice</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Pembeli</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Total</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Status</th>
                                <th class="text-left py-3 px-4 text-sm font-medium text-gray-400">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($store->transactions->take(5) as $transaction)
                            <tr class="border-b border-zinc-800/50 hover:bg-zinc-800/30 transition-colors">
                                <td class="py-3 px-4 font-medium text-white">{{ $transaction->invoice }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $transaction->buyer->name }}</td>
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-gray-400 text-center py-8">Belum ada transaksi</p>
                @endif
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Pemilik Toko</h2>
                
                <div class="flex items-center space-x-3 mb-4">
                    <div class="h-12 w-12 rounded-full bg-tumbloo-gray flex items-center justify-center text-white font-semibold">
                        {{ substr($store->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-white">{{ $store->user->name }}</p>
                        <p class="text-sm text-gray-400">{{ $store->user->email }}</p>
                    </div>
                </div>

                <div class="border-t border-zinc-800 my-4"></div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Role</span>
                        <span class="font-medium text-white">{{ ucfirst($store->user->role) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Member Sejak</span>
                        <span class="font-medium text-white">{{ $store->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.users.show', $store->user->id) }}" class="w-full mt-4 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                    Lihat Profil User
                </a>
            </div>

            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Aksi</h2>
                
                <div class="space-y-3">
                    @if($store->is_verified)
                    <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                            onclick="return confirm('Apakah Anda yakin ingin menangguhkan toko ini?')">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tangguhkan Toko
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                            onclick="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?')">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aktifkan Toko
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus toko ini? Data tidak dapat dikembalikan!')">
                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus Toko
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection