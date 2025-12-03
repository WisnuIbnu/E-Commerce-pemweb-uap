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

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center space-x-4">

                <!-- SEARCH BAR -->
                <form action="{{ route('products.search') }}" method="GET" class="hidden md:block">
                    <input type="text" name="q" placeholder="Cari beras, minyak, telur..."
                           class="px-3 py-2 border rounded-lg w-64 focus:ring-2 focus:ring-orange-400">
                </form>

                <!-- AUTH BUTTONS (UNTUK GUEST) atau USER DROPDOWN (UNTUK USER LOGIN) -->
                @if(Auth::check())
                    <!-- USER DROPDOWN (Jika sudah login) -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 bg-gray-100 rounded-lg text-gray-700 hover:bg-gray-200 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <svg class="ml-2 h-4 w-4" viewBox="0 0 20 20">
                                    <path fill="currentColor" d="M5.23 7.21a.75.75 0 011.06 0L10 10.92l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.27a.75.75 0 010-1.06z"/>
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                Profil
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- LOGIN & REGISTER BUTTONS (Jika guest) -->
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
            <a href="{{ route('home') }}" class="block text-gray-700 hover:text-orange-600">Home</a>
            <a href="{{ route('category.show', 'sembako') }}" class="block text-gray-700 hover:text-orange-600">Kategori</a>
            <a href="{{ route('products.search') }}" class="block text-gray-700 hover:text-orange-600">Produk</a>
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