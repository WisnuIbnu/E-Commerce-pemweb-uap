<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #F0F8FF !important;
            font-family: "Poppins", sans-serif;
        }

        .sidebar {
            min-height: 100vh;
            width: 260px;
            background-color: #93C5FD;
            padding: 25px 20px;
            position: fixed;
        }

        .sidebar h4 {
            font-weight: 700;
            color: #1E3A8A;
        }

        .sidebar a {
            display: block;
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 8px;
            color: #1E3A8A;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar .active {
            background-color: #60A5FA;
            color: white;
        }

        .content {
            margin-left: 280px;
            padding: 30px;
        }

        .card {
            border-radius: 12px;
            border: none;
        }

        .navbar {
            background-color: #60A5FA !important;
        }

        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            padding: 15px;
            color: #1E3A8A;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="mb-4">Seller Panel</h4>

        {{-- <a href="{{ route('seller.dashboard') }}" class="{{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
            Dashboard
        </a>
        <a href="{{ route('seller.products.index') }}" class="{{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
            Produk
        </a>
        <a href="{{ route('seller.orders.index') }}" class="{{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
            Pesanan
        </a>
        <a href="{{ route('seller.balance.index') }}" class="{{ request()->routeIs('seller.balance.*') ? 'active' : '' }}">
            Saldo
        </a>
        <a href="{{ route('seller.withdrawals.index') }}" class="{{ request()->routeIs('seller.withdrawals.*') ? 'active' : '' }}">
            Penarikan Dana
        </a> --}}
        <a href="{{ route('profile.edit') }}">
            Pengaturan Akun
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>


    <!-- Content -->
    <div class="content">
        <nav class="navbar navbar-light mb-4 rounded shadow-sm px-3">
            <span class="navbar-brand">Hi, {{ Auth::user()->name }}</span>
        </nav>

        @yield('content')

        <footer>
            &copy; {{ date('Y') }} Seller Dashboard - All rights reserved.
        </footer>
    </div>

</body>

</html>
