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
    {{-- icon love --}}
    <button class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
        <img src="{{ asset('icons/love.jpg') }}" class="w-5 h-5" alt="love">
    </button>

    {{-- icon bag --}}
    <button class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
        <img src="{{ asset('icons/bag.png') }}" class="w-5 h-5" alt="bag">
    </button>

    @auth
        {{-- Kalau SUDAH login: icon profile + Logout --}}
        <a href="{{ route('profile.edit') }}"
           class="border-2 border-black rounded-full w-10 h-10 flex items-center justify-center">
            <img src="{{ asset('icons/profile.png') }}" class="w-5 h-5" alt="profile">
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="border-2 border-black rounded-full px-4 py-2 text-sm">
                Logout
            </button>
        </form>
    @else
        {{-- Kalau BELUM login: Login | Daftar --}}
        <a href="{{ route('login') }}" class="text-sm hover:underline">Login</a>
        <span>|</span>
        <a href="{{ route('register') }}" class="text-sm hover:underline">Daftar</a>
    @endauth
</div>

</header>
