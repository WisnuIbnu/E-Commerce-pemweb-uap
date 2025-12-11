<x-seller-layout title="Saldo">

<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Saldo Toko</h1>

    <div class="bg-white p-6 rounded shadow">
        <p class="text-gray-600">Saldo saat ini</p>
        <p class="text-3xl font-bold mt-2">Rp {{ number_format($balance,0,',','.') }}</p>

        <a href="{{ route('seller.wallet.history') }}" class="inline-block mt-4 text-sweet-500">Lihat Riwayat</a>
    </div>
</div>

</x-seller-layout>
