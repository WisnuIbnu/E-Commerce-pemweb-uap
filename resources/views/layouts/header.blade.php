<header class="header-main">
    <div class="header-container">
        <div class="header-wrapper">

            <!-- Logo -->
            <a href="/" class="logo">
                <img src="{{ asset('images/puffy-baby-logo.png') }}" alt="PuffyBaby Logo" class="logo-image">
                <span class="logo-text">PuffyBaby</span>
            </a>

            <!-- Desktop Navigation -->
            <nav class="nav-desktop">
                <ul class="nav-menu">
                    <li class="nav-item">
                        <a href="/new-arrivals" class="nav-link">
                            New Arrivals
                            <span class="nav-badge badge-new">New</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Baby Clothing
                            <span class="dropdown-icon">▼</span>
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="/baby-clothing/bodysuit">Bodysuit</a></li>
                                <li><a href="/baby-clothing/pajamas">Pajamas</a></li>
                                <li><a href="/baby-clothing/dress">Dress</a></li>
                                <li><a href="/baby-clothing/set-outfit">Set Outfit</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            Accessories
                            <span class="dropdown-icon">▼</span>
                        </a>
                        <div class="dropdown-menu">
                            <ul>
                                <li><a href="/accessories/hat">Hat</a></li>
                                <li><a href="/accessories/socks">Socks</a></li>
                                <li><a href="/accessories/bibs">Bibs</a></li>
                                <li><a href="/accessories/gloves">Gloves</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="/toys" class="nav-link">
                            Toys
                            <span class="nav-badge badge-hot">Hot</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/clearance-sale" class="nav-link">
                            Clearance Sale
                            <span class="nav-badge badge-sale">Sale</span>
                        </a>
                    </li>
                </ul>
            </nav>

            <!-- Action Buttons -->
            <div class="header-actions">
                <button class="action-btn mobile-menu-btn" id="hamburgerBtn">☰</button>
                <button class="action-btn desktop-action">🔍</button>
                <button class="action-btn desktop-action">🤍</button>
                <!-- User Dropdown -->
                <div class="user-dropdown-wrapper">
                    <button class="action-btn desktop-action user-dropdown-btn">
                        👤
                    </button>

                    <!-- DROPDOWN MENU -->
                    <div class="user-dropdown-menu">
                        @auth
                            <p class="user-name">{{ Auth::user()->name }}</p>

                            <a href="{{ route('profile.edit') }}" class="user-dropdown-link">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="user-dropdown-link logout-btn">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="user-dropdown-link">
                                Login
                            </a>

                            <a href="{{ route('register') }}" class="user-dropdown-link">
                                Register
                            </a>
                        @endauth
                    </div>
                </div>
                <button class="action-btn">🛒</button>
            </div>
        </div>
    </div>
</header>

<!-- Mobile Overlay -->
<div class="mobile-menu-overlay" id="mobileOverlay"></div>

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-header">
        <span class="mobile-menu-title">Menu</span>
        <button class="close-btn" id="closeMenuBtn">×</button>
    </div>

    <ul class="mobile-nav-list">
        <li class="mobile-nav-item">
            <a href="/new-arrivals" class="mobile-nav-link">
                New Arrivals <span class="nav-badge badge-new">New</span>
            </a>
        </li>

        <li class="mobile-nav-item" data-dropdown>
            <a href="#" class="mobile-nav-link">
                Baby Clothing <span class="mobile-dropdown-icon">▼</span>
            </a>
            <div class="mobile-submenu">
                <ul>
                    <li><a href="/baby-clothing/bodysuit">Bodysuit</a></li>
                    <li><a href="/baby-clothing/pajamas">Pajamas</a></li>
                    <li><a href="/baby-clothing/dress">Dress</a></li>
                    <li><a href="/baby-clothing/set-outfit">Set Outfit</a></li>
                </ul>
            </div>
        </li>

        <li class="mobile-nav-item" data-dropdown>
            <a href="#" class="mobile-nav-link">
                Accessories <span class="mobile-dropdown-icon">▼</span>
            </a>
            <div class="mobile-submenu">
                <ul>
                    <li><a href="/accessories/hat">Hat</a></li>
                    <li><a href="/accessories/socks">Socks</a></li>
                    <li><a href="/accessories/bibs">Bibs</a></li>
                    <li><a href="/accessories/gloves">Gloves</a></li>
                </ul>
            </div>
        </li>

        <li class="mobile-nav-item">
            <a href="/toys" class="mobile-nav-link">
                Toys <span class="nav-badge badge-hot">Hot</span>
            </a>
        </li>

        <li class="mobile-nav-item">
            <a href="/clearance-sale" class="mobile-nav-link">
                Clearance Sale <span class="nav-badge badge-sale">Sale</span>
            </a>
        </li>
    </ul>
</div>
