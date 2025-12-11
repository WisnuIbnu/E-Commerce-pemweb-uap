<x-user-layout title="Transaction Detail">

<div class="container max-w-3xl mx-auto py-8">

    <h1 class="text-3xl font-bold mb-4">Transaction Receipt</h1>

    <div class="bg-white shadow p-6 rounded-lg border">

        <p class="text-gray-600">Kode Transaksi:</p>
        <p class="font-bold text-lg mb-4">{{ $transaction->code }}</p>

        <p class="text-gray-600">Alamat Pengiriman:</p>
        <p class="mb-4">{{ $transaction->address }}, {{ $transaction->city }} ({{ $transaction->postal_code }})</p>

        <p class="text-gray-600">Jenis Pengiriman:</p>
        <p class="mb-4 capitalize">{{ $transaction->shipping_type }}</p>

        <hr class="my-4">

        <h2 class="text-xl font-semibold mb-3">Items</h2>

        @foreach ($transaction->details as $detail)
            <div class="flex justify-between border-b py-2">
                <span>{{ $detail->product->name }} × {{ $detail->qty }}</span>
                <span>Rp {{ number_format($detail->subtotal,0,',','.') }}</span>
            </div>
        @endforeach

        <hr class="my-4">

        <div class="flex justify-between text-gray-600">
            <span>Pajak (10%)</span>
            <span>Rp {{ number_format($transaction->tax,0,',','.') }}</span>
        </div>

        <div class="flex justify-between text-gray-600">
            <span>Ongkir</span>
            <span>Rp {{ number_format($transaction->shipping_cost,0,',','.') }}</span>
        </div>

        <div class="flex justify-between font-bold text-xl mt-2">
            <span>Total</span>
            <span>Rp {{ number_format($transaction->grand_total,0,',','.') }}</span>
        </div>

    </div>

    <a href="{{ route('transactions.index') }}"
       class="mt-6 inline-block bg-sweet-500 text-white px-4 py-2 rounded-lg hover:bg-sweet-600">
        Lihat Riwayat Transaksi
    </a>

</div>

</x-user-layout>
