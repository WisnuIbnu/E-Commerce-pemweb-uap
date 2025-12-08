@extends('layouts.app')

@section('title', $product->name . ' - Tumbloo')

@section('content')
<div class="bg-tumbloo-dark min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center gap-2 text-sm text-tumbloo-gray">
                <li><a href="{{ route('dashboard') }}" class="hover:text-tumbloo-accent">Home</a></li>
                <li>/</li>
                <li><a href="{{ route('dashboard', ['category' => $product->product_category_id]) }}" class="hover:text-tumbloo-accent">{{ $product->category->name }}</a></li>
                <li>/</li>
                <li class="text-tumbloo-white">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-500 bg-opacity-10 border-l-4 border-green-500 text-green-400 px-6 py-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-500 bg-opacity-10 border-l-4 border-red-500 text-red-400 px-6 py-4 rounded-lg mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            
            <!-- Product Images -->
            <div>
                <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg overflow-hidden mb-4">
                    <div id="mainImage" class="aspect-square">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset($product->images->where('is_thumbnail', true)->first()->image ?? $product->images->first()->image) }}" 
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-tumbloo-dark">
                                <svg class="w-32 h-32 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Image Thumbnails -->
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->images as $image)
                            <button onclick="changeImage('{{ asset($image->image) }}')" 
                                class="aspect-square rounded-lg overflow-hidden border-2 border-tumbloo-accent hover:border-tumbloo-accent-light transition">
                                <img src="{{ asset($image->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                    
                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-tumbloo-white mb-4">{{ $product->name }}</h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-4 mb-6">
                        @if($product->reviews_count > 0)
                            <div class="flex items-center gap-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= round($product->reviews_avg_rating) ? 'text-yellow-400' : 'text-tumbloo-gray' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-tumbloo-white font-semibold">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                                <span class="text-tumbloo-gray">({{ $product->reviews_count }} ulasan)</span>
                            </div>
                        @else
                            <span class="text-tumbloo-gray">Belum ada ulasan</span>
                        @endif
                    </div>

                    <!-- Price -->
                    <div class="mb-6">
                        <div class="text-4xl font-bold text-blue-600 mb-2">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                            {{ $product->condition == 'new' ? 'bg-green-500 bg-opacity-20 text-green-400' : 'bg-yellow-500 bg-opacity-20 text-yellow-400' }}">
                            {{ $product->condition == 'new' ? 'Barang Baru' : 'Bekas' }}
                        </span>
                    </div>

                    <!-- Stock -->
                    <div class="mb-6 pb-6 border-b border-tumbloo-accent">
                        <div class="flex items-center gap-2 text-tumbloo-gray">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span>Stok: <span class="{{ $product->stock < 5 ? 'text-red-400' : 'text-tumbloo-white' }} font-semibold">{{ $product->stock }}</span></span>
                        </div>
                        @if($product->weight)
                            <div class="flex items-center gap-2 text-tumbloo-gray mt-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                                </svg>
                                <span>Berat: {{ $product->weight }} gram</span>
                            </div>
                        @endif
                    </div>

                    <!-- Quantity Selector -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" id="buyForm">
                        @csrf
                        <div class="mb-6">
                            <label class="block text-tumbloo-white font-medium mb-3">Jumlah</label>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center border border-tumbloo-accent rounded-lg overflow-hidden">
                                    <button type="button" onclick="decrementQty()" 
                                        class="px-4 py-3 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                        </svg>
                                    </button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" 
                                        class="w-20 text-center py-3 bg-tumbloo-black text-tumbloo-white border-x border-tumbloo-accent focus:outline-none">
                                    <button type="button" onclick="incrementQty()" 
                                        class="px-4 py-3 bg-tumbloo-dark hover:bg-tumbloo-darker text-tumbloo-white transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                                <span class="text-tumbloo-gray">Tersedia: {{ $product->stock }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            @auth
                                @php
                                    $isOwnProduct = false;
                                    if(auth()->user()->store) {
                                        $isOwnProduct = $product->store_id === auth()->user()->store->id;
                                    }
                                @endphp

                                @if(auth()->user()->role === 'admin')
                                    {{-- Admin tidak bisa membeli --}}
                                    <button type="button" disabled
                                        class="flex-1 px-6 py-4 bg-tumbloo-darker text-tumbloo-gray font-bold rounded-lg cursor-not-allowed">
                                        Admin tidak bisa membeli
                                    </button>
                                @elseif($isOwnProduct)
                                    {{-- Seller tidak bisa membeli produk sendiri --}}
                                    <button type="button" disabled
                                        class="flex-1 px-6 py-4 bg-tumbloo-darker text-tumbloo-gray font-bold rounded-lg cursor-not-allowed">
                                        Tidak bisa membeli produk sendiri
                                    </button>
                                @else
                                    {{-- Customer atau seller lain bisa membeli --}}
                                    @if($product->stock > 0)
                                        <button type="submit" 
                                            class="flex-1 px-6 py-4 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Tambah ke Keranjang
                                        </button>
                                        <button type="button" onclick="buyNow()" 
                                            class="flex-1 px-6 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg transition flex items-center justify-center gap-2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            Beli Sekarang
                                        </button>
                                    @else
                                        <button type="button" disabled
                                            class="flex-1 px-6 py-4 bg-tumbloo-darker text-tumbloo-gray font-bold rounded-lg cursor-not-allowed">
                                            Stok Habis
                                        </button>
                                    @endif
                                @endif
                            @else
                                <a href="{{ route('login') }}" 
                                    class="flex-1 px-6 py-4 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white font-bold rounded-lg transition text-center">
                                    Login untuk Membeli
                                </a>
                            @endauth
                        </div>
                    </form>

                    <!-- Store Info -->
                    <div class="mt-6 pt-6 border-t border-tumbloo-accent">
                        <a href="#" class="flex items-center gap-4 p-4 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                            <div class="w-12 h-12 rounded-full overflow-hidden bg-tumbloo-black border-2 border-tumbloo-accent flex-shrink-0">
                                @if($product->store->logo)
                                    <img src="{{ asset($product->store->logo) }}" alt="{{ $product->store->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-tumbloo-white font-semibold group-hover:text-tumbloo-accent transition">
                                    {{ $product->store->name }}
                                </div>
                                <div class="text-sm text-tumbloo-gray flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $product->store->city }}
                                </div>
                            </div>
                            @if($product->store->is_verified)
                                <svg class="w-6 h-6 text-green-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Description & Reviews -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            
            <!-- Description -->
            <div class="lg:col-span-2">
                <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                    <h2 class="text-2xl font-bold text-tumbloo-white mb-4">Deskripsi Produk</h2>
                    <div class="text-tumbloo-gray leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Reviews -->
                <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6 mt-6">
                    <h2 class="text-2xl font-bold text-tumbloo-white mb-4">Ulasan Pembeli</h2>
                    
                    @if($product->reviews->isEmpty())
                        <p class="text-center text-tumbloo-gray py-8">Belum ada ulasan untuk produk ini</p>
                    @else
                        <div class="space-y-4">
                            @foreach($product->reviews as $review)
                                <div class="border-b border-tumbloo-accent last:border-0 pb-4 last:pb-0">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-full bg-tumbloo-accent text-white flex items-center justify-center font-bold flex-shrink-0">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="text-tumbloo-white font-semibold">{{ $review->user->name }}</span>
                                                <div class="flex">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-tumbloo-gray' }}" fill="currentColor" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                        </svg>
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="text-tumbloo-gray text-sm mb-2">{{ $review->comment }}</p>
                                            <span class="text-xs text-tumbloo-gray">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar - Category & Related -->
            <div class="space-y-6">
                <!-- Category -->
                <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                    <h3 class="text-lg font-bold text-tumbloo-white mb-3">Kategori</h3>
                    <a href="{{ route('dashboard', ['category' => $product->product_category_id]) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-tumbloo-dark hover:bg-tumbloo-accent text-tumbloo-white rounded-lg transition">
                        {{ $product->category->name }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <!-- Related Products -->
                @if($relatedProducts->isNotEmpty())
                    <div class="bg-tumbloo-black border border-tumbloo-accent rounded-lg p-6">
                        <h3 class="text-lg font-bold text-tumbloo-white mb-4">Produk Terkait</h3>
                        <div class="space-y-3">
                            @foreach($relatedProducts as $related)
                                <a href="{{ route('product.show', $related->id) }}" class="flex gap-3 p-3 bg-tumbloo-dark hover:bg-tumbloo-darker rounded-lg transition group">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden bg-tumbloo-black flex-shrink-0">
                                        @if($related->images->isNotEmpty())
                                            <img src="{{ asset($related->images->first()->image) }}" alt="{{ $related->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-tumbloo-gray" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-tumbloo-white text-sm font-medium line-clamp-2 group-hover:text-tumbloo-accent transition">
                                            {{ $related->name }}
                                        </h4>
                                        <p class="text-blue-600 font-bold text-sm mt-1">
                                            Rp {{ number_format($related->price, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Change main image
function changeImage(imageUrl) {
    document.querySelector('#mainImage img').src = imageUrl;
}

// Quantity controls
function incrementQty() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.max);
    const current = parseInt(input.value);
    if (current < max) {
        input.value = current + 1;
    }
}

function decrementQty() {
    const input = document.getElementById('quantity');
    const min = parseInt(input.min);
    const current = parseInt(input.value);
    if (current > min) {
        input.value = current - 1;
    }
}

// Buy now - langsung ke checkout
function buyNow() {
    const form = document.getElementById('buyForm');
    const quantity = document.getElementById('quantity').value;
    
    // Create temporary form to checkout
    const checkoutForm = document.createElement('form');
    checkoutForm.method = 'POST';
    checkoutForm.action = '{{ route("checkout.index") }}';
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    checkoutForm.appendChild(csrfInput);
    
    // Add product data
    const productInput = document.createElement('input');
    productInput.type = 'hidden';
    productInput.name = 'product_id';
    productInput.value = '{{ $product->id }}';
    checkoutForm.appendChild(productInput);
    
    const qtyInput = document.createElement('input');
    qtyInput.type = 'hidden';
    qtyInput.name = 'quantity';
    qtyInput.value = quantity;
    checkoutForm.appendChild(qtyInput);
    
    const buyNowInput = document.createElement('input');
    buyNowInput.type = 'hidden';
    buyNowInput.name = 'buy_now';
    buyNowInput.value = '1';
    checkoutForm.appendChild(buyNowInput);
    
    document.body.appendChild(checkoutForm);
    checkoutForm.submit();
}
</script>
@endsection