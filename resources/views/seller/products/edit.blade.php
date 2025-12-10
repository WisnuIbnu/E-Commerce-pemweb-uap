@extends('layouts.seller')

@section('title', 'Edit Produk')

@section('seller-content')
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
        
        <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- 1. Informasi Dasar --}}
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Edit Informasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <x-input-label for="name" value="Nama Produk" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $product->name)" required />
                    </div>

                    <div>
                        <x-input-label for="price" value="Harga (Rp)" />
                        <x-text-input id="price" class="block mt-1 w-full" type="number" name="price" :value="old('price', $product->price)" required />
                    </div>

                    <div>
                        <x-input-label for="stock" value="Stok" />
                        <x-text-input id="stock" class="block mt-1 w-full" type="number" name="stock" :value="old('stock', $product->stock)" required />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="category_id" value="Kategori" />
                        <select name="category_id" id="category_id" class="block mt-1 w-full border-slate-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="about" value="Deskripsi Produk" />
                        <textarea id="about" name="about" rows="5" class="block mt-1 w-full border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('about', $product->about) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- 2. Gambar --}}
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2 mt-4">Media Gambar</h3>
                
                {{-- Preview Thumbnail Lama --}}
                <div class="mb-4">
                    <p class="text-sm text-slate-500 mb-2">Thumbnail Saat Ini:</p>
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="Thumbnail" class="w-32 h-32 object-cover rounded-lg border border-slate-200">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="thumbnail" value="Ganti Thumbnail (Opsional)" />
                        <input id="thumbnail" name="thumbnail" type="file" class="block w-full mt-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200"/>
                    </div>

                    <div>
                        <x-input-label for="photos" value="Tambah Foto Galeri Baru" />
                        <input id="photos" name="photos[]" type="file" multiple class="block w-full mt-2 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"/>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-4 border-t">
                <a href="{{ route('seller.products.index') }}" class="px-6 py-2.5 rounded-full border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 transition">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-full bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                    Update Produk
                </button>
            </div>

        </form>
    </div>
</div>
@endsection