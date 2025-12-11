@php
    use App\Models\Store;

    $storeExists = false;

    if (auth()->check() && auth()->user()->role === 'member') {
        $storeExists = Store::where('user_id', auth()->id())->exists();
    }
@endphp

<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- LOGO --}}
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <img src="{{ asset('logo/logo-landscape.png') }}" class="h-8 object-contain">
            </a>

            {{-- MAIN MENU --}}
            <div class="hidden md:flex gap-6 text-[15px] font-medium text-textdark">

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-sweet-400">Dashboard</a>
                    <a href="{{ route('admin.stores.index') }}" class="hover:text-sweet-400">Stores</a>
                    <a href="{{ route('admin.users.index') }}" class="hover:text-sweet-400">Users</a>
                @else
                    <a href="{{ route('landing') }}" class="hover:text-sweet-400">Home</a>
                    <a href="{{ route('categories.index') }}" class="hover:text-sweet-400">Categories</a>
                    <a href="{{ route('products.index') }}" class="hover:text-sweet-400">Products</a>
                @endif

            </div>

            {{-- RIGHT MENU --}}
            <div class="hidden md:flex items-center gap-4">

                {{-- CART --}}
                @auth
                    @if(in_array(auth()->user()->role, ['member','seller']))
                        <a href="{{ route('cart.index') }}">
                            <svg class="w-7 h-7 text-textdark hover:text-sweet-400 transition"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 
                                      13l1.293 5.293a1 1 0 01-.948 1.207H5a1 
                                      1 0 01-1-1m4 0h6m0 0l1.293-5.293M17 
                                      18a2 2 0 11-4 0m6 0a2 2 0 11-4 0" />
                            </svg>
                        </a>
                    @endif
                @endauth

                {{-- ROLE BUTTONS --}}
                @auth

                    {{-- MEMBER --}}
                    @if(auth()->user()->role === 'member')

                        @if($storeExists)
                            {{-- Sudah punya toko → My Store --}}
                            <a href="{{ route('seller.dashboard') }}"
                               class="px-4 py-2 border border-sweet-400 text-sweet-400 rounded-lg hover:bg-sweet-50">
                                My Store
                            </a>
                        @else
                            {{-- Belum punya → ke Form Register Toko --}}
                            <a href="{{ route('seller.store.register-form') }}"
                               class="px-4 py-2 border border-sweet-400 text-sweet-400 rounded-lg hover:bg-sweet-50">
                                Become a Seller
                            </a>
                        @endif

                    @endif

                    {{-- SELLER --}}
                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}"
                           class="px-4 py-2 border border-sweet-400 text-sweet-400 rounded-lg hover:bg-sweet-50">
                            My Store
                        </a>
                    @endif

                @else

                    {{-- GUEST --}}
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 bg-sweet-400 text-white rounded-lg hover:bg-sweet-500">Login</a>

                    <a href="{{ route('register') }}"
                       class="px-4 py-2 border border-sweet-400 text-sweet-400 rounded-lg hover:bg-sweet-50">
                        Register
                    </a>

                @endauth

                {{-- PROFILE DROPDOWN --}}
                @auth
                    <div x-data="{ open: false }" class="relative">

                        <button @click="open = !open"
                            class="px-4 py-2 bg-sweet-400 text-white rounded-lg hover:bg-sweet-500">
                            {{ auth()->user()->name }}
                        </button>

                        <div x-show="open" @click.away="open = false"
                             class="absolute right-0 mt-2 w-44 bg-white shadow-lg rounded-lg py-2">

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm hover:bg-softgray">Profile</a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-softgray">
                                    Logout
                                </button>
                            </form>

                        </div>

                    </div>
                @endauth

            </div>

            {{-- MOBILE MENU BUTTON --}}
            <div class="md:hidden">
                <button onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-7 h-7 text-textdark" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>

        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 mt-2">
        <div class="flex flex-col gap-3 text-textdark">

            @auth

                {{-- ADMIN --}}
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="py-2 border-b">Dashboard</a>
                    <a href="{{ route('admin.stores.index') }}" class="py-2 border-b">Stores</a>
                    <a href="{{ route('admin.users.index') }}" class="py-2 border-b">Users</a>

                @else

                    <a href="{{ route('landing') }}" class="py-2 border-b">Home</a>
                    <a href="{{ route('categories.index') }}" class="py-2 border-b">Categories</a>
                    <a href="{{ route('products.index') }}" class="py-2 border-b">Products</a>

                    {{-- MEMBER --}}
                    @if(auth()->user()->role === 'member')
                        @if($storeExists)
                            <a href="{{ route('seller.dashboard') }}" class="py-2 border-b">My Store</a>
                        @else
                            <a href="{{ route('seller.store.register-form') }}" class="py-2 border-b">Become a Seller</a>
                        @endif
                    @endif

                    {{-- SELLER --}}
                    @if(auth()->user()->role === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="py-2 border-b">My Store</a>
                    @endif

                    @if(in_array(auth()->user()->role, ['member','seller']))
                        <a href="{{ route('cart.index') }}" class="py-2 border-b">Cart</a>
                    @endif

                @endif

                <a href="{{ route('profile.edit') }}" class="py-2 border-b">Profile</a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="py-2 text-left text-red-500">Logout</button>
                </form>

            @else
                <a href="{{ route('landing') }}" class="py-2 border-b">Home</a>
                <a href="{{ route('categories.index') }}" class="py-2 border-b">Categories</a>
                <a href="{{ route('products.index') }}" class="py-2 border-b">Products</a>
                <a href="{{ route('login') }}" class="py-2 border-b">Login</a>
                <a href="{{ route('register') }}" class="py-2 border-b">Register</a>
            @endauth

        </div>
    </div>
</nav>
