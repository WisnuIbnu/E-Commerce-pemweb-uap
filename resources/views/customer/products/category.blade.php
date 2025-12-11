<x-app-layout>
    {{-- HERO UTAMA --}}
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 px-6 py-8 shadow-xl">
            <div class="relative z-10 flex flex-col gap-3">
                <div class="inline-flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-2xl">
                        🗂️
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-blue-100">
                            Browse by Category
                        </p>
                        <h2 class="font-semibold text-2xl md:text-3xl text-white">
                            Products by Category
                        </h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-blue-100 max-w-2xl">
                    Produk disusun per kategori: Laptop, Mesin Cuci, dan lainnya.
                </p>
            </div>

            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-300/30 blur-3xl"></div>
            <div class="pointer-events-none absolute left-10 -bottom-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
        </div>
    </x-slot>

    <div class="bg-gray-900 min-h-screen text-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

            @forelse($categories as $category)
                {{-- BLOK SATU KATEGORI (LEBAR, HORIZONTAL) --}}
                <section class="rounded-2xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 border border-gray-800 shadow-2xl p-4 md:p-5 space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <h3 class="text-sm md:text-base font-semibold text-gray-100 uppercase tracking-wide">
                            {{ $category->name }}
                        </h3>

                        <a href="{{ route('customer.products.category', $category->slug) }}"
                           class="text-xs text-blue-300 hover:text-blue-200 underline underline-offset-4">
                            Lihat selengkapnya &gt;
                        </a>
                    </div>

                    {{-- deretan produk 1 baris scroll-x --}}
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        @forelse($category->products as $product)
                            <div class="min-w-[220px] max-w-xs bg-gray-900/80 border border-gray-800 rounded-2xl p-3 flex flex-col shadow hover:border-blue-500 hover:-translate-y-1 transition">
                                <div class="w-full h-32 flex items-center justify-center overflow-hidden rounded-xl mb-2 bg-gray-800">
                                    <img
                                        src="{{ $product->image ? asset('storage/'.$product->image) : asset('images/default.png') }}"
                                        alt="{{ $product->name }}"
                                        class="w-full h-full object-contain">
                                </div>
                                <p class="text-xs text-gray-400 line-clamp-2">
                                    {{ $product->name }}
                                </p>
                                <p class="text-sm font-semibold text-blue-300 mt-1">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>

                                <a href="{{ route('product.show', $product->slug) }}"
                                   class="mt-3 inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-3 py-1.5 rounded-lg text-xs font-medium">
                                    View Details
                                </a>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400">
                                Belum ada produk di kategori ini.
                            </p>
                        @endforelse
                    </div>
                </section>
            @empty
                <p class="text-gray-400">
                    Belum ada kategori dengan produk.
                </p>
            @endforelse

        </div>
    </div>
</x-app-layout>
