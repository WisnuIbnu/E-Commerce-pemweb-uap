{{-- resources/views/seller/categories/edit.blade.php --}}
<x-seller-layout>
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Menyimpan',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#f97316',
                });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#f97316',
                });
            });
        </script>
    @endif

    <div class="py-8">
        <div class="max-w-4xl mx-auto space-y-6">
            {{-- BREADCRUMB --}}
            <div class="text-sm text-gray-500">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-orange-500">Dashboard Toko</a>
                <span class="mx-1">/</span>
                <a href="{{ route('seller.categories.index') }}" class="hover:text-orange-500">Kategori Produk</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700 font-medium">Edit Kategori</span>
            </div>

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Kategori</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Perbarui informasi kategori produk di toko Anda.
                    </p>
                </div>
            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                <form action="{{ route('seller.categories.update', $category) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    {{-- Nama Kategori --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Nama Kategori <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $category->name) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm @error('name') border-red-500 ring-red-200 @enderror"
                            placeholder="Misal: Minyak & Bumbu"
                        >
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Deskripsi (opsional)
                        </label>
                        <textarea
                            name="description"
                            rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm @error('description') border-red-500 ring-red-200 @enderror"
                            placeholder="Contoh: Kumpulan produk minyak goreng, margarin, dan bumbu dapur.">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-2 flex justify-between">
                        <a href="{{ route('seller.categories.index') }}"
                           class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                            Kembali
                        </a>

                        <div class="flex gap-2">
                            <button type="submit"
                                class="px-4 py-2 text-sm rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-seller-layout>
