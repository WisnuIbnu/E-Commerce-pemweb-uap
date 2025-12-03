<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Admin Dashboard</h2>
    </x-slot>

    <div class="p-6 bg-lunpia-cream min-h-screen">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lunpia-dark text-lg font-semibold">Total Users</h3>
                <p class="text-4xl font-bold text-lunpia-red">{{ $totalUsers }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lunpia-dark text-lg font-semibold">Total Sellers</h3>
                <p class="text-4xl font-bold text-lunpia-red">{{ $totalSellers }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow">
                <h3 class="text-lunpia-dark text-lg font-semibold">Pending Store Verification</h3>
                <p class="text-4xl font-bold text-lunpia-red">8</p>
            </div>
        </div>

    </div>
</x-app-layout>