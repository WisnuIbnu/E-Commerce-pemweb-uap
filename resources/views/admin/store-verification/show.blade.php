@extends('admin.layouts.layout')

@section('title', 'Detail Verifikasi Toko')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.store-verification.index') }}" 
                class="text-sm text-tumbloo-gray hover:text-tumbloo-black inline-flex items-center mb-2">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-bold text-tumbloo-black">Detail Toko</h1>
        </div>
        <span class="badge badge-warning">Menunggu Verifikasi</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Store Information -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Informasi Toko</h2>
                
                <div class="flex items-start space-x-4 mb-6">
                    @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" 
                        class="h-24 w-24 rounded-lg object-cover border-2 border-tumbloo-gray-light">
                    @else
                    <div class="h-24 w-24 rounded-lg bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-bold text-2xl">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-tumbloo-black">{{ $store->name }}</h3>
                        <p class="text-tumbloo-gray mt-1">Didaftarkan {{ $store->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="label">Deskripsi Toko</label>
                        <p class="text-tumbloo-gray">{{ $store->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>

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
                </div>
            </div>

            <!-- Owner Information -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Informasi Pemilik</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                            {{ substr($store->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-tumbloo-black">{{ $store->user->name }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $store->user->email }}</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="label">Role</label>
                            <p class="text-tumbloo-gray">{{ ucfirst($store->user->role) }}</p>
                        </div>
                        <div>
                            <label class="label">Member Sejak</label>
                            <p class="text-tumbloo-gray">{{ $store->user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="space-y-6">
            <!-- Actions Card -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Aksi Verifikasi</h2>
                
                <div class="space-y-3">
                    <form action="{{ route('admin.store-verification.verify', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full btn-primary" 
                            onclick="return confirm('Apakah Anda yakin ingin memverifikasi toko ini?')">
                            <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Verifikasi Toko
                        </button>
                    </form>

                    <button type="button" class="w-full btn-secondary" 
                        onclick="document.getElementById('reject-modal').classList.remove('hidden')">
                        <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Toko
                    </button>
                </div>

                <div class="divider"></div>

                <p class="text-xs text-tumbloo-gray">
                    <strong>Catatan:</strong> Verifikasi toko akan mengaktifkan toko dan penjual dapat mulai menjual produk. Penolakan akan menghapus toko secara permanen.
                </p>
            </div>

            <!-- Stats Card -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Statistik</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-tumbloo-gray">Status</span>
                        <span class="badge badge-warning">Pending</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-tumbloo-gray">Tanggal Daftar</span>
                        <span class="text-sm font-medium text-tumbloo-black">{{ $store->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-tumbloo-gray">Lama Menunggu</span>
                        <span class="text-sm font-medium text-tumbloo-black">{{ $store->created_at->diffForHumans(null, true) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-tumbloo-white rounded-xl shadow-elegant-lg max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-tumbloo-black">Tolak Toko</h3>
            <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" 
                class="text-tumbloo-gray hover:text-tumbloo-black">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.store-verification.reject', $store->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason" class="label">Alasan Penolakan <span class="text-red-500">*</span></label>
                <textarea name="reason" id="reason" rows="4" class="textarea-field" 
                    placeholder="Jelaskan alasan penolakan toko ini..." required></textarea>
                @error('reason')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="alert alert-warning mb-4">
                <svg class="h-5 w-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <p class="text-sm">Peringatan: Menolak toko akan menghapus data toko secara permanen.</p>
            </div>

            <div class="flex space-x-3">
                <button type="button" class="flex-1 btn-secondary btn-sm" 
                    onclick="document.getElementById('reject-modal').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="flex-1 btn-primary btn-sm bg-red-600 hover:bg-red-700" 
                    onclick="return confirm('Apakah Anda yakin ingin menolak dan menghapus toko ini?')">
                    Tolak Toko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection