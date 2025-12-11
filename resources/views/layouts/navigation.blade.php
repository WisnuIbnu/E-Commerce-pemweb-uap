<nav class="w-full border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-md sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center gap-6">

        {{-- LEFT: LOGO --}}
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="https://i.pinimg.com/1200x/3a/fb/c7/3afbc774b594137b62c78e05ed5e6ba1.jpg"
                 class="w-11 h-11 rounded-xl shadow-[0_0_25px_rgba(56,189,248,0.5)] object-cover"
                 alt="logo">
            <span class="text-xl font-semibold tracking-tight text-sky-300">
                ElecTrend
            </span>
        </a>

        {{-- MIDDLE NAVIGATION --}}
        <ul class="hidden md:flex gap-6 text-sm font-medium text-slate-200">

            {{-- =============== CUSTOMER =============== --}}
            @auth
                @if(Auth::user()->role === 'customer')
                    <li>
                        <a href="{{ route('products') }}"
                           class="nav-link {{ request()->routeIs('products') ? 'nav-link-active' : '' }}">
                            All Products
                        </a>
                    </li>
                    <li>
                        <a href="{{ url('/products/category/1') }}"
                           class="nav-link {{ request()->is('products/category/*') ? 'nav-link-active' : '' }}">
                            By Category
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.history') }}"
                           class="nav-link {{ request()->routeIs('transaction.history') ? 'nav-link-active' : '' }}">
                            Transaction History
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('cart.index') }}"
                           class="nav-link {{ request()->routeIs('cart.index') ? 'nav-link-active' : '' }}">
                            My Cart
                        </a>
                    </li>
                @endif

                {{-- =============== SELLER =============== --}}
                @if(Auth::user()->role === 'seller')
                    <li><a href="{{ route('seller.store') }}" class="nav-link">Store Profile</a></li>
                    <li><a href="/seller/products" class="nav-link">Manage Products</a></li>
                    <li><a href="{{ route('seller.orders') }}" class="nav-link">Orders</a></li>
                    <li><a href="{{ route('seller.balance') }}" class="nav-link">Balance</a></li>
                    <li><a href="{{ route('seller.withdraw') }}" class="nav-link">Withdrawal</a></li>
                @endif

                {{-- =============== ADMIN =============== --}}
                @if(Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.stores') }}" class="nav-link">Store Verification</a></li>
                    <li><a href="{{ route('admin.users') }}" class="nav-link">User Management</a></li>
                @endif
            @endauth
        </ul>

        {{-- RIGHT: USER DROPDOWN --}}
        <div class="flex items-center space-x-4 text-sm font-medium">
            @auth
                <div class="relative">
                    <button onclick="toggleDropdown()"
                            class="flex items-center space-x-2 text-slate-200 hover:text-sky-300 transition-colors">
                        <span class="truncate max-w-[130px]">
                            {{ Auth::user()->name }}
                        </span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div id="userDropdown"
                         class="hidden absolute right-0 top-full mt-2 w-44 bg-slate-900 border border-slate-700 rounded-lg shadow-xl py-2 z-50">
                        <a href="/profile"
                           class="block px-4 py-2 text-slate-200 hover:bg-slate-800 hover:text-sky-300 text-sm">
                            Profile
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-slate-200 hover:bg-slate-800 hover:text-red-300 text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @endauth

            @guest
                <a href="/login" class="nav-link">
                    Login
                </a>
                <a href="/register"
                   class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-sky-500 to-blue-600 
                          text-white shadow-[0_10px_25px_rgba(37,99,235,0.65)]
                          hover:from-sky-400 hover:to-blue-500 transition-colors text-sm">
                    Register
                </a>
            @endguest
        </div>

    </div>
</nav>

<style>
    .nav-link {
        @apply text-slate-300 hover:text-sky-300 transition-colors;
    }
    .nav-link-active {
        @apply text-sky-300;
    }
</style>

<script>
    function toggleDropdown() {
        let menu = document.getElementById('userDropdown');
        menu.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        let dropdown = document.getElementById('userDropdown');
        let button = e.target.closest('button');

        if (dropdown && !dropdown.contains(e.target) && !button) {
            dropdown.classList.add('hidden');
        }
    });
</script>
