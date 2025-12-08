<header class="w-full px-12 py-6 flex items-center justify-between">

    {{-- Left: Logo --}}
    <div class="flex items-center">
        <img src="{{ asset('icons/iconmpruy-removebg-preview.png') }}"
             class="w-20 h-20 object-contain"
             alt="Logo">
    </div>

    {{-- Center Menu --}}
    <nav class="flex gap-12 text-gray-700 text-base">
        <a href="{{ route('dashboard') }}"
           class="hover:text-black {{ request()->routeIs('dashboard') ? 'font-semibold' : '' }}">
            Home
        </a>
        <a href="{{ route('products') }}"
           class="hover:text-black {{ request()->routeIs('products') ? 'font-semibold' : '' }}">
            Products
        </a>
        <a href="{{ route('history') }}"
           class="hover:text-black {{ request()->routeIs('history') ? 'font-semibold' : '' }}">
            History
        </a>
    </nav>

    {{-- Right Icons --}}
    <div class="flex items-center gap-6">
        {{-- Icon Bag --}}
        <button class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
            <img src="{{ asset('icons/checkout.png') }}" class="w-5 h-5" alt="bag">
        </button>

        @auth
            {{-- If user is a seller, show the Seller Dashboard link --}}
            @if(Auth::user()->role === 'seller')
                <a href="{{ route('seller.dashboard') }}" class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
                    <img src="{{ asset('icons/store.png') }}" class="w-5 h-5" alt="seller dashboard">
                </a>
            @endif

            {{-- Icon Profile --}}
            <a href="{{ route('profile.edit') }}"
               class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
                <img src="{{ asset('icons/profile.png') }}" class="w-5 h-5" alt="profile">
            </a>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="border-2 border-black rounded-full px-4 py-2 text-sm">
                    Logout
                </button>
            </form>
        @else
            {{-- If not logged in, show login and register links --}}
            <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
            <span>|</span>
            <a href="{{ route('register') }}" class="text-sm hover:underline">Daftar</a>
        @endauth
    </div>

</header>