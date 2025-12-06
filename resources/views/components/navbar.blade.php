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
                        class="text-tumbloo-white hover:text-tumbloo-gray-light px-3 py-2 text-sm font-medium transition">
                        Beranda
                    </a>
                    <a href="{{ route('marketplace') }}"
                        class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition">
                        Marketplace
                    </a>
                    <a href="{{ route('how-it-works') }}"
                        class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition">
                        Cara Kerja
                    </a>
                    <a href="{{ route('pricing') }}"
                        class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition">
                        Harga
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
                    <a href="{{ route('sell') }}"
                        class="text-tumbloo-gray hover:text-tumbloo-white px-4 py-2 text-sm font-medium transition">
                        Jual Blog
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="bg-tumbloo-accent-light hover:bg-tumbloo-accent text-tumbloo-white px-5 py-2 rounded-lg text-sm font-semibold transition">
                        Dashboard
                    </a>
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
                class="block text-tumbloo-white hover:bg-tumbloo-accent px-3 py-2 rounded-md text-base font-medium transition">
                Beranda
            </a>
            <a href="{{ route('marketplace') }}"
                class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                Marketplace
            </a>
            <a href="{{ route('how-it-works') }}"
                class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                Cara Kerja
            </a>
            <a href="{{ route('pricing') }}"
                class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                Harga
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
                    <a href="{{ route('sell') }}"
                        class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Jual Blog
                    </a>
                    <a href="{{ route('dashboard') }}"
                        class="block bg-tumbloo-accent-light text-tumbloo-white px-3 py-2 rounded-md text-base font-semibold mt-2">
                        Dashboard
                    </a>
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