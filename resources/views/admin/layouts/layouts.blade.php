<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - Tumbloo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-tumbloo-offwhite">
    <!-- Admin Navbar -->
    <nav class="bg-tumbloo-black shadow-lg sticky top-0 z-50 border-b border-tumbloo-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Tumbloo Admin" class="h-8 w-auto">
                            <span class="text-tumbloo-white text-sm font-semibold">Admin Panel</span>
                        </a>
                    </div>

                    <div class="hidden md:ml-10 md:flex md:space-x-4">
                        <a href="{{ route('admin.dashboard') }}" 
                            class="text-tumbloo-white hover:text-tumbloo-gray-light px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'border-b-2 border-tumbloo-white' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.store-verification.index') }}" 
                            class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.store-verification.*') ? 'border-b-2 border-tumbloo-white text-tumbloo-white' : '' }}">
                            Verifikasi Toko
                        </a>
                        <a href="{{ route('admin.stores.index') }}" 
                            class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.stores.*') ? 'border-b-2 border-tumbloo-white text-tumbloo-white' : '' }}">
                            Kelola Toko
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                            class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'border-b-2 border-tumbloo-white text-tumbloo-white' : '' }}">
                            Kelola User
                        </a>
                        <a href="{{ route('admin.transactions') }}" 
                            class="text-tumbloo-gray hover:text-tumbloo-white px-3 py-2 text-sm font-medium transition {{ request()->routeIs('admin.transactions') ? 'border-b-2 border-tumbloo-white text-tumbloo-white' : '' }}">
                            Transaksi
                        </a>
                    </div>
                </div>

                <div class="hidden md:flex md:items-center md:space-x-4">
                    <a href="{{ route('home') }}" 
                        class="text-tumbloo-gray hover:text-tumbloo-white px-4 py-2 text-sm font-medium transition">
                        Lihat Website
                    </a>
                    <div class="relative">
                        <button id="user-menu-btn" class="flex items-center space-x-2 text-tumbloo-white hover:text-tumbloo-gray-light transition">
                            <span class="text-sm font-medium">{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 bg-tumbloo-dark rounded-lg shadow-lg py-1 border border-tumbloo-accent">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white transition">
                                Profil Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white transition">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-btn" class="text-tumbloo-gray hover:text-tumbloo-white p-2">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-tumbloo-dark border-t border-tumbloo-accent">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="block text-tumbloo-white hover:bg-tumbloo-accent px-3 py-2 rounded-md text-base font-medium transition">
                    Dashboard
                </a>
                <a href="{{ route('admin.store-verification.index') }}" class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                    Verifikasi Toko
                </a>
                <a href="{{ route('admin.stores.index') }}" class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                    Kelola Toko
                </a>
                <a href="{{ route('admin.users.index') }}" class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                    Kelola User
                </a>
                <a href="{{ route('admin.transactions') }}" class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                    Transaksi
                </a>
                <div class="pt-2 border-t border-tumbloo-accent">
                    <a href="{{ route('home') }}" class="block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                        Lihat Website
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block text-tumbloo-gray hover:bg-tumbloo-accent hover:text-tumbloo-white px-3 py-2 rounded-md text-base font-medium transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="alert alert-success fade-in">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        <div class="alert alert-error fade-in">
            <div class="flex items-center">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const menuBtn = document.getElementById('mobile-menu-btn');
            const mobileMenu = document.getElementById('mobile-menu');
            const userMenuBtn = document.getElementById('user-menu-btn');
            const userMenu = document.getElementById('user-menu');

            if (menuBtn && mobileMenu) {
                menuBtn.addEventListener('click', function () {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            if (userMenuBtn && userMenu) {
                userMenuBtn.addEventListener('click', function () {
                    userMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function(event) {
                    if (!userMenuBtn.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>