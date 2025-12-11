<!-- resources/views/layouts/sidebar-admin.blade.php -->
<div class="sidebar-navigation">
    <h2 class="sidebar-title">Admin Panel</h2>
    
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="nav-text">Dashboard</span>
        </a>

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Users Management -->
        <a href="{{ route('admin.users') }}" 
           class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
            <span class="nav-text">Users</span>
        </a>

        <!-- Stores Management -->
        <a href="{{ route('admin.stores') }}" 
           class="nav-item {{ request()->routeIs('admin.stores') && !request()->routeIs('admin.stores.verification') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <span class="nav-text">Stores</span>
        </a>

        <!-- Store Verification -->
        <a href="{{ route('admin.stores.verification') }}" 
           class="nav-item {{ request()->routeIs('admin.stores.verification') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="nav-text">Verification</span>
        </a>

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Settings -->
        <a href="{{ route('profile.edit') }}" 
           class="nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="nav-text">Settings</span>
        </a>

        <!-- Back to User Dashboard -->
        <a href="{{ route('dashboard') }}" class="nav-item">
            <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="nav-text">User Dashboard</span>
        </a>

        <!-- Divider -->
        <div class="nav-divider"></div>

        <!-- Admin Info Card -->
        <div class="admin-info-card">
            <div class="admin-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            <div class="admin-details">
                <div class="admin-name">{{ Auth::user()->name }}</div>
                <div class="admin-role">Administrator</div>
            </div>
        </div>

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
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin-bottom: 2rem;
        color: #984216;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-title::before {
        content: '👑';
        font-size: 1.75rem;
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
        color: #984216;
    }

    .nav-item.active {
        background: linear-gradient(135deg, #fef3e2 0%, #fde8cc 100%);
        color: #984216;
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(152, 66, 22, 0.1);
    }

    .nav-item.active:hover {
        background: linear-gradient(135deg, #fef3e2 0%, #fde8cc 100%);
    }

    .nav-item.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 70%;
        background: #984216;
        border-radius: 0 4px 4px 0;
    }

    /* Logout specific styling */
    .logout-item {
        color: #ef4444;
        margin-top: 0.5rem;
    }

    .logout-item:hover {
        background-color: #fef2f2;
        color: #dc2626;
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
        font-size: 0.9375rem;
    }

    /* Divider */
    .nav-divider {
        height: 1px;
        background-color: #e5e7eb;
        margin: 1rem 0;
    }

    /* Admin Info Card */
    .admin-info-card {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: linear-gradient(135deg, #F9F9F9 0%, #FEFEFE 100%);
        border-radius: 0.75rem;
        border: 2px solid #e5e7eb;
        margin-bottom: 0.5rem;
    }

    .admin-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 0.5rem;
        background: linear-gradient(135deg, #984216 0%, #B85624 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .admin-details {
        flex: 1;
        min-width: 0;
    }

    .admin-name {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1f2937;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .admin-role {
        font-size: 0.75rem;
        color: #984216;
        font-weight: 500;
    }

    /* Scrollbar Styling */
    .sidebar-navigation::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar-navigation::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .sidebar-navigation::-webkit-scrollbar-thumb {
        background: #984216;
        border-radius: 3px;
    }

    .sidebar-navigation::-webkit-scrollbar-thumb:hover {
        background: #7d3512;
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
            position: relative;
            height: auto;
        }
        
        .sidebar-title {
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }
        
        .nav-item {
            padding: 0.75rem 0.875rem;
        }

        .admin-info-card {
            padding: 0.75rem;
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

        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .mobile-overlay.active {
            display: block;
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

    // Mobile menu toggle
    function toggleMobileMenu() {
        const sidebar = document.querySelector('.sidebar-navigation');
        const overlay = document.querySelector('.mobile-overlay');
        
        if (sidebar) {
            sidebar.classList.toggle('mobile-open');
        }
        
        if (overlay) {
            overlay.classList.toggle('active');
        }
    }

    // Close mobile menu when clicking overlay
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('mobile-overlay')) {
            toggleMobileMenu();
        }
    });
</script>