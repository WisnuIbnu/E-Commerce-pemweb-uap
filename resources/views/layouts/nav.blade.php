<style>
.navbar {
    background: var(--white);
    box-shadow: var(--shadow-md);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.navbar-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--spacing-md) 0;
}

.navbar-brand {
    font-size: 28px;
    font-weight: 700;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
}

.brand-icon {
    font-size: 32px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

.navbar-menu {
    display: flex;
    align-items: center;
    gap: var(--spacing-lg);
}

.navbar-link {
    color: var(--dark);
    text-decoration: none;
    font-weight: 500;
    font-size: 15px;
    transition: color 0.2s;
    position: relative;
}

.navbar-link::after {
    content: '';
    position: absolute;
    bottom: -4px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--primary);
    transition: width 0.2s;
}

.navbar-link:hover::after {
    width: 100%;
}

.navbar-link:hover {
    color: var(--primary);
}

.navbar-cart {
    position: relative;
    display: flex;
    align-items: center;
    gap: 4px;
}

.cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: var(--danger);
    color: var(--white);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 600;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

.user-menu {
    position: relative;
}

.user-button {
    display: flex;
    align-items: center;
    gap: var(--spacing-xs);
    cursor: pointer;
    padding: 8px 12px;
    border-radius: var(--radius-md);
    transition: background 0.2s;
    background: none;
    border: none;
    font-size: 14px;
    color: var(--dark);
}

.user-button:hover {
    background: var(--light-gray);
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: var(--spacing-sm);
    background: var(--white);
    border-radius: var(--radius-md);
    box-shadow: var(--shadow-lg);
    min-width: 220px;
    display: none;
    animation: slideDown 0.2s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-menu.show {
    display: block;
}

.dropdown-item {
    display: block;
    padding: 12px var(--spacing-md);
    color: var(--dark);
    text-decoration: none;
    transition: background 0.2s;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.dropdown-item:hover {
    background: var(--light-gray);
    color: var(--primary);
}

.dropdown-divider {
    height: 1px;
    background: var(--border);
    margin: var(--spacing-xs) 0;
}

/* Mobile Menu */
.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    font-size: 28px;
    cursor: pointer;
    color: var(--dark);
    padding: 4px;
}

@media (max-width: 768px) {
    .navbar-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--white);
        flex-direction: column;
        align-items: stretch;
        padding: var(--spacing-md);
        box-shadow: var(--shadow-lg);
    }
    
    .navbar-menu.show {
        display: flex;
    }
    
    .navbar-link {
        padding: 12px;
    }
    
    .mobile-menu-btn {
        display: block;
    }
    
    .navbar-brand {
        font-size: 24px;
    }
}
</style>

<nav class="navbar">
    <div class="container navbar-container">
        <!-- Brand -->
        <a href="{{ route('home') }}" class="navbar-brand">
            <span class="brand-icon">🛍️</span>
            <span>DrizStuff</span>
        </a>

        <!-- Mobile Menu Button -->
        <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
            ☰
        </button>

        <!-- Desktop Menu -->
        <div class="navbar-menu" id="navbarMenu">
            <a href="{{ route('home') }}" class="navbar-link">🏠 Home</a>
            
            @auth
                @if(auth()->user()->store && auth()->user()->store->is_verified)
                    <a href="{{ route('seller.dashboard') }}" class="navbar-link">📊 My Store</a>
                @endif
                
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="navbar-link">⚙️ Admin</a>
                @endif
                
                <!-- Cart -->
                <a href="{{ route('cart.index') }}" class="navbar-cart navbar-link">
                    <span>🛒</span>
                    <span>Cart</span>
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="cart-badge">{{ count(session('cart')) }}</span>
                    @endif
                </a>
                
                <!-- User Menu -->
                <div class="user-menu">
                    <button class="user-button" onclick="toggleDropdown()">
                        <div class="user-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <span>{{ auth()->user()->name }}</span>
                        <span style="font-size: 10px;">▼</span>
                    </button>
                    
                    <div class="dropdown-menu" id="userDropdown">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item">
                            <span>👤</span> <span>My Profile</span>
                        </a>
                        <a href="{{ route('transactions.index') }}" class="dropdown-item">
                            <span>📦</span> <span>My Orders</span>
                        </a>
                        @if(!auth()->user()->store)
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('seller.register') }}" class="dropdown-item" style="color: var(--primary);">
                                <span>🏪</span> <span>Become a Seller</span>
                            </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                            @csrf
                            <button type="submit" class="dropdown-item" style="width: 100%; background: none; border: none; cursor: pointer; color: var(--danger);">
                                <span>🚪</span> <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline btn-sm">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
        </div>
    </div>
</nav>

<script>
function toggleDropdown() {
    const dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('show');
}

function toggleMobileMenu() {
    const menu = document.getElementById('navbarMenu');
    menu.classList.toggle('show');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const userMenu = document.querySelector('.user-menu');
    const dropdown = document.getElementById('userDropdown');
    
    if (userMenu && !userMenu.contains(event.target)) {
        if (dropdown) {
            dropdown.classList.remove('show');
        }
    }
});

// Close mobile menu when clicking a link
document.querySelectorAll('.navbar-link').forEach(link => {
    link.addEventListener('click', function() {
        const menu = document.getElementById('navbarMenu');
        if (window.innerWidth <= 768) {
            menu.classList.remove('show');
        }
    });
});
</script>