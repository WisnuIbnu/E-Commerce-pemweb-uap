<x-guest-app-layout>
    <div class="bg-gradient-to-b from-orange-50 to-white min-h-screen">

        <!-- HERO CAROUSEL -->
        <div x-data="carousel()" class="relative w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
            <div class="relative rounded-2xl overflow-hidden shadow-2xl">

                <!-- Slides -->
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="current === index"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        class="relative w-full h-64 sm:h-80 md:h-96 lg:h-[450px]">

                        <!-- Background Image -->
                        <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="">

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0" :style="'background: linear-gradient(135deg, ' + slide.gradient + ')'"></div>

                        <div class="relative h-full flex items-center justify-between px-8 sm:px-12 lg:px-16">
                            <div class="max-w-2xl z-10">
                                <div class="inline-block px-4 py-1.5 bg-orange-500 text-white text-sm font-semibold rounded-full mb-4" x-text="slide.badge"></div>
                                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight" x-text="slide.title"></h2>
                                <p class="text-lg sm:text-xl text-white/90 mb-6" x-text="slide.subtitle"></p>
                                <button class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-8 py-3 rounded-full transition transform hover:scale-105 shadow-lg">
                                    Belanja Sekarang →
                                </button>
                            </div>

                            <!-- Product Image -->
                            <div class="hidden lg:block relative z-10">
                                <div class="absolute -top-6 -left-6 bg-red-500 text-white font-bold px-4 py-2 rounded-lg shadow-xl transform -rotate-12 animate-bounce z-20">
                                    <span class="text-xs">DISKON</span>
                                    <div class="text-2xl">30%</div>
                                </div>

                                <div class="relative transform hover:rotate-6 transition duration-500">
                                    <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl scale-110"></div>
                                    <img :src="slide.productImage"
                                        class="relative h-64 xl:h-80 drop-shadow-2xl transform hover:scale-110 transition duration-500 rounded-3xl"
                                        alt=""
                                        style="filter: drop-shadow(0 25px 50px rgba(0,0,0,0.3));">
                                    <div class="absolute -z-10 top-10 -right-10 w-32 h-32 bg-orange-400/30 rounded-full blur-2xl animate-pulse"></div>
                                    <div class="absolute -z-10 bottom-10 -left-10 w-40 h-40 bg-yellow-400/30 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <!-- Navigation Buttons -->
                <button @click="prev" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition transform hover:scale-110 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="next" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-3 shadow-lg transition transform hover:scale-110 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <!-- Indicators -->
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="goTo(index)"
                            :class="current === index ? 'bg-white w-8' : 'bg-white/50 w-3'"
                            class="h-3 rounded-full transition-all duration-300"></button>
                    </template>
                </div>
            </div>
        </div>

        <script>
            function carousel() {
                return {
                    current: 0,
                    slides: [{
                            badge: '🔥 PROMO HARI INI',
                            title: 'Belanja Hemat Setiap Hari',
                            subtitle: 'Bahan dapur segar & berkualitas dengan harga terbaik untuk keluarga Indonesia',
                            gradient: 'rgba(249, 115, 22, 0.85), rgba(251, 146, 60, 0.75)',
                            image: 'https://images.unsplash.com/photo-1604719312566-8912e9227c6a?w=1200&q=80',
                            productImage: 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&q=80'
                        },
                        {
                            badge: '💰 DISKON 30%',
                            title: 'Promo Minyak Goreng',
                            subtitle: 'Hemat lebih banyak untuk kebutuhan dapur Anda',
                            gradient: 'rgba(234, 88, 12, 0.85), rgba(249, 115, 22, 0.75)',
                            image: 'https://images.unsplash.com/photo-1556910103-1c02745aae4d?w=1200&q=80',
                            productImage: 'https://www.goldenagri.com.sg/wp-content/uploads/2025/06/Cooking-oil-products.jpg'
                        },
                        {
                            badge: '⭐ KUALITAS PREMIUM',
                            title: 'Beras Pilihan Terbaik',
                            subtitle: 'Pulen, wangi, dan bergizi untuk keluarga tercinta',
                            gradient: 'rgba(194, 65, 12, 0.85), rgba(234, 88, 12, 0.75)',
                            image: 'https://images.unsplash.com/photo-1557844352-761f2565b576?w=1200&q=80',
                            productImage: 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&q=80'
                        }
                    ],
                    prev() {
                        this.current = (this.current === 0) ? this.slides.length - 1 : this.current - 1;
                    },
                    next() {
                        this.current = (this.current === this.slides.length - 1) ? 0 : this.current + 1;
                    },
                    goTo(i) {
                        this.current = i;
                    },
                    init() {
                        setInterval(() => {
                            this.next();
                        }, 5000);
                    }
                }
            }
        </script>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- QUICK ACCESS FEATURES -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-orange-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Gratis Ongkir</h3>
                    <p class="text-xs text-gray-600">Min. belanja 50rb</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-green-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Produk Fresh</h3>
                    <p class="text-xs text-gray-600">Kualitas terjamin</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-blue-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Bayar Mudah</h3>
                    <p class="text-xs text-gray-600">Berbagai metode</p>
                </div>
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-purple-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Bonus Poin</h3>
                    <p class="text-xs text-gray-600">Setiap pembelian</p>
                </div>
            </div>

            <!-- CATEGORY SECTION -->
            <div class="mb-14">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl p-6 text-center transition-all duration-300 border-2 border-transparent hover:border-orange-400 transform hover:-translate-y-2">

                        @if($category->image)
                        <div class="relative mb-4">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                class="w-20 h-20 mx-auto rounded-full object-cover ring-4 ring-orange-100 group-hover:ring-orange-300 transition" />
                            <div class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                {{ $category->products->count() }}
                            </div>
                        </div>
                        @else
                        <div class="w-20 h-20 mx-auto bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        @endif

                        <h3 class="font-bold text-gray-800 group-hover:text-orange-600 transition">{{ $category->name }}</h3>
                        <p class="text-xs text-gray-500 mt-1">{{ $category->products->count() }} produk</p>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- FEATURED PRODUCTS -->
            @if($featuredProducts->count() > 0)
            <div class="mb-14">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                        <span class="text-yellow-500">⭐</span> Produk Unggulan Pilihan
                    </h2>
                    <a href="{{ route('home') }}" 
                    class="text-orange-500 hover:text-orange-600 font-semibold text-sm">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach($featuredProducts as $product)
                    <div class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2 relative">

                        <div class="absolute top-3 left-3 z-20">
                            <span class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg animate-pulse">UNGGULAN</span>
                        </div>

                        <a href="{{ route('product.show', $product->slug) }}" class="block relative overflow-hidden bg-gradient-to-br from-orange-50 to-white z-10">
                            @if($product->thumbnail)
                            <div class="relative p-4">
                                <div class="absolute inset-0 opacity-20">
                                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-300 rounded-full blur-3xl"></div>
                                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-300 rounded-full blur-2xl"></div>
                                </div>

                                <img src="{{ asset('storage/' . $product->thumbnail->image) }}"
                                    class="relative w-full h-48 object-contain group-hover:scale-110 group-hover:rotate-3 transition duration-500 drop-shadow-xl">
                            </div>
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center relative overflow-hidden">
                                <svg class="relative w-20 h-20 text-orange-400 group-hover:scale-110 group-hover:rotate-12 transition duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            @endif
                        </a>

                        <div class="p-4">
                            <p class="text-xs text-orange-600 font-semibold mb-1">
                                {{ $product->store->name }}
                            </p>

                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 h-12">
                                <a href="{{ route('product.show', $product->slug) }}" class="hover:text-orange-600 transition">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 line-through">Rp {{ number_format($product->price * 1.2, 0, ',', '.') }}</p>
                                    <p class="text-xl font-bold text-orange-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                @guest
                                    <button 
                                        @click="showLoginModal = true"
                                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow-lg transition transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow-lg transition transform hover:scale-110">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- ALL PRODUCTS -->
            <div>
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                        <span class="text-blue-500">📦</span> Semua Produk Tersedia
                    </h2>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach($products as $product)
                    <div class="group bg-white rounded-2xl shadow-md hover:shadow-2xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2">

                        <a href="{{ route('product.show', $product->slug) }}" class="block relative overflow-hidden bg-gradient-to-br from-gray-50 to-white">
                            @if($product->thumbnail)
                            <div class="relative p-4">
                                <img src="{{ asset('storage/' . $product->thumbnail->image) }}"
                                    class="relative w-full h-48 object-contain group-hover:scale-110 transition duration-500 drop-shadow-lg">
                            </div>
                            @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            @endif
                        </a>

                        <div class="p-4">
                            <p class="text-xs text-gray-500 mb-1">{{ $product->store->name }}</p>

                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 h-12">
                                <a href="{{ route('product.show', $product->slug) }}" class="hover:text-orange-600 transition">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-end justify-between">
                                <p class="text-lg font-bold text-orange-600">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </p>
                                
                                @guest
                                    <button 
                                        @click="showLoginModal = true"
                                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow transition transform hover:scale-110">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                @else
                                    <form action="{{ route('cart.add', $product) }}" method="POST" class="inline">
                                        @csrf
                                        <button 
                                            type="submit"
                                            class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow transition transform hover:scale-110">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                            </svg>
                                        </button>
                                    </form>
                                @endguest
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            </div>

        </div>

        <!-- Modal Login Alert untuk Guest -->
        <div x-data="{ showLoginModal: false }" x-cloak>
            <div x-show="showLoginModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="showLoginModal = false"
                 class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 px-4"
                 style="display: none;">
                
                <div @click.stop 
                     x-show="showLoginModal"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl">
                    
                    <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>

                    <h3 class="text-2xl font-bold text-center text-gray-800 mb-2">
                        Login Diperlukan 🔐
                    </h3>

                    <p class="text-center text-gray-600 mb-6">
                        Anda harus login terlebih dahulu untuk menambahkan produk ke keranjang belanja.
                    </p>

                    <div class="flex gap-3">
                        <button 
                            @click="showLoginModal = false"
                            class="flex-1 px-4 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <a href="{{ route('login') }}" 
                           class="flex-1 px-4 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-lg hover:from-orange-600 hover:to-orange-700 text-center transition shadow-lg hover:shadow-xl transform hover:scale-105">
                            Login Sekarang
                        </a>
                    </div>

                    <p class="text-center text-sm text-gray-600 mt-4">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-orange-600 font-semibold hover:text-orange-700 hover:underline">
                            Daftar Sekarang
                        </a>
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-guest-app-layout>