{{-- resources/views/seller/products/index.blade.php --}}
<x-seller-layout>
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

    <div class="py-6">
        {{-- ➜ container diperlebar & dikasih padding samping --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Produk Saya</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola produk yang dijual di toko <span class="font-semibold">{{ $store->name }}</span>.
                    </p>
                </div>

                <a href="{{ route('seller.products.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Produk
                </a>
            </div>

            {{-- Jika belum ada produk --}}
            @if ($products->isEmpty())
                <div class="bg-white rounded-xl shadow-sm border border-dashed border-gray-200 p-8 text-center">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Belum ada produk</h2>
                    <p class="text-sm text-gray-500 mb-4">
                        Tambahkan produk pertama Anda untuk mulai berjualan di Sembako Mart.
                    </p>
                    <a href="{{ route('seller.products.create') }}"
                       class="inline-flex items-center px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600 transition">
                        + Tambah Produk
                    </a>
                </div>
            @else
                {{-- LIST PRODUK (RESPONSIVE) --}}
                {{-- ➜ wrapper tabel dibuat full width --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 w-full">

                    {{-- MOBILE: kartu-kartu, bukan tabel --}}
                    <div class="md:hidden divide-y divide-gray-100">
                        @foreach ($products as $product)
                            @php
                                $isAvailable = $product->stock > 0;
                            @endphp
                            <div class="p-4 flex gap-3">
                                {{-- Gambar --}}
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="w-14 h-14 rounded-lg object-cover bg-gray-100 flex-shrink-0"
                                         alt="{{ $product->name }}">
                                @else
                                    <div class="w-14 h-14 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] text-gray-400 flex-shrink-0">
                                        No Image
                                    </div>
                                @endif

                                <div class="flex-1">
                                    <div class="flex items-start justify-between gap-2">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $product->name }}
                                            </div>
                                            <div class="text-xs text-gray-400">
                                                ID: {{ $product->id }} • {{ $product->category->name ?? '-' }}
                                            </div>
                                        </div>

                                        <span class="inline-flex px-2 py-0.5 rounded-full text-[11px] font-medium
                                            {{ $isAvailable ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $isAvailable ? 'Tersedia' : 'Tidak tersedia' }}
                                        </span>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between text-xs text-gray-600">
                                        <div>
                                            <span class="font-semibold text-gray-900">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </span>
                                            <span class="ml-2">• Stok: {{ $product->stock }}</span>
                                        </div>
                                    </div>

                                    <div class="mt-3 flex gap-2">
                                        <a href="{{ route('seller.products.edit', $product) }}"
                                           class="flex-1 px-3 py-1.5 text-xs text-center rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>

                                        <form action="{{ route('seller.products.destroy', $product) }}"
                                              method="POST" class="delete-form flex-1">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                    class="delete-btn w-full px-3 py-1.5 text-xs rounded-lg border border-red-100 text-red-600 bg-red-50 hover:bg-red-100">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- DESKTOP/TABLET: tabel seperti biasa --}}
                    <div class="hidden md:block">
                        {{-- ➜ tabel juga dibuat full width --}}
                        <table class="min-w-full w-full divide-y divide-gray-100 text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Produk
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Harga
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Stok
                                    </th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-100">
                                @foreach ($products as $product)
                                    @php
                                        $isAvailable = $product->stock > 0;
                                    @endphp
                                    <tr>
                                        {{-- PRODUK --}}
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                @if ($product->image)
                                                    <img src="{{ asset('storage/' . $product->image) }}"
                                                         class="w-12 h-12 rounded-lg object-cover bg-gray-100"
                                                         alt="{{ $product->name }}">
                                                @else
                                                    <div class="w-12 h-12 rounded-lg bg-gray-100 flex items-center justify-center text-[10px] text-gray-400">
                                                        No Image
                                                    </div>
                                                @endif

                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $product->name }}
                                                    </div>
                                                    <div class="text-xs text-gray-400">
                                                        ID: {{ $product->id }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        {{-- KATEGORI, HARGA, STOK --}}
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $product->category->name ?? '-' }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-900">
                                            {{ $product->stock }}
                                        </td>

                                        {{-- STATUS --}}
                                        <td class="px-6 py-4 text-center">
                                            <span class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium
                                                {{ $isAvailable ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                                {{ $isAvailable ? 'Tersedia' : 'Tidak tersedia' }}
                                            </span>
                                        </td>

                                        {{-- AKSI --}}
                                        <td class="px-6 py-4 text-right">
                                            <div class="inline-flex gap-2">
                                                <a href="{{ route('seller.products.edit', $product) }}"
                                                   class="px-3 py-1 text-xs rounded-lg border border-gray-200 text-gray-700 hover:bg-gray-50">
                                                    Edit
                                                </a>

                                                <form action="{{ route('seller.products.destroy', $product) }}"
                                                      method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                            class="delete-btn px-3 py-1 text-xs rounded-lg border border-red-100 text-red-600 bg-red-50 hover:bg-red-100">
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
                </div>

                {{-- Pagination (dipakai untuk dua layout sekaligus) --}}
                <div class="px-4 py-3 border-t border-gray-100">
                    {{ $products->links() }}
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');

            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Hapus produk?',
                        text: "Produk yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>

</x-seller-layout>
