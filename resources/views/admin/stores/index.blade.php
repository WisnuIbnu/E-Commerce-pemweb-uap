@extends('admin.layouts.layout')

@section('title', 'Kelola Toko')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-tumbloo-black">Kelola Toko</h1>
        <p class="text-tumbloo-gray mt-1">Kelola semua toko yang terdaftar di platform</p>
    </div>

    <!-- Filters -->
    <div class="card p-6">
        <form method="GET" action="{{ route('admin.stores.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                    placeholder="Cari nama toko..." class="input-field">
            </div>
            <div>
                <select name="verified" class="select-field">
                    <option value="">Semua Status</option>
                    <option value="verified" {{ request('verified') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="unverified" {{ request('verified') == 'unverified' ? 'selected' : '' }}>Tidak Terverifikasi</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-sm px-8">
                <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                Cari
            </button>
            @if(request('search') || request('verified'))
            <a href="{{ route('admin.stores.index') }}" class="btn-secondary btn-sm px-8">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-tumbloo-gray">Total Toko</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $stores->total() }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Stores List -->
    @if($stores->count() > 0)
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th>Toko</th>
                        <th>Pemilik</th>
                        <th>Produk</th>
                        <th>Status</th>
                        <th>Terdaftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stores as $store)
                    <tr>
                        <td>
                            <div class="flex items-center space-x-3">
                                @if($store->logo)
                                <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" 
                                    class="h-10 w-10 rounded-lg object-cover">
                                @else
                                <div class="h-10 w-10 rounded-lg bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                                    {{ substr($store->name, 0, 1) }}
                                </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-tumbloo-black">{{ $store->name }}</p>
                                    <p class="text-sm text-tumbloo-gray">{{ Str::limit($store->description, 40) }}</p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <p class="font-medium text-tumbloo-black">{{ $store->user->name }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $store->user->email }}</p>
                        </td>
                        <td class="text-center">
                            <span class="font-semibold text-tumbloo-black">{{ $store->products->count() }}</span>
                        </td>
                        <td>
                            @if($store->is_verified)
                            <span class="badge badge-success">Verified</span>
                            @else
                            <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-sm text-tumbloo-gray">
                            {{ $store->created_at->format('d M Y') }}
                        </td>
                        <td>
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('admin.stores.show', $store->id) }}" 
                                    class="text-tumbloo-black hover:text-tumbloo-dark" title="Lihat Detail">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                
                                @if($store->is_verified)
                                <form action="{{ route('admin.stores.suspend', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-yellow-600 hover:text-yellow-800" 
                                        onclick="return confirm('Apakah Anda yakin ingin menangguhkan toko ini?')" 
                                        title="Tangguhkan">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                                @else
                                <form action="{{ route('admin.stores.activate', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-800" 
                                        onclick="return confirm('Apakah Anda yakin ingin mengaktifkan toko ini?')" 
                                        title="Aktifkan">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>
                                @endif
                                
                                <form action="{{ route('admin.stores.destroy', $store->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" 
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus toko ini? Data tidak dapat dikembalikan!')" 
                                        title="Hapus">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $stores->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="card p-12 text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-tumbloo-offwhite p-6 rounded-full">
                <svg class="h-16 w-16 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-tumbloo-black mb-2">Tidak Ada Toko Ditemukan</h3>
        <p class="text-tumbloo-gray">
            @if(request('search') || request('verified'))
            Coba ubah filter pencarian Anda
            @else
            Belum ada toko yang terdaftar
            @endif
        </p>
    </div>
    @endif
</div>
@endsection