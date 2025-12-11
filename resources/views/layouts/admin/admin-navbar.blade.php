<!-- resources/views/layouts/admin/admin-navbar.blade.php -->
<header class="w-full px-12 py-6 flex items-center justify-between bg-white shadow-md">
    {{-- Left: Logo and Title --}}
    <div class="flex items-center space-x-4">
        <img src="{{ asset('icons/iconmpruy-removebg-preview.png') }}"
            class="w-20 h-20 object-contain"
            alt="Logo">
        <h1 class="text-2xl font-semibold">Admin Dashboard</h1>
    </div>

    {{-- Right: Navigation & Logout --}}
    <div class="flex items-center gap-6 ml-auto">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-gray-900 text-sm">Dashboard</a>
        <a href="{{ route('admin.storeVerification') }}" class="text-gray-700 hover:text-gray-900 text-sm">Store Verification</a>
        <a href="{{ route('admin.usersAndStores') }}" class="text-gray-700 hover:text-gray-900 text-sm">Users & Stores</a>
        <a href="{{ route('admin.withdrawals.index') }}" class="text-gray-700 hover:text-gray-900 text-sm">Withdrawals</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="border-2 border-black rounded-full px-4 py-2 text-sm hover:bg-gray-100">
                Logout
            </button>
        </form>
    </div>
</header>
