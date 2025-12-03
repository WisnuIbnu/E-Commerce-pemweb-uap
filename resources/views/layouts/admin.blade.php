<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <!-- Admin Navbar -->
    <nav class="bg-white border-b shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" class="h-10" alt="">
                <span class="font-bold text-xl text-gray-700">Admin Panel</span>
            </a>

            <!-- Hamburger for mobile -->
            <button id="menuBtn" class="sm:hidden text-gray-700">
                ☰
            </button>

            <!-- Menu normal -->
            <div class="hidden sm:flex gap-6 text-gray-700">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-red-600">Dashboard</a>
                <a href="{{ route('admin.users') }}" class="hover:text-red-600">Users</a>
                <a href="{{ route('admin.sellers') }}" class="hover:text-red-600">Sellers</a>
                <a href="{{ route('admin.products') }}" class="hover:text-red-600">Products</a>
                <a href="{{ route('admin.orders') }}" class="hover:text-red-600">Orders</a>
            </div>
        </div>

        <!-- Menu mobile -->
        <div id="mobileMenu" class="hidden sm:hidden bg-white border-t p-4 space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block">Dashboard</a>
            <a href="{{ route('admin.users') }}" class="block">Users</a>
            <a href="{{ route('admin.sellers') }}" class="block">Sellers</a>
            <a href="{{ route('admin.products') }}" class="block">Products</a>
            <a href="{{ route('admin.orders') }}" class="block">Orders</a>
        </div>
    </nav>

    <!-- Content -->
    <main class="p-6">
        @yield('content')
    </main>

    <script>
        document.getElementById('menuBtn').addEventListener('click', () => {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
