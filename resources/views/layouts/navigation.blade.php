<nav x-data="{ open: false }" class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center">
                <!-- LOGO -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
                        class="h-8 w-8" alt="Logo">
                    <span class="text-xl font-bold text-orange-400">Sembako Mart</span>
                </a>

                <!-- NAV LINKS -->
                <div class="hidden sm:flex sm:items-center sm:ml-10 space-x-6">

                    @guest
                    {{-- MENU UNTUK PENGUNJUNG (BELUM LOGIN) --}}
                    <a href="{{ route('home') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium {{ request()->routeIs('home') ? 'text-orange-500 font-semibold' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('category.show', 'sembako') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Kategori
                    </a>

                    <a href="{{ route('products.search') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Produk
                    </a>
                    @else
                    @if(Auth::user()->role === 'seller')
                    {{-- MENU KHUSUS SELLER --}}
                    <a href="{{ route('seller.dashboard') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium {{ request()->routeIs('seller.dashboard') ? 'text-orange-500 font-semibold' : '' }}">
                        Dashboard Toko
                    </a>

                    <a href="{{ route('seller.dashboard') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Produk Saya
                    </a>

                    <a href="{{ route('seller.dashboard') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Pesanan Masuk
                    </a>

                    <a href="{{ route('seller.form') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium {{ request()->routeIs('seller.form') ? 'text-orange-500 font-semibold' : '' }}">
                        Pengaturan Toko
                    </a>
                    @else
                    {{-- MENU UNTUK BUYER --}}
                    <a href="{{ route('dashboard') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium {{ request()->routeIs('dashboard') ? 'text-orange-500 font-semibold' : '' }}">
                        Home
                    </a>

                    <a href="{{ route('category.show', 'sembako') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Kategori
                    </a>

                    <a href="{{ route('products.search') }}"
                        class="text-gray-700 hover:text-orange-400 font-medium">
                        Produk
                    </a>
                    @endif
                    @endguest

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center space-x-4">

                <!-- SEARCH BAR -->
                <form action="{{ route('products.search') }}" method="GET" class="hidden md:block">
                    <input type="text" name="q" placeholder="Cari beras, minyak, telur..."
                        class="px-3 py-2 border rounded-lg w-64 focus:ring-2 focus:ring-orange-400">
                </form>

                @if(Auth::check())
                @php
                $user = Auth::user();
                $photo = $user->profile_photo_url
                ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=FFEDD5&color=EA580C';
                @endphp

                <!-- AVATAR + NAME BUTTON -->
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-2 bg-gray-100 hover:bg-gray-200 px-3 py-1.5 rounded-full transition">

                    <img src="{{ $photo }}"
                        class="h-9 w-9 rounded-full object-cover border border-orange-300"
                        alt="Profile">

                    <span class="text-gray-700 font-medium hidden md:inline">
                        {{ $user->name }}
                    </span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                        class="p-2 rounded-full bg-gray-100 hover:bg-red-100 text-red-500 transition"
                        title="Logout">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m0 0h-1a2 2 0 00-2 2v10a2 2 0 002 2h1" />
                        </svg>
                    </button>
                </form>

                @else

                <!-- LOGIN & REGISTER BUTTONS (GUEST) -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 border-2 border-orange-400 text-orange-400 rounded-lg font-medium hover:bg-orange-400 hover:text-white transition-all duration-300">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-orange-400 text-white rounded-lg font-medium hover:bg-orange-500 transition-all duration-300">
                        Register
                    </a>
                </div>
                @endif

            </div>

            <!-- MOBILE MENU BUTTON -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-md text-gray-600 hover:bg-gray-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor">
                        <path :class="{'hidden': open, 'block': !open }"
                            class="block"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'block': open }"
                            class="hidden"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE RESPONSIVE MENU -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-white border-t">

        <!-- Mobile Links -->
        <div class="p-4 space-y-2">
            @guest
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-orange-600">Home</a>
            <a href="{{ route('category.show', 'sembako') }}" class="block text-gray-700 hover:text-orange-600">Kategori</a>
            <a href="{{ route('products.search') }}" class="block text-gray-700 hover:text-orange-600">Produk</a>
            @else
            @if(Auth::user()->role === 'seller')
            <a href="{{ route('seller.dashboard') }}" class="block text-gray-700 hover:text-orange-600">Dashboard Toko</a>
            <a href="{{ route('seller.dashboard') }}" class="block text-gray-700 hover:text-orange-600">Produk Saya</a>
            <a href="{{ route('seller.dashboard') }}" class="block text-gray-700 hover:text-orange-600">Pesanan Masuk</a>
            <a href="{{ route('seller.form') }}" class="block text-gray-700 hover:text-orange-600">Pengaturan Toko</a>
            @else
            <a href="{{ route('dashboard') }}" class="block text-gray-700 hover:text-orange-600">Home</a>
            <a href="{{ route('category.show', 'sembako') }}" class="block text-gray-700 hover:text-orange-600">Kategori</a>
            <a href="{{ route('products.search') }}" class="block text-gray-700 hover:text-orange-600">Produk</a>
            @endif
            @endguest
        </div>

        <!-- Mobile User Info / Auth Buttons -->
        <div class="border-t p-4">
            @if(Auth::check())
            <p class="text-gray-800 font-medium">{{ Auth::user()->name }}</p>
            <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>

            <div class="mt-3">

                <a href="{{ route('profile.edit') }}" class="block py-2 text-gray-700 hover:text-orange-600">Profil</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                        class="block py-2 text-gray-700 hover:text-red-600">
                        Log Out
                    </a>
                </form>
            </div>
            @else
            <!-- Mobile Login & Register Buttons -->
            <div class="space-y-2">
                <a href="{{ route('login') }}"
                    class="block w-full text-center px-4 py-2 border-2 border-orange-400 text-orange-400 rounded-lg font-medium hover:bg-orange-400 hover:text-white transition">
                    Login
                </a>
                <a href="{{ route('register') }}"
                    class="block w-full text-center px-4 py-2 bg-orange-400 text-white rounded-lg font-medium hover:bg-orange-500 transition">
                    Register
                </a>
            </div>
            @endif
        </div>
    </div>
</nav>