@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-tumbloo-offwhite py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-tumbloo-black mb-3">Daftar Toko</h1>
            <p class="text-tumbloo-gray">Mulai jual produk Anda hari ini</p>
        </div>

        <!-- Registration Form -->
        <div class="card p-8">
            <form action="{{ route('store.register.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Store Name -->
                <div class="mb-6">
                    <label class="label">Nama Toko <span class="text-red-500">*</span></label>
                    <input type="text" name="name" 
                        class="input-field @error('name') border-red-500 @enderror" 
                        placeholder="Nama unik untuk toko Anda"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Logo -->
                <div class="mb-6">
                    <label class="label">Logo Toko <span class="text-red-500">*</span></label>
                    <input type="file" name="logo" 
                        class="input-field @error('logo') border-red-500 @enderror" 
                        accept="image/jpeg,image/png,image/jpg" required>
                    <p class="text-xs text-tumbloo-gray mt-1">Format: JPG, PNG (Max: 2MB)</p>
                    @error('logo')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- About -->
                <div class="mb-6">
                    <label class="label">Tentang Toko <span class="text-red-500">*</span></label>
                    <textarea name="about" rows="4"
                        class="textarea-field @error('about') border-red-500 @enderror" 
                        placeholder="Deskripsikan toko Anda..." required>{{ old('about') }}</textarea>
                    @error('about')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-6">
                    <label class="label">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" 
                        class="input-field @error('phone') border-red-500 @enderror" 
                        placeholder="08123456789"
                        value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="mb-6">
                    <label class="label">Alamat Lengkap <span class="text-red-500">*</span></label>
                    <textarea name="address" rows="3"
                        class="textarea-field @error('address') border-red-500 @enderror" 
                        placeholder="Alamat lengkap toko" required>{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City and Postal Code -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="label">Kota <span class="text-red-500">*</span></label>
                        <input type="text" name="city" 
                            class="input-field @error('city') border-red-500 @enderror" 
                            placeholder="Kota"
                            value="{{ old('city') }}" required>
                        @error('city')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="label">Kode Pos <span class="text-red-500">*</span></label>
                        <input type="text" name="postal_code" 
                            class="input-field @error('postal_code') border-red-500 @enderror" 
                            placeholder="12345"
                            value="{{ old('postal_code') }}" required>
                        @error('postal_code')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Terms -->
                <div class="mb-6">
                    <label class="flex items-start">
                        <input type="checkbox" class="mt-1 mr-2" required>
                        <span class="text-sm text-tumbloo-gray">
                            Saya setuju dengan <a href="#" class="link">Syarat & Ketentuan</a> serta <a href="#" class="link">Kebijakan Privasi</a> Tumbloo
                        </span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-primary w-full">
                    Daftar Toko Sekarang
                </button>
            </form>
        </div>

        <!-- Info Box -->
        <div class="mt-8 card p-6">
            <h3 class="font-bold text-tumbloo-black mb-3">📋 Proses Verifikasi</h3>
            <ol class="text-sm text-tumbloo-gray space-y-2 list-decimal list-inside">
                <li>Kirim formulir pendaftaran toko</li>
                <li>Admin akan meninjau aplikasi Anda dalam 1-3 hari kerja</li>
                <li>Anda akan menerima notifikasi email setelah verifikasi</li>
                <li>Mulai jual produk setelah toko disetujui</li>
            </ol>
        </div>
    </div>
</div>
@endsection