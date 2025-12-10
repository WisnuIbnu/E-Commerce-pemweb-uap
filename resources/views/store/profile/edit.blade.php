@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-tumbloo-offwhite py-8">
        <div class="max-w-4xl mx-auto px-4">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-tumbloo-black mb-2">Profil Toko</h1>
                <p class="text-tumbloo-gray">Kelola informasi toko Anda</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success fade-in mb-6">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-error fade-in mb-6">{{ session('error') }}</div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-6">
                    <div class="card p-6">
                        <div class="text-center">
                            @if($store->logo)
                                <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}"
                                    class="w-32 h-32 object-cover rounded-full mx-auto mb-4">
                            @else
                                <div
                                    class="w-32 h-32 bg-tumbloo-gray-light rounded-full mx-auto mb-4 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-tumbloo-gray" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                            <h3 class="font-bold text-tumbloo-black mb-2">{{ $store->name }}</h3>
                            <p class="text-sm text-tumbloo-gray mb-4">{{ $store->city }}</p>
                            <span class="badge {{ $store->is_verified ? 'badge-success' : 'badge-warning' }}">
                                {{ $store->is_verified ? 'Verified' : 'Pending' }}
                            </span>
                        </div>
                    </div>

                    <div class="card p-6">
                        <h3 class="font-bold text-tumbloo-black mb-4">Statistik</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-tumbloo-gray">Total Produk:</span>
                                <span class="font-semibold">{{ $store->products->count() }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-tumbloo-gray">Bergabung:</span>
                                <span class="font-semibold">{{ $store->created_at->format('M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="card p-6 border-2 border-red-500">
                        <h3 class="font-bold text-red-600 mb-4">⚠️ Danger Zone</h3>
                        <p class="text-sm text-tumbloo-gray mb-4">
                            Hapus toko secara permanen. Aksi ini tidak dapat dibatalkan.
                        </p>
                        <form action="{{ route('store.profile.destroy') }}" method="POST"
                            onsubmit="return confirm('PERINGATAN: Yakin ingin menghapus toko? Semua data produk akan terhapus!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-primary w-full bg-red-600 hover:bg-red-700">
                                Hapus Toko
                            </button>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="card p-8">
                        <h2 class="text-xl font-bold text-tumbloo-black mb-6">Update Informasi Toko</h2>

                        <form action="{{ route('store.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-6">
                                <label class="label">Nama Toko <span class="text-red-500">*</span></label>
                                <input type="text" name="name" class="input-field @error('name') border-red-500 @enderror"
                                    value="{{ old('name', $store->name) }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="label">Logo Toko Baru (Opsional)</label>
                                <input type="file" name="logo" class="input-field @error('logo') border-red-500 @enderror"
                                    accept="image/jpeg,image/png,image/jpg">
                                <p class="text-xs text-tumbloo-gray mt-1">Format: JPG, PNG (Max: 2MB). Kosongkan jika tidak
                                    ingin mengganti.</p>
                                @error('logo')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="label">Tentang Toko <span class="text-red-500">*</span></label>
                                <textarea name="about" rows="4"
                                    class="textarea-field @error('about') border-red-500 @enderror"
                                    required>{{ old('about', $store->about) }}</textarea>
                                <p class="text-xs text-tumbloo-gray mt-1">Minimal 50 karakter</p>
                                    @error('about')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="label">Nomor Telepon <span class="text-red-500">*</span></label>
                                <input type="tel" name="phone" class="input-field @error('phone') border-red-500 @enderror"
                                    value="{{ old('phone', $store->phone) }}" required>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-6">
                                <label class="label">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name="address" rows="3"
                                    class="textarea-field @error('address') border-red-500 @enderror"
                                    required>{{ old('address', $store->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                <div>
                                    <label class="label">Kota <span class="text-red-500">*</span></label>
                                    <input type="text" name="city"
                                        class="input-field @error('city') border-red-500 @enderror"
                                        value="{{ old('city', $store->city) }}" required>
                                    @error('city')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="label">Kode Pos <span class="text-red-500">*</span></label>
                                    <input type="text" name="postal_code"
                                        class="input-field @error('postal_code') border-red-500 @enderror"
                                        value="{{ old('postal_code', $store->postal_code) }}" required>
                                    @error('postal_code')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <button type="submit" class="btn-primary w-full">
                                Update Profil Toko
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection