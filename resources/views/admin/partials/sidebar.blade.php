<div class="space-y-4">
    <div class="flex justify-center mb-6">
        <img src="/img/logo.png" class="h-16" alt="">
    </div>

    <nav class="space-y-1">

        <a href="{{ route('admin.dashboard') }}"
           class="block px-4 py-2 rounded-lg 
           {{ request()->routeIs('admin.dashboard') ? 'bg-lunpia-yellow text-lunpia-dark font-semibold' : 'hover:bg-gray-100' }}">
            Dashboard
        </a>

        <a href="{{ route('admin.users') }}"
           class="block px-4 py-2 rounded-lg 
           {{ request()->routeIs('admin.users') ? 'bg-lunpia-yellow text-lunpia-dark font-semibold' : 'hover:bg-gray-100' }}">
            Users
        </a>

        <a href="{{ route('admin.sellers') }}"
           class="block px-4 py-2 rounded-lg 
           {{ request()->routeIs('admin.sellers') ? 'bg-lunpia-yellow text-lunpia-dark font-semibold' : 'hover:bg-gray-100' }}">
            Sellers
        </a>

        <a href="{{ route('admin.products') }}"
           class="block px-4 py-2 rounded-lg 
           {{ request()->routeIs('admin.products') ? 'bg-lunpia-yellow text-lunpia-dark font-semibold' : 'hover:bg-gray-100' }}">
            Products
        </a>

        <a href="{{ route('admin.orders') }}"
           class="block px-4 py-2 rounded-lg 
           {{ request()->routeIs('admin.orders') ? 'bg-lunpia-yellow text-lunpia-dark font-semibold' : 'hover:bg-gray-100' }}">
            Orders
        </a>

    </nav>
</div>
