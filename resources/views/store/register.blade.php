@extends('layouts.app')

@section('title', 'Daftar Sebagai Seller - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-tumbloo-white mb-4">
                Mulai Berjualan di Tumbloo
            </h1>
            <p class="text-tumbloo-gray text-lg">
                Daftarkan toko Anda dan jangkau ribuan pembeli tumbler
            </p>
        </div>

        @if(session('success'))
            <div class="alert-success mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500 bg-opacity-10 border-l-4 border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-8">
            <form action="{{ route('store.register.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <h2 class="text-xl font-semibold text-tumbloo-white mb-4 pb-2 border-b border-tumbloo-accent">
                        Informasi Toko
                    </h2>

                    <div class="mb-6">
                        <label for="name" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Nama Toko <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="name" 
                            name="name" 
                            value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition"
                            placeholder="Contoh: Tumbler Paradise"
                            required>
                        <p class="text-xs text-tumbloo-gray mt-1">
                            Nama toko harus unik dan akan ditampilkan ke pembeli
                        </p>
                    </div>

                    <div class="mb-6">
                        <label for="logo" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Logo Toko
                        </label>
                        <div class="flex items-start gap-4">
                            <div class="flex-1">
                                <input 
                                    type="file" 
                                    id="logo" 
                                    name="logo" 
                                    accept="image/*"
                                    class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-tumbloo-accent file:text-tumbloo-white file:cursor-pointer hover:file:bg-tumbloo-accent-light transition">
                                <p class="text-xs text-tumbloo-gray mt-1">
                                    Format: JPG, PNG, GIF. Maksimal 2MB
                                </p>
                            </div>
                            <div id="logoPreview" class="hidden w-24 h-24 bg-tumbloo-dark border border-tumbloo-accent rounded-lg overflow-hidden">
                                <img id="logoPreviewImg" src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="about" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Deskripsi Toko <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="about" 
                            name="about" 
                            rows="5"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition resize-none"
                            placeholder="Ceritakan tentang toko Anda, produk yang dijual, dan keunggulan Anda..."
                            required>{{ old('about') }}</textarea>
                        <p class="text-xs text-tumbloo-gray mt-1">
                            Minimal 50 karakter. Jelaskan tentang toko dan produk Anda
                        </p>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-tumbloo-white mb-4 pb-2 border-b border-tumbloo-accent">
                        Kontak & Lokasi
                    </h2>

                    <div class="mb-6">
                        <label for="phone" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            id="phone" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition"
                            placeholder="Contoh: 081234567890"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="city" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Kota <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="city" 
                            name="city" 
                            value="{{ old('city') }}"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition"
                            placeholder="Contoh: Jakarta"
                            required>
                    </div>

                    <div class="mb-6">
                        <label for="address" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="address" 
                            name="address" 
                            rows="3"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition resize-none"
                            placeholder="Masukkan alamat lengkap toko Anda..."
                            required>{{ old('address') }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label for="postal_code" class="block text-sm font-semibold text-tumbloo-white mb-2">
                            Kode Pos <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            id="postal_code" 
                            name="postal_code" 
                            value="{{ old('postal_code') }}"
                            class="w-full px-4 py-3 bg-tumbloo-dark border border-tumbloo-accent rounded-lg text-tumbloo-white placeholder-tumbloo-gray focus:outline-none focus:ring-2 focus:ring-tumbloo-accent-light transition"
                            placeholder="Contoh: 12345"
                            required>
                    </div>
                </div>

                <div class="bg-tumbloo-dark border border-tumbloo-accent rounded-lg p-6">
                    <div class="flex items-start gap-3">
                        <input 
                            type="checkbox" 
                            id="terms" 
                            name="terms" 
                            class="mt-1 w-4 h-4 text-tumbloo-accent border-tumbloo-gray rounded focus:ring-tumbloo-accent-light"
                            required>
                        <label for="terms" class="text-sm text-tumbloo-gray">
                            Saya menyetujui <a href="#" class="text-tumbloo-accent hover:text-tumbloo-accent-light underline">syarat dan ketentuan</a> seller Tumbloo dan akan menjual produk asli serta berkualitas
                        </label>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button 
                        type="submit" 
                        class="flex-1 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-semibold py-4 px-6 rounded-lg transition-all duration-300 shadow-lg hover:shadow-xl">
                        Daftar Sekarang
                    </button>
                    <a 
                        href="{{ route('dashboard') }}" 
                        class="px-6 py-4 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-gray hover:text-tumbloo-white border border-tumbloo-accent font-semibold rounded-lg transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>

        <div class="mt-8 bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
            <h3 class="text-lg font-semibold text-tumbloo-white mb-3">
                Keuntungan Menjadi Seller di Tumbloo
            </h3>
            <ul class="space-y-2 text-tumbloo-gray">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Jangkauan pasar luas dengan ribuan pembeli aktif</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Dashboard seller yang mudah digunakan</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Sistem pembayaran aman dan terpercaya</span>
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Support customer service 24/7</span>
                </li>
            </ul>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const preview = document.getElementById('logoPreview');
                const img = document.getElementById('logoPreviewImg');
                img.src = event.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection