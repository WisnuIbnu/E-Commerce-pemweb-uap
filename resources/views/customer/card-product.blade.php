<div class="py-12 bg-gradient-to-b from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-bold text-gray-900">Produk Terbaru</h2>
            <p class="mt-2 text-sm text-gray-600">Temukan produk terbaik untuk Anda</p>
        </div>

        <!-- Products Grid - Responsive: 2 cols mobile, 3 cols tablet, 4 cols desktop -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">
            @forelse($products as $product)
                <!-- ✨ TAMBAHKAN <a> TAG DI SINI -->
                <a href="{{ route('product.show', $product->id) }}" class="product-card-wrapper cursor-pointer group block">
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <!-- Product Image -->
                        <div class="relative overflow-hidden aspect-square bg-gray-100">
                            @php
                                // Ambil gambar thumbnail (is_thumbnail = true)
                                $productImage = $product->productImages->where('is_thumbnail', true)->first() 
                                             ?? $product->productImages->first();
                                $imagePath = $productImage ? $productImage->image : null;
                                
                                // Cek apakah file exists
                                $imageExists = $imagePath && file_exists(public_path($imagePath));
                            @endphp
                            
                            @if($imageExists)
                                <img src="{{ asset($imagePath) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                {{-- Gunakan placeholder jika file belum ada --}}
                                <img src="https://placehold.co/400x400/E4D6C5/984216?text={{ urlencode(Str::limit($product->name, 15)) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @endif
                            
                            <!-- Stock Badge -->
                            @if($product->stock > 0)
                                <div class="absolute top-3 left-3 bg-sage-green text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    Stok: {{ $product->stock }}
                                </div>
                            @else
                                <div class="absolute top-3 left-3 bg-burnt-sienna text-white text-xs font-semibold px-3 py-1 rounded-full shadow-lg">
                                    Habis
                                </div>
                            @endif

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center pb-4">
                                <span class="text-white font-semibold text-sm">Lihat Detail</span>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="p-4">
                            <!-- Category Badge -->
                            <div class="mb-2">
                                <span class="inline-block bg-ivory-sand text-burnt-sienna text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $product->productCategory->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            <!-- Product Name -->
                            <h3 class="text-sm md:text-base font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[2.5rem] md:min-h-[3rem] group-hover:text-burnt-sienna transition-colors">
                                {{ $product->name }}
                            </h3>

                            <!-- Price -->
                            <div class="flex items-baseline gap-2">
                                <span class="text-lg md:text-xl font-bold text-burnt-sienna">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Rating (optional - jika ada) -->
                            <div class="mt-2 flex items-center gap-1">
                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                                <span class="text-xs text-gray-600">4.8</span>
                                <span class="text-xs text-gray-400 ml-1">({{ rand(10, 100) }})</span>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- ✨ PENUTUP <a> TAG -->
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="flex flex-col items-center">
                        <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Belum ada produk</h3>
                        <p class="text-sm text-gray-500">Produk akan segera ditambahkan.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
/* Custom Color Palette */
.bg-burnt-sienna { background-color: #984216; }
.text-burnt-sienna { color: #984216; }
.bg-ivory-sand { background-color: #E4D6C5; }
.text-ivory-sand { color: #E4D6C5; }
.bg-stormy-sky { background-color: #78898F; }
.text-stormy-sky { color: #78898F; }
.bg-sage-green { background-color: #8D957E; }
.text-sage-green { color: #8D957E; }

/* Product Card Animations */
.product-card-wrapper {
    animation: fadeInUp 0.5s ease-out backwards;
    text-decoration: none; /* ✨ TAMBAHKAN INI - Hilangkan underline */
}

.product-card-wrapper:nth-child(1) { animation-delay: 0.05s; }
.product-card-wrapper:nth-child(2) { animation-delay: 0.1s; }
.product-card-wrapper:nth-child(3) { animation-delay: 0.15s; }
.product-card-wrapper:nth-child(4) { animation-delay: 0.2s; }
.product-card-wrapper:nth-child(5) { animation-delay: 0.25s; }
.product-card-wrapper:nth-child(6) { animation-delay: 0.3s; }
.product-card-wrapper:nth-child(7) { animation-delay: 0.35s; }
.product-card-wrapper:nth-child(8) { animation-delay: 0.4s; }

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Line Clamp Utility */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Responsive adjustments */
@media (max-width: 640px) {
    .product-card-wrapper {
        font-size: 0.9rem;
    }
}
</style>