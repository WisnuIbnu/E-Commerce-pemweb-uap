<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-lunpia-cream flex">

    <!-- SIDEBAR -->
    <aside 
        id="sidebar"
        class="w-64 bg-white h-screen shadow-lg fixed top-0 left-0 transform -translate-x-full 
               transition-transform duration-300 z-40 md:translate-x-0">

        <div class="p-5 border-b">
            <img src="/images/logo.png" class="w-32 mx-auto">
        </div>

        <nav class="p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" 
                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active-nav' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.users') }}" 
                class="nav-link {{ request()->routeIs('admin.users') ? 'active-nav' : '' }}">
                Users
            </a>
            <a href="{{ route('admin.sellers') }}" 
                class="nav-link {{ request()->routeIs('admin.sellers') ? 'active-nav' : '' }}">
                Sellers
            </a>
            <a href="{{ route('admin.products') }}" 
                class="nav-link {{ request()->routeIs('admin.products') ? 'active-nav' : '' }}">
                Products
            </a>
            <a href="{{ route('admin.orders') }}" 
                class="nav-link {{ request()->routeIs('admin.orders') ? 'active-nav' : '' }}">
                Orders
            </a>
        </nav>
    </aside>

    <!-- OVERLAY (mobile) -->
    <div 
        id="overlay"
        class="fixed inset-0 bg-black bg-opacity-40 hidden z-30 md:hidden">
    </div>

    <!-- NAVBAR -->
    <header class="w-full md:ml-64 bg-white shadow fixed top-0 z-20">
        <div class="flex items-center justify-between px-6 py-4">

            <!-- Hamburger -->
            <button id="openSidebar" class="md:hidden text-gray-700 text-2xl">
                ☰
            </button>

            <h1 class="text-xl font-semibold text-gray-700">@yield('title')</h1>

            <div class="font-medium">{{ Auth::user()->name }}</div>
        </div>
    </header>

    <!-- MAIN CONTENT -->
    <main class="flex-1 mt-20 p-6 md:ml-64">
        @yield('content')
    </main>


    <!-- Script -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const overlay  = document.getElementById('overlay');
        const openBtn = document.getElementById('openSidebar');

        openBtn.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });

        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    </script>

    <!-- Tailwind helper classes -->
    <style>
        .nav-link {
            display:block;
            padding:10px 14px;
            border-radius:8px;
            font-weight:500;
            color:#444;
            transition:.2s;
        }
        .nav-link:hover {
            background:#ffe4b8;
        }
        .active-nav {
            background:#ffd38c;
            color:#000;
        }
    </style>
</body>
</html>
