{{-- resources/views/seller/products/create.blade.php --}}
<x-seller-layout>
    <div class="py-6">
        <div class="max-w-3xl mx-auto">

            {{-- Breadcrumb sederhana --}}
            <div class="mb-4 text-sm text-gray-500">
                <a href="{{ route('seller.products.index') }}" class="hover:text-orange-500">Produk Saya</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700 font-medium">Tambah Produk</span>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h1 class="text-xl font-bold text-gray-800 mb-4">Tambah Produk Baru</h1>
                <p class="text-sm text-gray-500 mb-6">
                    Lengkapi informasi produk yang akan dijual di Sembako Mart.
                </p>

                <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    {{-- Nama Produk --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                            placeholder="Contoh: Beras Ramos 5kg">
                        @error('name')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <select name="category_id"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm">
                            <option value="">Pilih kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga & Stok --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Harga (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                min="0" step="100">
                            @error('price')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Stok <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" value="{{ old('stock') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                min="0" step="1">
                            @error('stock')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Berat Produk --}}
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Berat Produk (kg) <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="number"
                            name="weight"
                            min="0"
                            step="0.001"
                            value="{{ old('weight') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                            placeholder="Contoh: 1 untuk 1 kg"
                            required>
                        @error('weight')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>



                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Produk
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                            placeholder="Tuliskan deskripsi singkat, misalnya kualitas beras, merek, berat bersih, dll.">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gambar Utama --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Foto Produk (opsional)
                        </label>
                        <input type="file" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0 file:text-sm file:font-semibold
                                      file:bg-orange-50 file:text-orange-600 hover:file:bg-orange-100">
                        <p class="text-xs text-gray-500 mt-1">
                            Format: JPG, PNG. Maksimal 2MB.
                        </p>
                        @error('image')
                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end space-x-3 pt-2">
                        <a href="{{ route('seller.products.index') }}"
                            class="px-4 py-2 text-sm rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600">
                            Simpan Produk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-seller-layout>