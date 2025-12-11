<x-seller-layout title="Dashboard Penjual">

<div class="max-w-6xl mx-auto p-8">
    <h1 class="text-3xl font-bold mb-6">Dashboard Penjual</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="p-6 bg-white rounded shadow">
            <h3 class="font-semibold">Toko</h3>
            <p class="text-2xl mt-2">{{ $store->name ?? '-' }}</p>
        </div>

        <div class="p-6 bg-white rounded shadow">
            <h3 class="font-semibold">Produk</h3>
            <p class="text-2xl mt-2">{{ $totalProducts }}</p>
        </div>

        <div class="p-6 bg-white rounded shadow">
            <h3 class="font-semibold">Pesanan</h3>
            <p class="text-2xl mt-2">{{ $ordersCount }}</p>
        </div>

    </div>
</div>

</x-seller-layout>
