<header class="w-full px-12 py-6 flex items-center justify-between">
    {{-- Left: Logo --}}
    <div class="flex items-center">
        <img src="{{ asset('icons/iconmpruy-removebg-preview.png') }}"
            class="w-20 h-20 object-contain"
            alt="Logo">
    </div>

    {{-- Right: Logout --}}
    <div class="flex items-center gap-6 ml-auto"> {{-- Add ml-auto to push this section to the right --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="border-2 border-black rounded-full px-4 py-2 text-sm">
                Logout
            </button>
        </form>
    </div>
</header>
