<x-user-layout title="Transaction History">

<div class="container max-w-4xl mx-auto py-8">

    <h1 class="text-3xl font-bold mb-6">Riwayat Transaksi</h1>

    <div class="bg-white shadow rounded-lg p-6 border">

        @forelse ($transactions as $trx)
            <div class="flex justify-between border-b py-3">
                <div>
                    <p class="font-semibold">{{ $trx->code }}</p>
                    <p class="text-sm text-gray-600">{{ $trx->created_at->format('d M Y') }}</p>
                </div>

                <a href="{{ route('transactions.show', $trx->id) }}"
                   class="text-sweet-500 hover:underline">
                    Lihat Detail
                </a>
            </div>
        @empty
            <p class="text-gray-600">Belum ada transaksi.</p>
        @endforelse

    </div>

</div>

</x-user-layout>
