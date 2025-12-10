@extends('layouts.front')

@section('title', 'Buka Toko Baru')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    {{-- Header Hero --}}
    <div class="bg-primary pt-16 pb-32 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
             <i class="fa-solid fa-store text-[15rem] absolute -bottom-10 -right-20 text-white transform rotate-12"></i>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center lg:text-left">
            <h1 class="text-3xl md:text-4xl font-extrabold text-white mb-2 tracking-tight">
                Mulai Bisnis Digital Anda
            </h1>
            <p class="text-indigo-100 text-base md:text-lg max-w-2xl">
                Lengkapi profil toko di bawah ini untuk mulai berjualan.
            </p>
        </div>
    </div>

    {{-- Form Container --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 relative z-20">
        <form method="POST" action="{{ route('stores.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- KOLOM KIRI: FORM INPUT (Span 8) --}}
                <div class="lg:col-span-8 space-y-6">
                    
                    {{-- Card 1: Informasi Toko --}}
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-store text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900">Informasi Toko</h2>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nama Toko</label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Toko Berkah Jaya"
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all">
                                <x-input-error :messages="$errors->get('name')" class="mt-1" />
                            </div>

                            <div>
                                <label for="about" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Deskripsi Singkat</label>
                                <textarea id="about" name="about" rows="4" required placeholder="Jelaskan keunggulan produk Anda..."
                                    class="w-full rounded-2xl border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm p-4 placeholder-slate-400 transition-all">{{ old('about') }}</textarea>
                                <x-input-error :messages="$errors->get('about')" class="mt-1" />
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Alamat & Kontak --}}
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-full bg-indigo-50 flex items-center justify-center text-primary">
                                <i class="fa-solid fa-location-dot text-lg"></i>
                            </div>
                            <h2 class="text-xl font-bold text-slate-900">Alamat & Kontak</h2>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Nomor WhatsApp / Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required placeholder="0812xxxxxxx"
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all">
                                <x-input-error :messages="$errors->get('phone')" class="mt-1" />
                            </div>

                            <div>
                                <label for="city" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Kota</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" required placeholder="Nama Kota"
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all">
                                <x-input-error :messages="$errors->get('city')" class="mt-1" />
                            </div>

                            <div>
                                <label for="postal_code" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Kode Pos</label>
                                <input type="number" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required placeholder="xxxxx"
                                    class="w-full rounded-full border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm h-12 px-4 placeholder-slate-400 transition-all">
                                <x-input-error :messages="$errors->get('postal_code')" class="mt-1" />
                            </div>

                            <div class="md:col-span-2">
                                <label for="address" class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-2">Alamat Lengkap</label>
                                <textarea id="address" name="address" rows="3" required placeholder="Nama Jalan, Gedung, No. Rumah, RT/RW..."
                                    class="w-full rounded-2xl border-2 border-slate-300 focus:border-primary focus:ring-primary text-sm bg-white shadow-sm p-4 placeholder-slate-400 transition-all">{{ old('address') }}</textarea>
                                <x-input-error :messages="$errors->get('address')" class="mt-1" />
                            </div>
                            
                            <input type="hidden" name="address_id" value="1"> 
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: LOGO & AKSI (Span 4 - Sticky seperti Checkout) --}}
                <div class="lg:col-span-4">
                    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 sticky top-10">
                        <h2 class="text-lg font-bold text-slate-900 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-image text-slate-400"></i> Logo & Konfirmasi
                        </h2>
                        
                        {{-- Logo Upload Area --}}
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wide mb-3">Logo Toko</label>
                            <div class="relative group w-full aspect-square">
                                <div class="w-full h-full bg-slate-50 rounded-2xl flex items-center justify-center border-2 border-dashed border-slate-300 overflow-hidden hover:border-primary transition-colors cursor-pointer group-hover:bg-indigo-50/30">
                                    <img id="logoPreview" src="#" alt="Preview" class="w-full h-full object-cover hidden z-10 relative">
                                    <div id="placeholderLogo" class="text-slate-400 flex flex-col items-center justify-center text-center p-4">
                                        <div class="w-16 h-16 rounded-full bg-white flex items-center justify-center shadow-sm mb-3">
                                            <i class="fa-solid fa-camera text-2xl text-slate-300 group-hover:text-primary transition-colors"></i>
                                        </div>
                                        <span class="text-xs font-medium text-slate-500">Klik untuk upload logo</span>
                                        <span class="text-[10px] text-slate-400 mt-1">JPG/PNG Max 2MB</span>
                                    </div>
                                    <input id="logo" type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-20" onchange="previewImage(event)" required accept="image/*" />
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('logo')" class="mt-2" />
                        </div>

                        {{-- Divider --}}
                        <div class="pt-5 border-t border-slate-100 mb-6">
                            <div class="flex items-start gap-3">
                                <i class="fa-solid fa-circle-info text-primary mt-0.5"></i>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Dengan menekan tombol di bawah, Anda menyetujui <a href="#" class="text-primary font-bold hover:underline">Syarat & Ketentuan</a> pembukaan toko di platform kami.
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Utama --}}
                        <button type="submit" class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-full transition-all shadow-lg shadow-primary/30 hover:shadow-primary/50 flex items-center justify-center gap-2 text-sm mb-3">
                            <span>Buka Toko Sekarang</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        {{-- Tombol Batal --}}
                        <a href="{{ route('dashboard') }}" class="block w-full py-3 text-slate-500 font-bold text-sm text-center hover:text-slate-800 transition-colors">
                            Batal
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('logoPreview');
            const placeholder = document.getElementById('placeholderLogo');
            output.src = reader.result;
            output.classList.remove('hidden');
            placeholder.classList.add('hidden');
        };
        if(event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection