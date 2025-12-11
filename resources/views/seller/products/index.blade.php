<x-app-layout>
    <x-slot name="header">
        <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-6 shadow-xl">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">📦</span>
                    <h2 class="font-semibold text-2xl">
                        Your Products Overview
                    </h2>
                </div>
                <p class="text-sm text-blue-100">
                    Kelola, pantau stok, dan perbarui semua produk toko kamu dengan mudah.
                </p>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-900 min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Card besar seperti Orders --}}
            <div class="rounded-3xl bg-gray-900 border border-gray-800 shadow-2xl overflow-hidden">

                {{-- Header card bagian atas --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-800">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-100">
                            My Products
                        </h3>
                        <p class="text-xs text-gray-400 mt-1">
                            Daftar semua produk yang kamu jual di ElecTrend.
                        </p>
                    </div>

                    <a href="{{ route('seller.products.create') }}"
                       class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-lg text-sm font-medium shadow">
                        Add Product
                    </a>
                </div>

                {{-- Isi: tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-200">
                        <thead class="bg-gray-900 border-b border-gray-800 text-xs uppercase tracking-wide text-gray-400">
                            <tr>
                                <th class="p-3">Image</th>
                                <th class="p-3">Name</th>
                                <th class="p-3">Price</th>
                                <th class="p-3">Stock</th>
                                <th class="p-3">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($products as $p)
                                <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                    <td class="p-3">
                                        @if($p->productImages->first())
                                            <img src="{{ asset('storage/'.$p->productImages->first()->image) }}"
                                                 class="w-16 h-16 object-cover rounded-lg border border-gray-700">
                                        @else
                                            <div class="w-16 h-16 rounded-lg bg-gray-700 flex items-center justify-center text-xs text-gray-400">
                                                No Image
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-3 text-gray-100">{{ $p->name }}</td>

                                    <td class="p-3 text-gray-200">
                                        Rp {{ number_format($p->price) }}
                                    </td>

                                    <td class="p-3 text-gray-200">{{ $p->stock }}</td>

                                    <td class="p-3">
                                        <div class="inline-flex items-center gap-2 bg-gray-900 border border-gray-700 rounded-full px-3 py-1">
                                            <a href="{{ route('seller.products.edit', $p->id) }}"
                                               class="inline-flex items-center justify-center rounded-full bg-blue-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-blue-400 transition-colors">
                                                Edit
                                            </a>

                                            <form action="{{ route('seller.products.destroy', $p->id) }}"
                                                  method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="inline-flex items-center justify-center rounded-full bg-red-500 px-3 py-1 text-xs font-medium text-white shadow hover:bg-red-400 transition-colors">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-6 text-center text-gray-400 text-sm">
                                        No products found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
