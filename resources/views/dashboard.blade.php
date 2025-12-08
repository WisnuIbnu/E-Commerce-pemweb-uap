<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Welcome Card -->
            <div class="bg-blue-50 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
                <h3 class="text-2xl font-bold mb-2 text-blue-800">Welcome, {{ Auth::user()->name }}!</h3>
                <p class="text-blue-700">
                    @if(Auth::user()->role === 'customer')
                        Manage your electronics shopping efficiently. Click a feature below to get started.
                    @elseif(Auth::user()->role === 'seller')
                        Manage your store efficiently. Click a feature below to get started.
                    @else
                        Manage the platform efficiently. Click a feature below to get started.
                    @endif
                </p>
            </div>

            <!-- Feature Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- CUSTOMER DASHBOARD --}}
                @if(Auth::user()->role === 'customer')
                    <x-dashboard-card 
                        title="Browse All Products" 
                        color="blue" 
                        icon="tv" 
                        link="{{ route('products') }}">
                        Explore all electronics available in the store.
                    </x-dashboard-card>

                    <x-dashboard-card 
                        title="Browse by Category" 
                        color="blue" 
                        icon="tablet-alt" 
                        link="{{ route('product.category', 1) }}">
                        Filter electronics by category.
                    </x-dashboard-card>

                    <x-dashboard-card 
                        title="Checkout" 
                        color="blue" 
                        icon="credit-card" 
                        link="{{ route('cart.index') }}">
                        Complete your purchase for selected products.
                    </x-dashboard-card>

                    <x-dashboard-card 
                        title="Transaction History" 
                        color="blue" 
                        icon="receipt" 
                        link="{{ route('transaction.history') }}">
                        View your past purchases and details.
                    </x-dashboard-card>
                @endif

                {{-- SELLER DASHBOARD --}}
                @if(Auth::user()->role === 'seller')
                    <x-dashboard-card title="Store Profile" color="blue" icon="store" link="{{ route('seller.store') }}">
                        Create or manage your store profile.
                    </x-dashboard-card>

                    <x-dashboard-card title="Order Management" color="blue" icon="shopping-basket" link="{{ route('seller.orders') }}">
                        View and update incoming orders.
                    </x-dashboard-card>

                    <x-dashboard-card title="Balance & Withdraw" color="blue" icon="wallet" link="{{ route('seller.balance') }}">
                        Check your balance and request withdrawals.
                    </x-dashboard-card>

                    <x-dashboard-card title="Manage Products" color="blue" icon="tv" link="{{ route('products.index') }}">
                        Add, update, or delete products.
                    </x-dashboard-card>

                    <x-dashboard-card title="Manage Categories" color="blue" icon="tags" link="{{ route('categories.index') }}">
                        Organize your products into categories.
                    </x-dashboard-card>
                @endif

                {{-- ADMIN DASHBOARD --}}
                @if(Auth::user()->role === 'admin')
                    <x-dashboard-card title="Store Verification" color="blue" icon="check-circle" link="{{ route('admin.stores') }}">
                        Verify or reject store applications.
                    </x-dashboard-card>

                    <x-dashboard-card title="User & Store Management" color="blue" icon="users-cog" link="{{ route('admin.users') }}">
                        Manage all users and store profiles.
                    </x-dashboard-card>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
