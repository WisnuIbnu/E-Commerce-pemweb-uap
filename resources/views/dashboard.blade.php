<x-app-layout>
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
                        class="relative w-full h-72 sm:h-80 md:h-96 lg:h-[450px]">

                        <!-- Background Image -->
                        <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="">

                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0"
                            :style="'background: linear-gradient(135deg, ' + slide.gradient + ')'"></div>

                        <!-- Slide Content -->
                        <div
                            class="relative h-full
                            flex flex-col lg:flex-row
                            items-center
                            justify-center
                            px-4 sm:px-8 lg:px-16
                            gap-4 sm:gap-6 lg:gap-10
                            text-center"
                            :class="slide.productImage
                            ? 'lg:justify-between lg:text-left'
                            : 'lg:justify-center'">


                            <div class="max-w-xl lg:max-w-2xl z-10">
                                <div
                                    class="inline-block px-4 py-1.5 bg-orange-500 text-white text-xs sm:text-sm font-semibold rounded-full mb-3 sm:mb-4"
                                    x-text="slide.badge">
                                </div>

                                <h2
                                    class="text-2xl sm:text-3xl lg:text-5xl font-bold text-white mb-3 sm:mb-4 leading-tight"
                                    x-text="slide.title">
                                </h2>

                                <p
                                    class="text-sm sm:text-base lg:text-lg text-white/90 mb-4 sm:mb-6"
                                    x-text="slide.subtitle">
                                </p>

                                @if(auth()->guest())
                                <a href="{{ route('login') }}"
                                    class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold
                                              px-6 sm:px-8 py-2.5 sm:py-3 rounded-full
                                              text-sm sm:text-base
                                              transition transform hover:scale-105 shadow-lg">
                                    Belanja Sekarang →
                                </a>
                                @else
                                <a href="{{ route('dashboard') }}"
                                    class="inline-block bg-orange-500 hover:bg-orange-600 text-white font-semibold
                                              px-6 sm:px-8 py-2.5 sm:py-3 rounded-full
                                              text-sm sm:text-base
                                              transition transform hover:scale-105 shadow-lg">
                                    Belanja Sekarang →
                                </a>
                                @endif
                            </div>

                            <!-- Product Image with Dynamic Elements (desktop only) -->
                            <template x-if="slide.productImage">
                                <div class="hidden lg:block relative z-10">
                                    <!-- Floating Badges -->
                                    <div
                                        class="absolute -top-6 -left-6 bg-red-500 text-white font-bold px-4 py-2 rounded-lg shadow-xl transform -rotate-12 animate-bounce z-20">
                                        <span class="text-xs">DISKON</span>
                                        <div class="text-2xl">30%</div>
                                    </div>

                                    <!-- Main Product Image with Rotation -->
                                    <div class="relative transform hover:rotate-6 transition duration-500">
                                        <!-- Background Decoration Circle -->
                                        <div class="absolute inset-0 bg-white/20 rounded-full blur-3xl scale-110"></div>

                                        <!-- Product Image -->
                                        <img :src="slide.productImage"
                                            class="relative h-64 xl:h-80 drop-shadow-2xl transform hover:scale-110 transition duration-500 rounded-3xl"
                                            alt=""
                                            style="filter: drop-shadow(0 25px 50px rgba(0,0,0,0.3));">

                                        <!-- Decorative Elements -->
                                        <div
                                            class="absolute -z-10 top-10 -right-10 w-32 h-32 bg-orange-400/30 rounded-full blur-2xl animate-pulse"></div>
                                        <div
                                            class="absolute -z-10 bottom-10 -left-10 w-40 h-40 bg-yellow-400/30 rounded-full blur-2xl animate-pulse"
                                            style="animation-delay: 1s;"></div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <!-- Navigation Buttons -->
                <!-- <button @click="prev"
                    class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-2 sm:p-3 shadow-lg transition transform hover:scale-110 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>

                <button @click="next"
                    class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white text-gray-800 rounded-full p-2 sm:p-3 shadow-lg transition transform hover:scale-110 z-10">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button> -->

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
                            // productImage: 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=400&q=80'
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

        {{-- ====== BAGIAN BAWAH (FEATURES, KATEGORI, PRODUK) ====== --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

            <!-- QUICK ACCESS FEATURES -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-orange-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-orange-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Gratis Ongkir</h3>
                    <p class="text-xs text-gray-600">Min. belanja 50rb</p>
                </div>
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-green-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Produk Fresh</h3>
                    <p class="text-xs text-gray-600">Kualitas terjamin</p>
                </div>
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-blue-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Bayar Mudah</h3>
                    <p class="text-xs text-gray-600">Berbagai metode</p>
                </div>
                <div
                    class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition text-center border-t-4 border-purple-500">
                    <div class="w-14 h-14 mx-auto mb-3 bg-purple-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-800 mb-1">Bonus Poin</h3>
                    <p class="text-xs text-gray-600">Setiap pembelian</p>
                </div>
            </div>

            <!-- CATEGORY SECTION -->
            <div class="mb-14">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                        <span class="text-orange-500"></span> Belanja Berdasarkan Kategori
                    </h2>
                    <a href="#" class="text-orange-500 hover:text-orange-600 font-semibold text-sm">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                    @foreach($categories as $category)
                    <a href="{{ route('category.show', $category->slug) }}"
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl p-6 text-center transition-all duration-300 border-2 border-transparent hover:border-orange-400 transform hover:-translate-y-2">

                        @if($category->image)
                        <div class="relative mb-4">
                            <img src="{{ asset('storage/' . $category->image) }}"
                                class="w-20 h-20 mx-auto rounded-full object-cover ring-4 ring-orange-100 group-hover:ring-orange-300 transition" />
                            <div
                                class="absolute -top-1 -right-1 bg-orange-500 text-white text-xs font-bold rounded-full w-6 h-6 flex items-center justify-center">
                                {{ $category->products->count() }}
                            </div>
                        </div>
                        @else
                        <div
                            class="w-20 h-20 mx-auto bg-gradient-to-br from-orange-400 to-orange-600 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 transition">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
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
                    <div
                        class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2 relative">

                        <div class="absolute top-3 left-3 z-20">
                            <span
                                class="bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg animate-pulse">UNGGULAN</span>
                        </div>

                        <a href="{{ route('product.show', $product->slug) }}"
                            class="block relative overflow-hidden bg-gradient-to-br from-orange-50 to-white z-10">
                            @php
                            $thumb = $product->thumbnail;
                            if (!$thumb) {
                            $images = $product->images ?? collect();
                            $thumb = $images->first();
                            }
                            @endphp

                            @if($thumb)
                            <div class="relative p-4">
                                <!-- Decorative Background -->
                                <div class="absolute inset-0 opacity-20">
                                    <div
                                        class="absolute top-0 right-0 w-32 h-32 bg-orange-300 rounded-full blur-3xl"></div>
                                    <div
                                        class="absolute bottom-0 left-0 w-24 h-24 bg-yellow-300 rounded-full blur-2xl"></div>
                                </div>

                                <img src="{{ asset('storage/' . $thumb->image) }}"
                                    alt="{{ $product->name }}"
                                    class="relative w-full h-48 object-contain group-hover:scale-110 group-hover:rotate-3 transition duration-500 drop-shadow-xl">
                            </div>
                            @else
                            <div
                                class="w-full h-48 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                                <svg class="w-20 h-20 text-orange-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            @endif

                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/10 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                        </a>

                        <div class="p-4">
                            <p class="text-xs text-orange-600 font-semibold mb-1 flex items-center">
                                <span class="w-2 h-2 bg-orange-500 rounded-full mr-1.5"></span>
                                {{ $product->store->name }}
                            </p>

                            <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 h-12">
                                <a href="{{ route('product.show', $product->slug) }}"
                                    class="hover:text-orange-600 transition">
                                    {{ $product->name }}
                                </a>
                            </h3>

                            <div class="flex items-center mb-3 text-sm">
                                <div class="flex text-yellow-400">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < floor($product->averageRating()))
                                        ⭐
                                        @else
                                        <span class="text-gray-300">⭐</span>
                                        @endif
                                        @endfor
                                </div>
                                <span
                                    class="ml-2 text-gray-600 font-medium">{{ number_format($product->averageRating(), 1) }}</span>
                                <span class="ml-1 text-gray-400">({{ $product->totalReviews() }})</span>
                            </div>

                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-xs text-gray-500 line-through">
                                        Rp {{ number_format($product->price * 1.2, 0, ',', '.') }}</p>
                                    <p class="text-xl font-bold text-orange-600">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                @if(auth()->guest())
                                <a href="{{ route('login') }}"
                                    class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow-lg transition transform hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </a>
                                @else
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow-lg transition transform hover:scale-110">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
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
                        <span class="text-blue-500"></span> Semua Produk Tersedia
                    </h2>
                    <div class="flex items-center gap-3">
                        <select
                            class="border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                            <option>Terpopuler</option>
                            <option>Harga Terendah</option>
                            <option>Harga Tertinggi</option>
                            <option>Terbaru</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                    @foreach($products as $product)
                    <div
                        class="group bg-white rounded-2xl shadow-md hover:shadow-2xl overflow-hidden transition-all duration-300 transform hover:-translate-y-2 relative">

                        @if($product->stock < 10)
                            <div class="absolute top-3 right-3 z-10">
                            <span
                                class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg flex items-center gap-1">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                                Stok Terbatas!
                            </span>
                    </div>
                    @endif

                    <a href="{{ route('product.show', $product->slug) }}"
                        class="block relative overflow-hidden bg-gradient-to-br from-gray-50 to-white">
                        @php
                        $thumb = $product->thumbnail;
                        if (!$thumb) {
                        $images = $product->images ?? collect();
                        $thumb = $images->first();
                        }
                        @endphp

                        @if($thumb)
                        <div class="relative p-4">
                            <!-- Decorative Background -->
                            <div class="absolute inset-0 opacity-20">
                                <div
                                    class="absolute top-0 right-0 w-24 h-24 bg-blue-300 rounded-full blur-2xl"></div>
                                <div
                                    class="absolute bottom-0 left-0 w-20 h-20 bg-green-300 rounded-full blur-xl"></div>
                            </div>

                            <img src="{{ asset('storage/' . $thumb->image) }}"
                                alt="{{ $product->name }}"
                                class="relative w-full h-48 object-contain group-hover:scale-110 group-hover:-rotate-2 transition duration-500 drop-shadow-lg">
                        </div>
                        @else
                        <div
                            class="w-full h-48 bg-gradient-to-br from-orange-100 to-orange-200 flex items-center justify-center">
                            <svg class="w-20 h-20 text-orange-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        @endif

                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/5 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition"></div>
                    </a>

                    <div class="p-4">
                        <p class="text-xs text-gray-500 mb-1">{{ $product->store->name }}</p>

                        <h3 class="font-bold text-gray-800 mb-2 line-clamp-2 h-12">
                            <a href="{{ route('product.show', $product->slug) }}"
                                class="hover:text-orange-600 transition">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex items-center justify-between mb-3">
                            <span
                                class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-semibold">
                                Stok: {{ $product->stock }}
                            </span>
                        </div>

                        <div class="flex items-end justify-between">
                            <p class="text-lg font-bold text-orange-600">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            @if(auth()->guest())
                            <a href="{{ route('login') }}"
                                class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow transition transform hover:scale-110">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </a>
                            @else
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-orange-500 hover:bg-orange-600 text-white rounded-full p-2 shadow transition transform hover:scale-110">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
        </div>

    </div> {{-- end max-w wrapper --}}
    </div> {{-- end bg gradient --}}
</x-app-layout>