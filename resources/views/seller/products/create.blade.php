@extends('layouts.seller')

@section('title', 'Tambah Produk Baru')

@section('seller-content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        
        <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- 1. Informasi Dasar --}}
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Informasi Produk</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" value="Nama Produk" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Kemeja Flanel Premium" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="price" value="Harga (Rp)" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price')" required placeholder="50000" />
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="stock" value="Stok Awal" />
                        <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock')" required placeholder="100" />
                        <x-input-error :messages="$errors->get('stock')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="category_id" value="Kategori" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-slate-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="about" value="Deskripsi Produk" />
                        <textarea id="about" name="about" rows="5" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Jelaskan spesifikasi, ukuran, dan keunggulan produk...">{{ old('about') }}</textarea>
                        <x-input-error :messages="$errors->get('about')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- 2. Gambar Produk --}}
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2 mt-4">Media Gambar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Thumbnail Utama --}}
                    <div>
                        <x-input-label for="thumbnail" value="Thumbnail Utama (Wajib)" />
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-slate-300 px-6 py-10 bg-slate-50 hover:bg-slate-100 transition">
                            <div class="text-center">
                                <i class="fa-regular fa-image text-4xl text-slate-300 mb-3"></i>
                                <div class="flex text-sm leading-6 text-slate-600 justify-center">
                                    <label for="thumbnail" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <span>Upload file</span>
                                        <input id="thumbnail" name="thumbnail" type="file" class="sr-only" required accept="image/*">
                                    </label>
                                </div>
                                <p class="text-xs leading-5 text-slate-500">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('thumbnail')" class="mt-2" />
                    </div>

                    {{-- Galeri Tambahan --}}
                    <div>
                        <x-input-label for="photos" value="Galeri Foto (Opsional - Bisa Banyak)" />
                        <div class="mt-2">
                            <input id="photos" name="photos[]" type="file" multiple class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 file:text-indigo-700
                                hover:file:bg-indigo-100
                            "/>
                            <p class="text-xs text-slate-500 mt-2">Tekan CTRL saat memilih file untuk upload banyak sekaligus.</p>
                        </div>
                        <x-input-error :messages="$errors->get('photos')" class="mt-2" />
                    </div>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <a href="{{ route('seller.products.index') }}" class="px-6 py-2.5 rounded-full border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Simpan Produk
                </button>
            </div>

        </form>
    </div>
</div>
@endsection