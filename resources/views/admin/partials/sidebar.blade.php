<div class="w-64 bg-white shadow h-screen sticky top-0">
    <div class="p-4 border-b">
        <img src="/images/logo.png" alt="Lunpia" class="w-40 mx-auto">
    </div>

    <nav class="p-4">
        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-lunpia-peach {{ request()->routeIs('admin.dashboard') ? 'bg-lunpia-peach' : '' }}">Dashboard</a>
        <a href="{{ route('admin.users') }}"     class="block py-2 px-3 rounded hover:bg-lunpia-peach {{ request()->routeIs('admin.users') ? 'bg-lunpia-peach' : '' }}">Users</a>
        <a href="{{ route('admin.sellers') }}"   class="block py-2 px-3 rounded hover:bg-lunpia-peach {{ request()->routeIs('admin.sellers') ? 'bg-lunpia-peach' : '' }}">Sellers</a>
        <a href="{{ route('admin.products') }}"  class="block py-2 px-3 rounded hover:bg-lunpia-peach {{ request()->routeIs('admin.products') ? 'bg-lunpia-peach' : '' }}">Products</a>
        <a href="{{ route('admin.orders') }}"    class="block py-2 px-3 rounded hover:bg-lunpia-peach {{ request()->routeIs('admin.orders') ? 'bg-lunpia-peach' : '' }}">Orders</a>
    </nav>
</div>
