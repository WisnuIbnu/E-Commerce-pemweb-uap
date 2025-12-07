<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pendaftaran Toko Sembako
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Lengkapi data berikut untuk mulai berjualan di Sembako Mart.
                </p>
            </div>

            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                Seller Baru
            </span>
        </div>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-xl rounded-2xl border border-orange-100 px-8 py-8">
                <form method="POST"
                      action="{{ route('seller.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    {{-- Nama Pemilik --}}
                    <div>
                        <label for="owner_name" class="block text-sm font-medium text-gray-700">
                            Nama Pemilik
                        </label>
                        <input
                            id="owner_name"
                            type="text"
                            name="owner_name"
                            value="{{ old('owner_name', auth()->user()->name ?? '') }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Masukkan nama pemilik toko">
                        @error('owner_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nama Toko --}}
                    <div>
                        <label for="store_name" class="block text-sm font-medium text-gray-700">
                            Nama Toko
                        </label>
                        <input
                            id="store_name"
                            type="text"
                            name="store_name"
                            value="{{ old('store_name') }}"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Contoh: Sembako Makmur Jaya">
                        @error('store_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto Profil Toko --}}
                    <div class="grid gap-4 sm:grid-cols-[auto,1fr] items-center">
                        <div class="flex flex-col items-center space-y-2">
                            <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center overflow-hidden">
                                {{-- Preview bisa ditambah pakai JS nanti --}}
                                <svg class="w-10 h-10 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </div>
                            <span class="text-xs text-gray-500 text-center">
                                Foto logo / tampak depan toko
                            </span>
                        </div>

                        <div>
                            <label for="profile_photo" class="block text-sm font-medium text-gray-700">
                                Foto Profil Toko
                            </label>
                            <input
                                id="profile_photo"
                                type="file"
                                name="profile_photo"
                                accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-700
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-lg file:border-0
                                       file:text-sm file:font-semibold
                                       file:bg-orange-50 file:text-orange-700
                                       hover:file:bg-orange-100">
                            <p class="mt-1 text-xs text-gray-500">
                                Format: JPG, PNG. Maksimal 2MB.
                            </p>
                            @error('profile_photo')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Alamat Toko --}}
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700">
                            Alamat Toko
                        </label>
                        <textarea
                            id="address"
                            name="address"
                            rows="3"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-orange-500 focus:border-orange-500"
                            placeholder="Tuliskan alamat lengkap toko, termasuk RT/RW, kelurahan, kecamatan, dan kota">{{ old('address') }}</textarea>
                        @error('address')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori Toko --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">
                            Kategori Toko
                        </label>
                        <select
                            id="category"
                            name="category"
                            required
                            class="mt-1 block w-full rounded-lg border-gray-300 bg-white shadow-sm focus:ring-orange-500 focus:border-orange-500">
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Pilih kategori toko</option>
                            <option value="sembako_umum" {{ old('category') == 'sembako_umum' ? 'selected' : '' }}>
                                Sembako Umum
                            </option>
                            <option value="sayur_buah" {{ old('category') == 'sayur_buah' ? 'selected' : '' }}>
                                Sayur &amp; Buah
                            </option>
                            <option value="daging_telur" {{ old('category') == 'daging_telur' ? 'selected' : '' }}>
                                Daging &amp; Telur
                            </option>
                            <option value="minimarket" {{ old('category') == 'minimarket' ? 'selected' : '' }}>
                                Minimarket / Kelontong
                            </option>
                            <option value="lainnya" {{ old('category') == 'lainnya' ? 'selected' : '' }}>
                                Lainnya
                            </option>
                        </select>
                        @error('category')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-orange-50">
                        <a href="{{ route('dashboard') }}"
                           class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
                            Nanti Saja
                        </a>

                        <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 text-sm font-semibold rounded-lg shadow-sm
                                   bg-gradient-to-r from-orange-500 to-orange-600 text-white
                                   hover:from-orange-600 hover:to-orange-700 focus:outline-none focus:ring-2
                                   focus:ring-offset-2 focus:ring-orange-500">
                            Simpan &amp; Aktifkan Toko
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
