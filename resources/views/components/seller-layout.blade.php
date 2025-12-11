<!-- resources/views/components/seller-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Seller Dashboard - SORAÉ' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --color-primary: #561C24;
            --color-secondary: #6D2932;
            --color-tertiary: #C7B7A3;
            --color-light: #E8D8C4;
            --color-white: #FFFFFF;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f5f5f5;
            color: var(--color-primary);
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }

        .seller-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-secondary) 100%);
            color: var(--color-white);
            padding: 30px 0;
            position: fixed;
            width: 280px;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-logo {
            padding: 0 30px 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin-bottom: 30px;
        }

        .sidebar-logo img {
            max-width: 140px;
            filter: brightness(0) invert(1);
        }

        .sidebar-logo h2 {
            color: var(--color-white);
            margin-top: 15px;
            font-size: 1.4rem;
        }

        .store-badge {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 0.9rem;
        }

        .sidebar-menu {
            list-style: none;
        }

        .menu-item {
            margin-bottom: 5px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 14px 30px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .menu-link:hover,
        .menu-link.active {
            background: rgba(255, 255, 255, 0.15);
            color: var(--color-white);
        }

        .menu-icon {
            font-size: 22px;
            width: 26px;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            padding: 40px;
        }

        .topbar {
            background: var(--color-white);
            padding: 25px 30px;
            margin: -40px -40px 40px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .topbar-left h1 {
            font-size: 1.8rem;
            color: var(--color-primary);
        }

        .topbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .balance-badge {
            background: var(--color-light);
            padding: 12px 25px;
            border-radius: 25px;
            font-weight: 600;
            color: var(--color-primary);
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px 20px;
            background: var(--color-light);
            border-radius: 25px;
            cursor: pointer;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-white);
            font-weight: 600;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            color: var(--color-primary);
        }

        .user-role {
            font-size: 0.85rem;
            color: var(--color-tertiary);
        }

        /* Button Styles */
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            font-size: 0.95rem;
        }

        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .btn-primary:hover {
            background-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(86, 28, 36, 0.3);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }

        .btn-secondary:hover {
            background-color: var(--color-primary);
            color: var(--color-white);
        }

        .btn-danger {
            background-color: #dc3545;
            color: var(--color-white);
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        @media (max-width: 968px) {
            .seller-container {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                width: 100%;
                height: auto;
            }

            .main-content {
                margin-left: 0;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="seller-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="{{ asset('images/soraelogo.png') }}" alt="SORAÉ">
                <h2>Seller Panel</h2>
                <div class="store-badge">
                    {{ auth()->user()->store->name }}
                </div>
            </div>

            <ul class="sidebar-menu">
                <li class="menu-item">
                    <a href="{{ route('seller.dashboard') }}" 
                       class="menu-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                        <span class="menu-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('seller.products.index') }}" 
                       class="menu-link {{ request()->routeIs('seller.products.*') ? 'active' : '' }}">
                        <span class="menu-icon">📦</span>
                        <span>Products</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('seller.orders.index') }}" 
                       class="menu-link {{ request()->routeIs('seller.orders.*') ? 'active' : '' }}">
                        <span class="menu-icon">🛒</span>
                        <span>Orders</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('seller.balance.index') }}" 
                       class="menu-link {{ request()->routeIs('seller.balance.*') ? 'active' : '' }}">
                        <span class="menu-icon">💰</span>
                        <span>Balance</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('seller.withdrawals.index') }}" 
                       class="menu-link {{ request()->routeIs('seller.withdrawals.*') ? 'active' : '' }}">
                        <span class="menu-icon">💳</span>
                        <span>Withdrawals</span>
                    </a>
                </li>

                <li class="menu-item">
                    <a href="{{ route('seller.store.edit') }}" 
                       class="menu-link {{ request()->routeIs('seller.store.*') ? 'active' : '' }}">
                        <span class="menu-icon">⚙️</span>
                        <span>Store Settings</span>
                    </a>
                </li>

                <li class="menu-item" style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                    <a href="{{ route('home') }}" class="menu-link">
                        <span class="menu-icon">🏠</span>
                        <span>Back to Website</span>
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="topbar">
                <div class="topbar-left">
                    <p style="color: var(--color-tertiary); margin-bottom: 5px; font-size: 0.9rem;">Welcome back,</p>
                    <h1>{{ auth()->user()->name }}</h1>
                </div>

                <div class="topbar-right">
                    <div class="balance-badge">
                        💰 Balance: Rp {{ number_format(auth()->user()->store->balance, 0, ',', '.') }}
                    </div>

                    <div class="user-menu">
                        <div class="user-avatar">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                            <span class="user-role">Seller</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-secondary">Logout</button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px;">
                    {{ session('error') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
