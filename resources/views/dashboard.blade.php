<x-app-layout>

    {{-- HEADER GRADIENT ELECTREND --}}
    <div class="relative">
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 py-14 shadow-xl">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-5xl font-extrabold text-white drop-shadow">
                    Welcome, {{ Auth::user()->name }} 👋
                </h2>
                <p class="text-blue-100 text-lg mt-3">
                    Your personalized ElecTrend control panel.
                </p>
            </div>
        </div>

        <!-- Decorative circles -->
        <div class="absolute top-5 right-10 w-40 h-40 bg-blue-300/20 rounded-full blur-3xl"></div>
        <div class="absolute -top-10 left-0 w-56 h-56 bg-white/10 rounded-full blur-2xl"></div>
    </div>


    <div class="py-10 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

            <!-- WELCOME BOX -->
            <div class="bg-white/80 backdrop-blur-xl border border-blue-200 shadow-xl sm:rounded-2xl p-10">
                <h3 class="text-3xl font-bold text-blue-900">
                     @if(Auth::user()->role === 'customer')
                        Your Smart Shopping Hub
                    @elseif(Auth::user()->role === 'seller')
                        Your Store Control Center 
                    @else
                        Admin Control Panel
                    @endif
                </h3>

                <p class="mt-4 text-blue-800 text-lg leading-relaxed">
                    @if(Auth::user()->role === 'customer')
                        Explore, Choose, and Enjoy ElecTrend Electronics.
                    @elseif(Auth::user()->role === 'seller')
                       Manage Your ElecTrend Store with Ease.
                    @else
                        Manage users and store verification.
                    @endif
                </p>
            </div>

            <!-- FEATURES GRID -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

                {{-- CUSTOMER DASHBOARD --}}
                @if(Auth::user()->role === 'customer')

                    @component('components.dashboard-card', [
                        'title' => 'Browse All Products',
                        'icon'  => 'tv',
                        'link'  => route('products')
                    ])
                        Explore all electronics available in the store.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Browse by Category',
                        'icon'  => 'layer-group',
                        'link'  => route('product.category', 1)
                    ])
                        Filter electronics by category.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Check Out',
                        'icon'  => 'shopping-cart',
                        'link'  => route('cart.index')
                    ])
                        Complete your purchase for selected products.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Transaction History',
                        'icon'  => 'receipt',
                        'link'  => route('transaction.history')
                    ])
                        View your previous purchases.
                    @endcomponent

                @endif


                {{-- SELLER DASHBOARD --}}
                @if(Auth::user()->role === 'seller')

                    @component('components.dashboard-card', [
                        'title' => 'Store Profile',
                        'icon'  => 'store',
                        'link'  => route('seller.store')
                    ])
                        Create or manage your store profile.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Order Management',
                        'icon'  => 'box',
                        'link'  => route('seller.orders')
                    ])
                        View and process customer orders.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Balance & Withdraw',
                        'icon'  => 'wallet',
                        'link'  => route('seller.balance')
                    ])
                        Check earnings and request withdrawals.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Manage Products',
                        'icon'  => 'tags',
                        'link'  => route('seller.products.index')
                    ])
                        Add, update, or delete products.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'Manage Categories',
                        'icon'  => 'folder-tree',
                        'link'  => route('categories.index')
                    ])
                        Organize products into categories.
                    @endcomponent

                @endif


                {{-- ADMIN DASHBOARD --}}
                @if(Auth::user()->role === 'admin')

                    @component('components.dashboard-card', [
                        'title' => 'Store Verification',
                        'icon'  => 'check-circle',
                        'link'  => route('admin.stores')
                    ])
                        Verify or reject seller store applications.
                    @endcomponent

                    @component('components.dashboard-card', [
                        'title' => 'User & Store Management',
                        'icon'  => 'users-cog',
                        'link'  => route('admin.users')
                    ])
                        Manage users and store data.
                    @endcomponent

                @endif

            </div>
        </div>
    </div>

</x-app-layout>
