@extends('admin.layouts.layout')

@section('title', 'Verifikasi Toko')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-bold text-tumbloo-black">Verifikasi Toko</h1>
        <p class="text-tumbloo-gray mt-1">Tinjau dan verifikasi pendaftaran toko baru</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="card p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-tumbloo-gray">Total Menunggu</p>
                    <p class="text-2xl font-bold text-tumbloo-black mt-1">{{ $pendingStores->total() }}</p>
                </div>
                <div class="bg-tumbloo-offwhite p-3 rounded-lg">
                    <svg class="h-6 w-6 text-tumbloo-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Stores List -->
    @if($pendingStores->count() > 0)
    <div class="space-y-4">
        @foreach($pendingStores as $store)
        <div class="card p-6 hover:shadow-elegant-lg transition-shadow">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-start space-x-4 flex-1">
                    @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="h-16 w-16 rounded-lg object-cover border-2 border-tumbloo-gray-light">
                    @else
                    <div class="h-16 w-16 rounded-lg bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-bold text-xl">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-tumbloo-black">{{ $store->name }}</h3>
                        <p class="text-sm text-tumbloo-gray mt-1">{{ Str::limit($store->description, 100) }}</p>
                        
                        <div class="flex flex-wrap gap-3 mt-3 text-sm">
                            <div class="flex items-center text-tumbloo-gray">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                {{ $store->user->name }}
                            </div>
                            <div class="flex items-center text-tumbloo-gray">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                {{ $store->user->email }}
                            </div>
                            <div class="flex items-center text-tumbloo-gray">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $store->created_at->diffForHumans() }}
                            </div>
                        </div>

                        @if($store->address)
                        <div class="flex items-start text-sm text-tumbloo-gray mt-2">
                            <svg class="h-4 w-4 mr-1 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ Str::limit($store->address, 80) }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-2 md:flex-col">
                    <a href="{{ route('admin.store-verification.show', $store->id) }}" 
                        class="btn-outline btn-sm text-center whitespace-nowrap">
                        Lihat Detail
                    </a>
                    <form action="{{ route('admin.store-verification.verify', $store->id) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="w-full btn-primary btn-sm whitespace-nowrap" 
                            onclick="return confirm('Apakah Anda yakin ingin memverifikasi toko ini?')">
                            Verifikasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $pendingStores->links() }}
    </div>
    @else
    <!-- Empty State -->
    <div class="card p-12 text-center">
        <div class="flex justify-center mb-4">
            <div class="bg-tumbloo-offwhite p-6 rounded-full">
                <svg class="h-16 w-16 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
        <h3 class="text-xl font-bold text-tumbloo-black mb-2">Tidak Ada Toko yang Menunggu Verifikasi</h3>
        <p class="text-tumbloo-gray">Semua toko telah diverifikasi atau ditolak</p>
    </div>
    @endif
</div>
@endsection