<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Transaction History') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="space-y-4">
            @forelse($transactions as $transaction)
                <div class="bg-white shadow-sm rounded-lg p-4 flex justify-between items-center">
                    <div>
                        <p class="font-semibold">Transaction #{{ $transaction->id }}</p>
                        <p class="text-gray-600">Date: {{ $transaction->created_at->format('d M Y H:i') }}</p>
                        <p class="text-gray-600">Total: ${{ number_format($transaction->total,2) }}</p>
                    </div>
                    <a href="{{ route('transaction.detail', $transaction->id) }}" class="text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                        View Details
                    </a>
                </div>
            @empty
                <p class="text-gray-600">You have no transactions yet.</p>
            @endforelse

            <!-- Pagination -->
            <div class="mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
