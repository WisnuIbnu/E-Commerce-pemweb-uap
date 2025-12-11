<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">My Transactions</h2></x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-4 rounded shadow-sm">
                @forelse($transactions as $trx)
                    <a href="{{ route('transactions.show', $trx->id) }}" class="block border-b last:border-b-0 p-3 hover:bg-gray-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="font-medium">Transaction #{{ $trx->code ?? $trx->id }}</div>
                                <div class="text-sm text-gray-500">{{ $trx->created_at->format('d M Y H:i') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold">Rp {{ number_format($trx->grand_total,0,',','.') }}</div>
                                <div class="text-sm text-gray-500">{{ ucfirst($trx->payment_status) }}</div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-gray-500 p-4">You have no transactions yet.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
