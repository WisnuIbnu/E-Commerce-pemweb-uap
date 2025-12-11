{{-- resources/views/seller/categories/index.blade.php --}}
<x-seller-layout>
    {{-- ALERT ERROR (VALIDATION) --}}
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

    {{-- ALERT SUKSES --}}
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
        <div class="max-w-5xl mx-auto space-y-6">
            {{-- BREADCRUMB --}}
            <div class="text-sm text-gray-500">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-orange-500">Dashboard Toko</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700 font-medium">Kategori Produk</span>
            </div>

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Kategori Produk</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola kategori untuk mengelompokkan produk di toko Anda.
                    </p>
                </div>

                <div class="flex items-center gap-2 text-xs text-gray-500 bg-white border border-gray-100 rounded-full px-3 py-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    {{ $store->name ?? 'Toko' }}
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                {{-- FORM TAMBAH KATEGORI --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold text-gray-800">Tambah Kategori Baru</h2>
                        <span class="text-[11px] px-2 py-0.5 rounded-full bg-orange-50 text-orange-500 border border-orange-100">
                            Wajib diisi
                        </span>
                    </div>

                    <form action="{{ route('seller.categories.store') }}" method="POST" class="space-y-4">
                        @csrf

                        {{-- Nama Kategori --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Nama Kategori <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm @error('name') border-red-500 ring-red-200 @enderror"
                                placeholder="Misal: Minyak & Bumbu"
                            >
                            @error('name')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Deskripsi (opsional) --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Deskripsi (opsional)
                            </label>
                            <textarea
                                name="description"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm @error('description') border-red-500 ring-red-200 @enderror"
                                placeholder="Contoh: Kumpulan produk minyak goreng, margarin, dan bumbu dapur.">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-2 flex justify-end">
                            <button type="submit"
                                class="px-4 py-2 text-sm rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600">
                                Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>

                {{-- LIST KATEGORI --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                    <div class="flex items-center justify-between mb-1">
                        <h2 class="text-sm font-semibold text-gray-800">Daftar Kategori</h2>
                        <span class="text-[11px] text-gray-400">
                            {{ $categories->total() }} kategori
                        </span>
                    </div>

                    @if ($categories->count() === 0)
                        <p class="text-sm text-gray-500">
                            Belum ada kategori. Tambahkan kategori baru di sebelah kiri.
                        </p>
                    @else
                        <div class="overflow-hidden rounded-xl border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-100 text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500">Nama</th>
                                        <th class="px-4 py-2 text-left text-xs font-semibold text-gray-500 hidden md:table-cell">Deskripsi</th>
                                        <th class="px-4 py-2 text-right text-xs font-semibold text-gray-500">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach ($categories as $category)
                                        <tr>
                                            <td class="px-4 py-2 align-top">
                                                <p class="font-medium text-gray-800">{{ $category->name }}</p>
                                                <p class="text-[11px] text-gray-400 md:hidden mt-0.5">
                                                    {{ \Illuminate\Support\Str::limit($category->description, 40) }}
                                                </p>
                                            </td>
                                            <td class="px-4 py-2 text-gray-500 text-xs align-top hidden md:table-cell">
                                                {{ $category->description ?: '-' }}
                                            </td>
                                            <td class="px-4 py-2 align-top">
                                                <div class="flex justify-end gap-2">
                                                    <a href="{{ route('seller.categories.edit', $category) }}"
                                                        class="px-2.5 py-1 text-xs rounded-lg border border-blue-100 text-blue-600 hover:bg-blue-50">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('seller.categories.destroy', $category) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Yakin ingin menghapus kategori ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2.5 py-1 text-xs rounded-lg border border-red-100 text-red-600 hover:bg-red-50">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- PAGINATION --}}
                        <div class="mt-3">
                            {{ $categories->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-seller-layout>
