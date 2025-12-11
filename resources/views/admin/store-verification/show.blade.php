@extends('admin.layouts.layout')

@section('title', 'Detail Verifikasi Toko')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <a href="{{ route('admin.store-verification.index') }}" 
                class="text-sm text-gray-400 hover:text-white inline-flex items-center mb-2 transition-colors">
                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-bold text-white">Detail Toko</h1>
        </div>
        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Menunggu Verifikasi</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi Toko</h2>
                
                <div class="flex items-start space-x-4 mb-6">
                    @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" 
                        class="h-24 w-24 rounded-lg object-cover border-2 border-zinc-700">
                    @else
                    <div class="h-24 w-24 rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 flex items-center justify-center text-white font-bold text-2xl">
                        {{ substr($store->name, 0, 1) }}
                    </div>
                    @endif
                    
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold text-white">{{ $store->name }}</h3>
                        <p class="text-gray-400 mt-1">Didaftarkan {{ $store->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-400 block mb-1">Deskripsi Toko</label>
                        <p class="text-white">{{ $store->description ?? 'Tidak ada deskripsi' }}</p>
                    </div>

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
                </div>
            </div>

            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Informasi Pemilik</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="h-12 w-12 rounded-full bg-tumbloo-gray flex items-center justify-center text-white font-semibold">
                            {{ substr($store->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-white">{{ $store->user->name }}</p>
                            <p class="text-sm text-gray-400">{{ $store->user->email }}</p>
                        </div>
                    </div>

                    <div class="border-t border-zinc-800 my-4"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-400 block mb-1">Role</label>
                            <p class="text-white">{{ ucfirst($store->user->role) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-400 block mb-1">Member Sejak</label>
                            <p class="text-white">{{ $store->user->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Aksi Verifikasi</h2>
                
                <div class="space-y-3">
                    <form action="{{ route('admin.store-verification.verify', $store->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                            onclick="return confirm('Apakah Anda yakin ingin memverifikasi toko ini?')">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Verifikasi Toko
                        </button>
                    </form>

                    <button type="button" class="w-full px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center" 
                        onclick="document.getElementById('reject-modal').classList.remove('hidden')">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Tolak Toko
                    </button>
                </div>

                <div class="border-t border-zinc-800 my-4"></div>

                <p class="text-xs text-gray-400">
                    <strong>Catatan:</strong> Verifikasi toko akan mengaktifkan toko dan penjual dapat mulai menjual produk. Penolakan akan menghapus toko secara permanen.
                </p>
            </div>

            <div class="bg-zinc-900 rounded-xl p-6 border border-zinc-800">
                <h2 class="text-xl font-bold text-white mb-4">Statistik</h2>
                
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Status</span>
                        <span class="px-3 py-1 text-xs font-medium rounded-full bg-yellow-500/10 text-yellow-400 border border-yellow-500/20">Pending</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Tanggal Daftar</span>
                        <span class="text-sm font-medium text-white">{{ $store->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-400">Lama Menunggu</span>
                        <span class="text-sm font-medium text-white">{{ $store->created_at->diffForHumans(null, true) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="bg-zinc-900 border border-zinc-800 rounded-xl shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-white">Tolak Toko</h3>
            <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" 
                class="text-gray-400 hover:text-white transition-colors">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.store-verification.reject', $store->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="reason" class="text-sm font-medium text-gray-300 block mb-2">
                    Alasan Penolakan <span class="text-red-400">*</span>
                </label>
                <textarea name="reason" id="reason" rows="4" 
                    class="w-full px-4 py-2 bg-zinc-800 border border-zinc-700 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-red-500"
                    placeholder="Jelaskan alasan penolakan toko ini..." required></textarea>
                @error('reason')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-yellow-500/10 border border-yellow-500/20 rounded-lg p-3 mb-4">
                <div class="flex items-start space-x-2">
                    <svg class="h-5 w-5 text-yellow-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <p class="text-sm text-yellow-400">Peringatan: Menolak toko akan menghapus data toko secara permanen.</p>
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="button" class="flex-1 px-4 py-2 bg-zinc-800 hover:bg-zinc-700 text-white rounded-lg font-medium transition-colors" 
                    onclick="document.getElementById('reject-modal').classList.add('hidden')">
                    Batal
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors" 
                    onclick="return confirm('Apakah Anda yakin ingin menolak dan menghapus toko ini?')">
                    Tolak Toko
                </button>
            </div>
        </form>
    </div>
</div>
@endsection