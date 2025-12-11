<!-- Sidebar Navigation -->
<div class="sidebar-navigation">
    <h2 class="sidebar-title">User Profile</h2>
    
    <nav class="sidebar-nav">
        <!-- User Info -->
        <a href="{{ route('profile.edit') }}" 
           class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="nav-text">User info</span>
        </a>        

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Seller Menu -->
        @if(auth()->user()->role === 'seller')
            <!-- Dashboard -->
            <a href="{{ route('store.dashboard') }}" 
               class="nav-item {{ request()->routeIs('store.dashboard') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="nav-text">Dashboard</span>
            </a>

            <!-- Orders -->
            <a href="{{ route('store.orders') }}" 
               class="nav-item {{ request()->routeIs('store.orders') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="nav-text">Orders</span>
            </a>

            <!-- Products -->
            <a href="{{ route('store.manage') }}" 
               class="nav-item {{ request()->routeIs('store.manage') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                <span class="nav-text">Products</span>
            </a>

            <!-- Balance -->
            <a href="{{ route('store.balance') }}" 
               class="nav-item {{ request()->routeIs('store.balance') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span class="nav-text">Balance</span>
            </a>

            <!-- Withdrawal -->
            <a href="{{ route('store.withdrawal') }}" 
               class="nav-item {{ request()->routeIs('store.withdrawal') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="nav-text">Withdrawal</span>
            </a>
        @elseif(auth()->user()->role === 'admin')
            <!-- Dashboard Admin -->
            <a href="{{ route('admin.dashboard') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="nav-text">Dashboard Admin</span>
            </a>
        @else
            <!-- Jika belum seller, tampilkan Mulai Jual -->
            <a href="{{ route('store.register') }}" class="nav-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="nav-text">Mulai Jual</span>
            </a>
        @endif

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Log out -->
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <button type="submit" class="nav-item logout-item">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span class="nav-text">Log out</span>
            </button>
        </form>
    </nav>
</div>

<style>
    /* Sidebar Container */
    .sidebar-navigation {
        width: 16rem;
        background-color: white;
        border-right: 1px solid #e5e7eb;
        min-height: 100vh;
        padding: 1.5rem;
    }

    .sidebar-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #1f2937;
    }

    /* Navigation */
    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    /* Navigation Items */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 0.875rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.15s ease-in-out;
        text-decoration: none;
        color: #374151;
        position: relative;
        cursor: pointer;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        font-family: inherit;
        font-size: inherit;
    }

    .nav-item:hover {
        background-color: #f9fafb;
    }

    .nav-item.active {
        background-color: #fef3e2;
        color: #984216;
    }

    .nav-item.active:hover {
        background-color: #fef3e2;
    }

    /* Logout specific styling */
    .logout-item {
        color: #ef4444;
    }

    .logout-item:hover {
        background-color: #fef2f2;
    }

    /* Icon */
    .nav-icon {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.75rem;
        flex-shrink: 0;
    }

    /* Text */
    .nav-text {
        font-weight: 500;
    }

    /* Divider */
    .nav-divider {
        height: 1px;
        background-color: #e5e7eb;
        margin: 1rem 0;
    }

    /* Responsive Tablet */
    @media (max-width: 1024px) {
        .sidebar-navigation {
            width: 14rem;
        }
        
        .sidebar-title {
            font-size: 1.25rem;
        }
    }

    /* Responsive Mobile */
    @media (max-width: 768px) {
        .sidebar-navigation {
            width: 100%;
            min-height: auto;
            border-right: none;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem;
        }
        
        .sidebar-title {
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }
        
        .nav-item {
            padding: 0.75rem 0.875rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 640px) {
        .sidebar-navigation {
            position: fixed;
            top: 0;
            left: -100%;
            width: 80%;
            max-width: 280px;
            height: 100vh;
            z-index: 1000;
            transition: left 0.3s ease;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            border-right: 1px solid #e5e7eb;
            border-bottom: none;
            overflow-y: auto;
        }

        .sidebar-navigation.mobile-open {
            left: 0;
        }
    }
</style>

<script>
    // Add click animation to nav items
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                this.style.transform = 'scale(0.98)';
                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 100);
            });
        });
    });

    // Mobile menu toggle (optional)
    function toggleMobileMenu() {
        const sidebar = document.querySelector('.sidebar-navigation');
        sidebar.classList.toggle('mobile-open');
    }
</script>