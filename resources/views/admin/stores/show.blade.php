@extends('admin.layouts.layout')

@section('title', 'Detail Toko')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.stores.index') }}" 
                class="text-sm text-tumbloo-gray hover:text-tumbloo-black inline-flex items-center mb-2">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Toko
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black">{{ $store->name }}</h1>
        </div>
        <div class="flex items-center space-x-3">
            @if($store->is_verified)
            <span class="badge badge-success">Verified</span>
            <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-secondary btn-sm" 
                    onclick="return confirm('Apakah Anda yakin ingin menangguhkan toko ini?')">
                    <svg class="h-4 w-4 mr-1 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Tangguhkan
                </button>
            </form>
            @else
            <span class="badge badge-warning">Not Verified</span>
            <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="btn-primary btn-sm" 
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

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total Produk</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $stats['total_products'] }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total Transaksi</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $stats['total_transactions'] }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Saldo</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">Rp {{ number_format($stats['balance'], 0, ',', '.') }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Store Information -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Informasi Toko</h2>
                
                <div class="flex items-start space-x-4 mb-6">
                    @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" 
                        class="h-20 w-20 rounded-lg object-cover border-2 border-tumbloo-gray-light">
                    @else
                    <div class="h-20 w-20 rounded-lg bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-bold text-2xl">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-tumbloo-black">{{ $store->name }}</h3>
                        <p class="text-tumbloo-gray mt-1">{{ $store->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($store->address)
                    <div>
                        <label class="label">Alamat</label>
                        <p class="text-tumbloo-gray">{{ $store->address }}</p>
                    </div>
                    @endif

                    @if($store->phone)
                    <div>
                        <label class="label">Nomor Telepon</label>
                        <p class="text-tumbloo-gray">{{ $store->phone }}</p>
                    </div>
                    @endif

                    <div>
                        <label class="label">Terdaftar Sejak</label>
                        <p class="text-tumbloo-gray">{{ $store->created_at->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="label">Terakhir Diupdate</label>
                        <p class="text-tumbloo-gray">{{ $store->updated_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Produk Toko</h2>
                
                @if($store->products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($store->products->take(6) as $product)
                    <div class="flex items-center space-x-3 p-3 bg-tumbloo-offwhite rounded-lg">
                        @if($product->images->first())
                        <img src="{{ Storage::url($product->images->first()->image) }}" alt="{{ $product->name }}" 
                            class="h-16 w-16 rounded-lg object-cover">
                        @else
                        <div class="h-16 w-16 rounded-lg bg-tumbloo-gray-light flex items-center justify-center">
                            <svg class="h-8 w-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-tumbloo-black truncate">{{ $product->name }}</p>
                            <p class="text-sm text-tumbloo-gray">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @if($store->products->count() > 6)
                <p class="text-sm text-tumbloo-gray mt-4 text-center">
                    Dan {{ $store->products->count() - 6 }} produk lainnya
                </p>
                @endif
                @else
                <p class="text-tumbloo-gray text-center py-8">Belum ada produk</p>
                @endif
            </div>

            <!-- Recent Transactions -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Transaksi Terbaru</h2>
                
                @if($store->transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Invoice</th>
                                <th>Pembeli</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($store->transactions->take(5) as $transaction)
                            <tr>
                                <td class="font-medium">{{ $transaction->invoice }}</td>
                                <td>{{ $transaction->buyer->name }}</td>
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
                                <td class="text-sm">{{ $transaction->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-tumbloo-gray text-center py-8">Belum ada transaksi</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Owner Info -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Pemilik Toko</h2>
                
                <div class="flex items-center space-x-3 mb-4">
                    <div class="h-12 w-12 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                        {{ substr($store->user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-tumbloo-black">{{ $store->user->name }}</p>
                        <p class="text-sm text-tumbloo-gray">{{ $store->user->email }}</p>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-tumbloo-gray">Role</span>
                        <span class="font-medium text-tumbloo-black">{{ ucfirst($store->user->role) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-tumbloo-gray">Member Sejak</span>
                        <span class="font-medium text-tumbloo-black">{{ $store->user->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <a href="{{ route('admin.users.show', $store->user->id) }}" class="btn-outline btn-sm w-full mt-4">
                    Lihat Profil User
                </a>
            </div>

            <!-- Actions -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Aksi</h2>
                
                <div class="space-y-3">
                    @if($store->is_verified)
                    <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full btn-secondary btn-sm" 
                            onclick="return confirm('Apakah Anda yakin ingin menangguhkan toko ini?')">
                            <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Tangguhkan Toko
                        </button>
                    </form>
                    @else
                    <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full btn-primary btn-sm" 
                            onclick="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?')">
                            <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Aktifkan Toko
                        </button>
                    </form>
                    @endif

                    <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full btn-secondary btn-sm bg-red-600 hover:bg-red-700 text-white" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus toko ini? Data tidak dapat dikembalikan!')">
                            <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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