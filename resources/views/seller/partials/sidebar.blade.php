<aside class="fixed left-0 top-0 w-64 h-full bg-white shadow-lg p-6">

    <h2 class="font-bold text-xl mb-6">{{ auth()->user()->store->name ?? 'My Store' }}</h2>

    <nav class="space-y-3">
        <a href="{{ route('seller.dashboard') }}" class="block hover:text-sweet-500">Dashboard</a>
        <a href="{{ route('seller.products.index') }}" class="block hover:text-sweet-500">My Products</a>
        <a href="{{ route('seller.categories.index') }}" class="block hover:text-sweet-500">Categories</a>
        <a href="{{ route('seller.orders.index') }}" class="block hover:text-sweet-500">Orders</a>
        <a href="{{ route('seller.store.profile') }}" class="block hover:text-sweet-500">Store Profile</a>
        <a href="{{ route('seller.balance.index') }}" class="block hover:text-sweet-500">Balance</a>
        <a href="{{ route('seller.withdrawal.index') }}" class="block hover:text-sweet-500">Withdraw</a>

        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="text-red-500">Logout</button>
        </form>
    </nav>

</aside>
