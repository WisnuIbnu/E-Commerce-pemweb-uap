<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-red-600">👨‍💼 Admin Panel</h1>

                <div class="flex gap-4 items-center">
                    <a href="{{ route('home') }}" class="text-blue-600">🏠 Home</a>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'font-bold text-gray-900' : 'text-gray-700' }}">Dashboard</a>
                    <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users*') ? 'font-bold text-gray-900' : 'text-gray-700' }}">Kelola User</a>
                    <a href="{{ route('admin.store-verification') }}" class="{{ request()->routeIs('admin.store-verification') ? 'font-bold text-gray-900' : 'text-gray-700' }}">Verifikasi Toko</a>
                    <a href="{{ route('admin.withdrawals') }}" class="{{ request()->routeIs('admin.withdrawals') ? 'font-bold text-gray-900' : 'text-gray-700' }}">Withdrawal</a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Halaman konten -->
    <div class="max-w-7xl mx-auto px-4 py-8">
        @yield('content')
    </div>

</body>
</html>
