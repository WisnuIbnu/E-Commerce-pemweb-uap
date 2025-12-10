<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            {{-- LEFT : LOGO --}}
            <div class="flex items-center gap-2">
                <img src="{{ asset('logo.png') }}" alt="SweetMart Logo" class="h-8 w-8 object-contain">

                <a href="{{ route('landing') }}" 
                   class="text-xl font-bold text-sweet-400 tracking-wide">
                    SweetMart
                </a>
            </div>

            {{-- CENTER : MENU --}}
            <div class="hidden md:flex gap-6 text-[15px] font-medium text-textdark">
                <a href="{{ route('landing') }}" class="hover:text-sweet-400 transition">Home</a>
                <a href="{{ route('categories.index') }}" class="hover:text-sweet-400 transition">Categories</a>
                <a href="{{ route('products.index') }}" class="hover:text-sweet-400 transition">Products</a>

                @auth
                <a href="{{ route('cart.index') }}" class="hover:text-sweet-400 transition">Cart</a>
                @endauth
            </div>

            {{-- RIGHT: AUTH BUTTONS --}}
            <div class="hidden md:flex items-center gap-4">

                {{-- CART --}}
                @auth
                    <a href="{{ route('cart.index') }}"
                       class="relative inline-flex items-center justify-center">
                        <svg class="w-6 h-6 text-textdark hover:text-sweet-400 transition"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l1.293 5.293
                                  a1 1 0 01-.948 1.207H5a1 1 0 01-1-1m4 0h6m0 0l1.293-5.293M17 18a2 2 0 11-4 0m6 0a2 2 0 11-4 0">
                            </path>
                        </svg>
                    </a>
                @endauth

                {{-- USER --}}
                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="px-4 py-2 bg-sweet-400 text-white rounded-lg hover:bg-sweet-500 transition">
                        {{ auth()->user()->name }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-sweet-400 text-white rounded-lg hover:bg-sweet-500 transition">
                       Login
                    </a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 border border-sweet-400 text-sweet-400 rounded-lg hover:bg-sweet-50 transition">
                       Register
                    </a>
                @endauth
            </div>

            {{-- MOBILE MENU BUTTON --}}
            <div class="md:hidden flex items-center">
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-7 h-7 text-textdark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="md:hidden hidden px-4 pb-4">
        <div class="flex flex-col gap-3 text-textdark">

            <a href="{{ route('landing') }}" class="py-2 border-b">Home</a>
            <a href="{{ route('categories.index') }}" class="py-2 border-b">Categories</a>
            <a href="{{ route('products.index') }}" class="py-2 border-b">Products</a>

            @auth
                <a href="{{ route('cart.index') }}" class="py-2 border-b">Cart</a>
                <a href="{{ route('profile.edit') }}" class="py-2 border-b">My Account</a>
            @else
                <a href="{{ route('login') }}" class="py-2 border-b">Login</a>
                <a href="{{ route('register') }}" class="py-2 border-b">Register</a>
            @endauth

        </div>
    </div>
</nav>