<header class="buyer-header">
    {{-- Top Bar --}}
    <div class="header-top">
        <div class="header-top-content">
            <div class="location-info">
                <i class="fas fa-map-marker-alt"></i>
                Dikirim ke {{ auth()->user()->city ?? 'Malang' }}, {{ auth()->user()->province ?? 'East Java' }}
            </div>
            <div class="user-actions">
                @guest
                    <a href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt"></i> Masuk
                    </a>
                    <a href="{{ route('register') }}">
                        <i class="fas fa-user-plus"></i> Daftar
                    </a>
                @else
                    @php
                        $hasStore = \App\Models\Store::where('user_id', auth()->id())
                            ->where('is_verified', 1)
                            ->exists();
                    @endphp
                    @if(!$hasStore)
                        <a href="{{ route('store.apply') }}">
                            <i class="fas fa-store"></i> Daftar Jadi Seller
                        </a>
                    @endif
                @endguest
                <a href="#">
                    <i class="fas fa-question-circle"></i> Bantuan
                </a>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="header-main">
        <div class="header-main-content">
            {{-- Logo --}}
            <a href="{{ route('buyer.dashboard') }}" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <span>ELSHOP</span>
            </a>

            {{-- Search Bar --}}
            <form action="{{ route('buyer.dashboard') }}" method="GET" class="search-bar">
                <input 
                    type="text" 
                    name="search" 
                    class="search-input" 
                    placeholder="Cari produk di ELSHOP..."
                    value="{{ request('search') }}"
                >
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            {{-- Header Actions --}}
            <div class="header-actions">
                @auth
                    {{-- Cart --}}
                    <a href="{{ route('buyer.cart.index') }}" class="header-action">
                        <div class="action-icon">
                            <i class="fas fa-shopping-cart"></i>
                            @if(auth()->user()->cartItems && auth()->user()->cartItems->count() > 0)
                                <span class="badge">{{ auth()->user()->cartItems->count() }}</span>
                            @endif
                        </div>
                        <span class="action-label">Keranjang</span>
                    </a>

                    {{-- Orders --}}
                    <a href="{{ route('buyer.orders.index') }}" class="header-action">
                        <div class="action-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <span class="action-label">Pesanan</span>
                    </a>

                    {{-- Profile Dropdown --}}
                    <div class="profile-dropdown" id="profileDropdown">
                        <button type="button" class="profile-trigger">
                            <div class="profile-avatar">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <span class="profile-name">{{ Str::limit(auth()->user()->name, 10) }}</span>
                            <i class="fas fa-chevron-down dropdown-icon"></i>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div class="profile-menu">
                            {{-- Header --}}
                            <div class="profile-menu-header">
                                <div class="profile-menu-avatar">
                                    @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                                    @else
                                        <i class="fas fa-user-circle"></i>
                                    @endif
                                </div>
                                <div class="profile-menu-info">
                                    <div class="profile-menu-name">{{ auth()->user()->name }}</div>
                                    <a href="{{ route('buyer.profile.edit') }}" class="profile-menu-link">Lihat profil</a>
                                </div>
                            </div>

                            {{-- Menu Items --}}
                            <div class="profile-menu-body">
                                <a href="{{ route('buyer.orders.index') }}" class="profile-menu-item">
                                    <i class="fas fa-clipboard-list"></i>
                                    <span>Pesanan</span>
                                </a>

                                <a href="#" class="profile-menu-item">
                                    <i class="fas fa-wallet"></i>
                                    <span>E-Wallet</span>
                                    <span class="menu-badge">Rp 0</span>
                                </a>

                                <a href="{{ route('buyer.profile.edit') }}" class="profile-menu-item">
                                    <i class="fas fa-cog"></i>
                                    <span>Settings</span>
                                </a>

                                <div class="profile-menu-divider"></div>

                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="profile-menu-item logout-btn">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Log out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="header-action">
                        <div class="action-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="action-label">Masuk</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="header-nav">
        <div class="nav-content">
            <a href="{{ route('buyer.dashboard') }}" class="nav-link {{ request()->routeIs('buyer.dashboard') ? 'active' : '' }}">
                Beranda
            </a>
            <a href="{{ route('buyer.dashboard') }}" class="nav-link">
                Semua Produk
            </a>
            <a href="#" class="nav-link">
                Kategori
            </a>
            <a href="#" class="nav-link">
                Promo Spesial
            </a>
            <a href="#" class="nav-link">
                Produk Baru
            </a>
            <a href="#" class="nav-link">
                Terlaris
            </a>
        </div>
    </nav>
</header>

{{-- Dropdown Overlay --}}
<div class="dropdown-overlay" id="dropdownOverlay"></div>