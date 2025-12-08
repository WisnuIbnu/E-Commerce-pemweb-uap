<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Transaction Detail') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
            <h3 class="font-bold text-xl mb-2">Transaction #{{ $transaction->id }}</h3>
            <p class="text-gray-600">Date: {{ $transaction->created_at->format('d M Y H:i') }}</p>
            <p class="text-blue-700 font-semibold">Total: ${{ number_format($transaction->total,2) }}</p>

            <h4 class="font-bold mt-4 mb-2">Products:</h4>
            <div class="space-y-2">
                @foreach($transaction->details as $detail)
                    <div class="border p-2 rounded flex justify-between items-center">
                        <div>
                            <p class="font-semibold">{{ $detail->product->name ?? 'Product deleted' }}</p>
                            <p class="text-gray-600">Store: {{ $detail->product->store->name ?? 'Deleted' }}</p>
                            <p class="text-gray-600">Quantity: {{ $detail->quantity }}</p>
                        </div>
                        <p class="text-blue-700 font-semibold">${{ number_format($detail->subtotal,2) }}</p>
                    </div>
                @endforeach
            </div>

            <a href="{{ route('transaction.history') }}" class="inline-block mt-4 text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                Back to Transactions
            </a>
        </div>
    </div>
</x-app-layout>
