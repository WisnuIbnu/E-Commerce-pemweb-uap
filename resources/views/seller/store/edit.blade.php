@extends('layouts.front')

@section('title', 'Pengaturan Toko')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    
    {{-- HEADER (Disamakan dengan Dashboard agar konsisten) --}}
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
             <i class="fa-solid fa-store text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Pengaturan Toko</h1>
            <p class="text-indigo-100 text-sm">Kelola informasi toko, logo, dan alamat Anda di sini.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">
            
            {{-- ================= SIDEBAR (Sama persis dengan Dashboard) ================= --}}
            <div class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    {{-- Profil User --}}
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->email }}</p>
                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-emerald-100 text-emerald-600">
                            Penjual
                        </span>
                    </div>
                    
                    {{-- MENU NAVIGASI --}}
                    <nav class="p-4 space-y-1">
                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Penjual</div>
                        
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-gauge-high w-5"></i> Dashboard
                        </a>

                        <a href="{{ route('seller.orders.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.orders.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-clipboard-list w-5"></i> Manajemen Pesanan
                        </a>

                        <a href="{{ route('seller.products.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.products.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-box-open w-5"></i> Kelola Produk
                        </a>

                        <a href="{{ route('seller.store.edit') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.store.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-store w-5"></i> Edit Profil Toko
                        </a>

                        <a href="{{ route('seller.withdraw.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('seller.withdraw.*') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-money-bill-transfer w-5"></i> Penarikan Saldo
                        </a>
                        
                        <div class="border-t border-slate-100 my-2"></div>

                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Akun</div>
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition">
                            <i class="fa-solid fa-user-pen w-5"></i> Edit Akun User
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition mt-4">
                                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            {{-- ================= KONTEN UTAMA (Form Edit) ================= --}}
            <div class="flex-1">
                
                {{-- Notifikasi Sukses --}}
                @if(session('success'))
                <div class="bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check"></i>
                    {{ session('success') }}
                </div>
                @endif

                {{-- Form Edit Profil Toko --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden mb-10">
                    <div class="p-6 border-b border-slate-100 bg-white flex justify-between items-center">
                        <h2 class="text-xl font-bold text-slate-800">Edit Informasi Toko</h2>
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full uppercase tracking-wider">Aktif</span>
                    </div>

                    <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="p-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            {{-- KOLOM KIRI: LOGO --}}
                            <div class="col-span-1">
                                <label class="block text-sm font-bold text-slate-700 mb-2">Logo Toko</label>
                                <div class="border-2 border-dashed border-slate-300 rounded-2xl p-4 text-center hover:bg-slate-50 transition relative group">
                                    {{-- Preview Gambar --}}
                                    @if($store->logo)
                                        <img id="logoPreview" src="{{ asset('storage/' . $store->logo) }}" class="w-full h-48 object-contain rounded-lg mb-2 mx-auto">
                                    @else
                                        <div id="placeholder" class="w-full h-48 bg-slate-100 rounded-lg flex items-center justify-center text-slate-400 mb-2">
                                            <i class="fa-solid fa-image text-4xl"></i>
                                        </div>
                                        <img id="logoPreview" class="hidden w-full h-48 object-contain rounded-lg mb-2 mx-auto">
                                    @endif

                                    {{-- Input File --}}
                                    <input type="file" name="logo" id="logoInput" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="image/*" onchange="previewImage(event)">
                                    <p class="text-xs text-slate-400 mt-2">Klik untuk ubah logo. (Max: 2MB)</p>
                                </div>
                                @error('logo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- KOLOM KANAN: DATA FORM --}}
                            <div class="col-span-2 space-y-5">
                                
                                {{-- Nama Toko --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Toko</label>
                                    <input type="text" name="name" value="{{ old('name', $store->name) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                    @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Deskripsi Singkat</label>
                                    <textarea name="about" rows="3" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">{{ old('about', $store->about) }}</textarea>
                                    @error('about') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- No HP --}}
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Telepon</label>
                                        <input type="number" name="phone" value="{{ old('phone', $store->phone) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        @error('phone') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Kode Pos --}}
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Pos</label>
                                        <input type="text" name="postal_code" value="{{ old('postal_code', $store->postal_code) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        @error('postal_code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    {{-- Kota --}}
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Kota</label>
                                        <input type="text" name="city" value="{{ old('city', $store->city) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        @error('city') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Alamat --}}
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                                        <input type="text" name="address" value="{{ old('address', $store->address) }}" class="w-full rounded-xl border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        @error('address') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="pt-4 flex justify-end">
                                    <button type="submit" class="bg-indigo-600 text-white font-bold py-3 px-8 rounded-full hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                                        <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- AREA BERBAHAYA --}}
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="p-6 bg-red-50 border-b border-red-100 flex items-center gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-red-500 text-xl"></i>
                        <h2 class="text-lg font-bold text-red-800">Area Berbahaya</h2>
                    </div>
                    <div class="p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div>
                            <h3 class="font-bold text-slate-800">Tutup Toko Permanen</h3>
                            <p class="text-slate-500 text-sm mt-1">
                                Tindakan ini akan menghapus semua produk dan data toko Anda. <br>
                                Akun Anda akan kembali menjadi akun Member biasa.
                            </p>
                        </div>
                        <form action="{{ route('seller.store.destroy') }}" method="POST" onsubmit="return confirm('APAKAH ANDA YAKIN? Semua produk dan data toko akan dihapus permanen!');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-white border-2 border-red-500 text-red-600 font-bold py-2 px-6 rounded-full hover:bg-red-50 transition">
                                Hapus Toko Saya
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- Script Preview Logo --}}
<script>
    function previewImage(event) {
        const reader = new FileReader();
        const output = document.getElementById('logoPreview');
        const placeholder = document.getElementById('placeholder');
        
        reader.onload = function(){
            output.src = reader.result;
            output.classList.remove('hidden');
            if(placeholder) placeholder.classList.add('hidden');
        };
        
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection