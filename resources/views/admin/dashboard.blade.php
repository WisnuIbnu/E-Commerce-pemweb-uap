<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lunpia-dark leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-8xl mx-auto sm:px-10 lg:px-10 grid grid-cols-1 md:grid-cols-6 gap-6">

            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            <div class="md:col-span-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-sm font-medium text-lunpia-dark">Total Users</h3>
                        <p class="text-3xl font-bold text-lunpia-red">{{ $totalUsers }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-sm font-medium text-lunpia-dark">Total Sellers</h3>
                        <p class="text-3xl font-bold text-lunpia-red">{{ $totalSellers }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-sm font-medium text-lunpia-dark">Total Products</h3>
                        <p class="text-3xl font-bold text-lunpia-red">{{ $totalProducts }}</p>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow">
                        <h3 class="text-sm font-medium text-lunpia-dark">Total Orders</h3>
                        <p class="text-3xl font-bold text-lunpia-red">{{ $totalOrders }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3 class="text-lg font-semibold text-lunpia-dark mb-4">Recent Orders</h3>
                    <p class="text-sm text-lunpia-dark">(List sample atau link ke orders page)</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
