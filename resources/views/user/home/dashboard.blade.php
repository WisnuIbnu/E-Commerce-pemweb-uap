<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage - Mpruy Store</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-gray-800 antialiased font-sans">

    {{-- NAVBAR --}}
    @include('layouts.user.store-navbar')

    {{-- HERO SECTION --}}
    <div class="relative w-full h-[85vh] bg-gray-50 flex items-center overflow-hidden">
        {{-- Background Elements --}}
        <div class="absolute inset-0 z-0 opacity-10">
            <div class="absolute right-0 top-0 w-[50vw] h-[50vw] bg-gray-200 rounded-full blur-3xl transform translate-x-1/4 -translate-y-1/4"></div>
            <div class="absolute left-0 bottom-0 w-[30vw] h-[30vw] bg-gray-300 rounded-full blur-3xl transform -translate-x-1/4 translate-y-1/4"></div>
        </div>

        <div class="container mx-auto px-6 md:px-12 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Left Content --}}
            <div class="space-y-6 text-center lg:text-left">
                <span class="text-sm font-semibold tracking-widest text-gray-500 uppercase">New Collection 2025</span>
                <h1 class="text-5xl md:text-7xl font-bold font-serif leading-tight text-gray-900">
                    Elevate Your <br>
                    <span class="text-gray-500 italic">Signature</span> Style
                </h1>
                <p class="text-lg text-gray-600 max-w-lg mx-auto lg:mx-0">
                    Discover premium fashion pieces crafted for the modern executive. Timeless designs meets contemporary comfort.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start pt-4">
                    <a href="{{ route('products') }}" class="px-8 py-4 bg-black text-white rounded-full font-medium hover:bg-gray-800 transition transform hover:-translate-y-1 shadow-lg">
                        Shop Collection
                    </a>
                    <a href="#new-arrivals" class="px-8 py-4 bg-white text-black border border-gray-200 rounded-full font-medium hover:bg-gray-50 transition">
                        View Lookbook
                    </a>
                </div>
            </div>

            {{-- Right Image --}}
            <div class="relative hidden lg:block h-full">
                <div class="relative w-full h-[600px]">
                     {{-- Image Composition --}}
                    <img src="{{ asset('images/white-man-sit.png') }}" 
                         class="absolute right-10 top-0 w-80 h-[500px] object-cover rounded-2xl shadow-2xl z-20 transform -rotate-2 hover:rotate-0 transition duration-500">
                    <img src="{{ asset('images/black-man-stand.png') }}" 
                         class="absolute right-48 top-20 w-80 h-[500px] object-cover rounded-2xl shadow-xl z-10 grayscale hover:grayscale-0 transition duration-500">
                </div>
            </div>
        </div>
    </div>

    {{-- VALUE PROPOSITIONS --}}
    <section class="border-y border-gray-100 bg-white">
        <div class="container mx-auto px-6 py-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div class="space-y-2 group">
                    <div class="mx-auto w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-xl transition-colors"><img src="{{ asset('icons/delivery-truck-icon-outline-style-vector.jpg') }}" class="w-6 h-6 object-contain"></div>
                    <h3 class="font-bold text-sm">Free Shipping</h3>
                    <p class="text-xs text-gray-500">On all orders over Rp 500k</p>
                </div>
                <div class="space-y-2 group">
                    <div class="mx-auto w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-xl transition-colors"><img src="{{ asset('icons/checkout.png') }}" class="w-6 h-6 object-contain"></div>
                    <h3 class="font-bold text-sm">Secure Payment</h3>
                    <p class="text-xs text-gray-500">100% secure transactions</p>
                </div>
                <div class="space-y-2 group">
                    <div class="mx-auto w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-xl transition-colors"><img src="{{ asset('icons/4601560.png') }}" class="w-6 h-6 object-contain"></div>
                    <h3 class="font-bold text-sm">Easy Returns</h3>
                    <p class="text-xs text-gray-500">30 days return policy</p>
                </div>
                <div class="space-y-2 group">
                    <div class="mx-auto w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center text-xl transition-colors"><img src="{{ asset('icons/cs-img.png') }}" class="w-6 h-6 object-contain"></div>
                    <h3 class="font-bold text-sm">24/7 Support</h3>
                    <p class="text-xs text-gray-500">Dedicated support team</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CATEGORIES SECTION --}}
    <section class="py-20 bg-white">
        <div class="container mx-auto px-6">
            <h2 class="text-3xl font-serif font-bold text-center mb-12">Shop by Category</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Tops Category --}}
                <a href="{{ route('products', ['category' => 'Top']) }}" class="group relative h-[400px] overflow-hidden rounded-2xl cursor-pointer">
                    <div class="absolute inset-0 bg-gray-900/20 group-hover:bg-gray-900/30 w-full h-full z-10 transition-colors"></div>
                    <img src="{{ asset('images/black-man-stand.png') }}" class="w-full h-full object-cover object-top transform group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 flex flex-col items-center justify-center z-20 text-white">
                        <span class="text-sm font-medium tracking-widest uppercase mb-2 opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">Collection</span>
                        <h3 class="text-4xl font-serif font-bold">Tops</h3>
                        <span class="mt-4 px-6 py-2 bg-white text-black text-sm font-bold rounded-full opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300 delay-100">
                            Explore
                        </span>
                    </div>
                </a>

                {{-- Bottoms Category --}}
                <a href="{{ route('products', ['category' => 'Bottom']) }}" class="group relative h-[400px] overflow-hidden rounded-2xl cursor-pointer">
                    <div class="absolute inset-0 bg-gray-900/20 group-hover:bg-gray-900/30 w-full h-full z-10 transition-colors"></div>
                    <img src="{{ asset('images/white-man-sit.png') }}" class="w-full h-full object-cover object-center transform group-hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 flex flex-col items-center justify-center z-20 text-white">
                        <span class="text-sm font-medium tracking-widest uppercase mb-2 opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300">Collection</span>
                        <h3 class="text-4xl font-serif font-bold">Bottoms</h3>
                         <span class="mt-4 px-6 py-2 bg-white text-black text-sm font-bold rounded-full opacity-0 transform translate-y-4 group-hover:opacity-100 group-hover:translate-y-0 transition duration-300 delay-100">
                            Explore
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- NEW ARRIVALS --}}
    <section id="new-arrivals" class="py-20 bg-gray-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-serif font-bold text-gray-900">New Arrivals</h2>
                    <p class="text-gray-500 mt-2">Latest additions to our exclusive collection</p>
                </div>
                <a href="{{ route('products') }}" class="group flex items-center text-sm font-semibold hover:text-black transition">
                    View All Products
                    <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse ($newArrivals as $product)
                    <div class="group bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300">
                        <div class="relative aspect-[3/4] bg-gray-100 overflow-hidden">
                             @if($product->productImages->where('is_thumbnail', true)->first())
                                <img src="{{ asset('storage/' . $product->productImages->where('is_thumbnail', true)->first()->image) }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @elseif($product->productImages->first())
                                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">No Image</div>
                            @endif
                            
                            {{-- Quick Add Overlay --}}
                            <div class="absolute inset-x-0 bottom-0 p-4 translate-y-full group-hover:translate-y-0 transition duration-300">
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="w-full bg-white text-black py-3 font-semibold text-sm shadow-lg rounded hover:bg-black hover:text-white transition-colors">
                                        Quick Add
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="p-5">
                            <div class="text-xs text-gray-500 uppercase tracking-wide mb-1">{{ $product->category->name ?? 'Mpruy' }}</div>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="font-bold text-gray-900 mb-2 truncate group-hover:underline">{{ $product->name }}</h3>
                            </a>
                            <div class="flex justify-between items-center">
                                <span class="font-serif text-lg">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <div class="flex text-yellow-400 text-xs">
                                    <span>★</span><span>★</span><span>★</span><span>★</span><span>☆</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12 bg-white rounded-xl border border-dashed border-gray-300">
                        <p class="text-gray-500">No new arrivals yet. Check back soon!</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- FOOTER SIMPLE --}}
    <footer class="bg-black text-white py-12">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-2xl font-serif font-bold mb-4">MPRUY STORE</h2>
           
            <p class="text-xs text-gray-600">&copy; {{ date('Y') }} Mpruy Store. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>