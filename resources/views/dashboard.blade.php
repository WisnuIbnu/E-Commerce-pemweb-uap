<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lunpia-dark leading-tight">
            {{ __('Dashboard Lunpia Snack') }}
        </h2>
    </x-slot>

    <div class="py-10 bg-lunpia-cream min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="bg-lunpia-peach shadow-lg rounded-2xl p-8 flex items-center gap-8 mb-10">
                <img src="/images/logo.png" alt="Lunpia Snack" class="w-40 drop-shadow-lg">
                <div>
                    <h1 class="text-3xl font-bold text-lunpia-red">Selamat Datang di Lunpia Snack!</h1>
                    <p class="text-lunpia-dark mt-2 text-lg">Kelola produk, pesanan, dan pelanggan dengan mudah.</p>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-lunpia-dark mb-2">Total Produk</h3>
                    <p class="text-3xl font-bold text-lunpia-red">42</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-lunpia-dark mb-2">Total Pesanan</h3>
                    <p class="text-3xl font-bold text-lunpia-red">129</p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                    <h3 class="text-lg font-semibold text-lunpia-dark mb-2">Pelanggan Terdaftar</h3>
                    <p class="text-3xl font-bold text-lunpia-red">87</p>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
