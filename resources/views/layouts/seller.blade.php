<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Seller - @yield('title') | ELSHOP</title>
    
    {{-- VITE CSS & JS --}}
    @vite(['resources/css/seller.css', 'resources/js/seller.js'])
    
    @stack('styles')
</head>
<body>
    <header>
        <nav>
            <a href="{{ route('seller.dashboard') }}" class="{{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('seller.products.index') }}" class="{{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                Produk
            </a>
            <a href="{{ route('seller.categories.index') }}" class="{{ request()->routeIs('seller.categories.*') ? 'active' : '' }}">
                Kategori
            </a>
            <a href="{{ route('seller.orders.index') }}" class="{{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                Pesanan
            </a>
            <a href="{{ route('seller.balance.index') }}" class="{{ request()->routeIs('seller.balance.*') ? 'active' : '' }}">
                Saldo
            </a>
            <a href="{{ route('seller.withdraw.index') }}" class="{{ request()->routeIs('seller.withdraw.*') ? 'active' : '' }}">
                Penarikan
            </a>
            <a href="{{ route('seller.store.edit') }}" class="{{ request()->routeIs('seller.store.*') ? 'active' : '' }}">
                Toko
            </a>
            
            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#6b7280;cursor:pointer;padding:20px 0;font-size:0.938rem;font-family:inherit;">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    <main>
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success">
                <strong>✓</strong> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <strong>✗</strong> {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <strong>⚠</strong> {{ session('warning') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <strong>ℹ</strong> {{ session('info') }}
            </div>
        @endif

        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html>