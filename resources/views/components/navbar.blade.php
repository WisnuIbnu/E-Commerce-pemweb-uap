<nav class="bg-tumbloo-black shadow-lg sticky top-0 z-50 border-b border-tumbloo-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Tumbloo" class="h-8 w-auto">
                    </a>
                </div>

                <!-- Menu Desktop -->
                <div class="hidden md:ml-10 md:flex md:space-x-8">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-tumbloo-white' : 'text-tumbloo-gray hover:text-tumbloo-white' }} px-3 py-2 text-sm font-medium transition">
                        Hot Product
                    </a>
                    <a href="{{ route('marketplace') }}"
                        class="{{ request()->routeIs('marketplace') ? 'text-tumbloo-white' : 'text-tumbloo-gray hover:text-tumbloo-white' }} px-3 py-2 text-sm font-medium transition">
                        Marketplace
                    </a>
                    <a href="{{ route('transaction.index') }}"
                        class="{{ request()->routeIs('transaction.*') ? 'text-tumbloo-white' : 'text-tumbloo-gray hover:text-tumbloo-white' }} px-3 py-2 text-sm font-medium transition">
                        Riwayat Transaksi
                    </a>
                </div>
            </div>

            <!-- Right Side Buttons -->
            <div class="hidden md:flex md:items-center md:space-x-4">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-tumbloo-gray hover:text-tumbloo-white px-4 py-2 text-sm font-medium transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="bg-tumbloo-white hover:bg-tumbloo-offwhite text-tumbloo-black px-5 py-2 rounded-lg text-sm font-semibold transition">
                        Daftar Sekarang
                    </a>
                @else
                    <!-- Cart Link -->
                    <a href="{{ route('cart.index') }}" 
                       class="relative flex items-center space-x-1 {{ request()->routeIs('cart.*') ? 'text-tumbloo-white' : 'text-tumbloo-gray hover:text-tumbloo-white' }} px-3 py-2 text-sm font-medium transition group">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        <span class="hidden lg:inline">Keranjang</span>
                        
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full min-w-[20px] h-5 flex items-center justify-center px-1.5 animate-pulse">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    @php
                        $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
                    @endphp

                    @if($userStore)
                        @if($userStore->is_verified)
                            <a href="{{ route('store.dashboard') }}"
                                class="flex items-center space-x-2 text-blue-300 hover:text-blue-600 px-4 py-2 text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Dashboard Toko</span>
                            </a>
                        @else
                            <a href="{{ route('store.pending') }}"
                                class="flex items-center space-x-2 text-yellow-400 hover:text-yellow-300 px-4 py-2 text-sm font-medium transition">
                                <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status Toko</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('store.register') }}"
                            class="flex items-center space-x-2 text-tumbloo-gray hover:text-tumbloo-white px-4 py-2 text-sm font-medium transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Jual Brand</span>
                        </a>
                    @endif
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center space-x-2 text-tumbloo-white hover:text-tumbloo-gray-light focus:outline-none transition">
                            <div class="h-9 w-9 rounded-full bg-tumbloo-accent flex items-center justify-center text-sm font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium hidden lg:block">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-48 bg-tumbloo-dark rounded-lg shadow-xl border border-tumbloo-accent py-2 z-50">
                            
                            <div class="px-4 py-2 border-b border-tumbloo-accent">
                                <p class="text-sm font-medium text-tumbloo-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-tumbloo-gray">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile') }}"
                                class="block px-4 py-2 text-sm text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white transition">
                                <i class="fas fa-user mr-2"></i> Profil Saya
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="block px-4 py-2 text-sm text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white transition">
                                <i class="fas fa-th-large mr-2"></i> Dashboard
                            </a>
                            <a href="{{ route('settings') }}"
                                class="block px-4 py-2 text-sm text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white transition">
                                <i class="fas fa-cog mr-2"></i> Pengaturan
                            </a>

                            <div class="border-t border-tumbloo-accent mt-2"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-tumbloo-accent hover:text-red-300 transition">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center md:hidden">
                <button id="mobile-menu-btn" class="text-tumbloo-gray hover:text-tumbloo-white p-2">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-tumbloo-dark border-t border-tumbloo-accent">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}"
                class="block {{ request()->routeIs('home') ? 'text-tumbloo-white bg-tumbloo-accent' : 'text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white' }} px-3 py-2 rounded-md text-base font-medium transition">
                Hot Product
            </a>
            <a href="{{ route('marketplace') }}"
                class="block {{ request()->routeIs('marketplace') ? 'text-tumbloo-white bg-tumbloo-accent' : 'text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white' }} px-3 py-2 rounded-md text-base font-medium transition">
                Marketplace
            </a>
            <a href="{{ route('transaction.index') }}"
                class="block {{ request()->routeIs('transaction.*') ? 'text-tumbloo-white bg-tumbloo-accent' : 'text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white' }} px-3 py-2 rounded-md text-base font-medium transition">
                Riwayat Transaksi
            </a>

            @guest
                <div class="pt-2 border-t border-tumbloo-accent">
                    <a href="{{ route('login') }}"
                        class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block bg-tumbloo-white text-tumbloo-black px-3 py-2 rounded-md text-base font-semibold mt-2">
                        Daftar Sekarang
                    </a>
                </div>
            @else
                <div class="pt-2 border-t border-tumbloo-accent">
                    <!-- Cart Link Mobile -->
                    <a href="{{ route('cart.index') }}"
                        class="flex items-center justify-between text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            <span>Keranjang</span>
                        </div>
                        @php
                            $cartCount = \App\Models\Cart::where('user_id', auth()->id())->count();
                        @endphp
                        @if($cartCount > 0)
                            <span class="bg-red-500 text-white text-xs font-bold rounded-full min-w-[24px] h-6 flex items-center justify-center px-2">
                                {{ $cartCount > 99 ? '99+' : $cartCount }}
                            </span>
                        @endif
                    </a>

                    <div class="px-3 py-2 mb-2">
                        <div class="flex items-center space-x-3">
                            <div class="h-10 w-10 rounded-full bg-tumbloo-accent flex items-center justify-center text-sm font-semibold text-tumbloo-white">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-tumbloo-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-tumbloo-gray">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                    </div>

                    @php
                        $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
                    @endphp

                    @if($userStore)
                        @if($userStore->is_verified)
                            <a href="{{ route('store.dashboard') }}"
                                class="flex items-center space-x-2 text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                                <span>Dashboard Toko</span>
                            </a>
                        @else
                            <a href="{{ route('store.pending') }}"
                                class="flex items-center space-x-2 text-yellow-400 hover:bg-tumbloo-accent hover:text-yellow-300 px-3 py-2 rounded-md text-base font-medium transition">
                                <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Status Toko</span>
                            </a>
                        @endif
                    @else
                        <a href="{{ route('store.register') }}"
                            class="flex items-center space-x-2 text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Jual Brand</span>
                        </a>
                    @endif

                    <a href="{{ route('profile') }}"
                        class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Profil Saya
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Dashboard
                    </a>
                    <a href="{{ route('settings') }}"
                        class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Pengaturan
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit"
                            class="w-full text-left block text-red-400 hover:bg-tumbloo-accent hover:text-red-300 px-3 py-2 rounded-md text-base font-medium transition">
                            Keluar
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });
        }
    });
</script>