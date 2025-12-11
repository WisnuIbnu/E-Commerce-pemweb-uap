<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order History') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">

                @if($transactions->isEmpty())
                    <p class="text-gray-600">You have no transactions yet.</p>
                @else
                    <div class="space-y-4">
                        @foreach($transactions as $t)
                            <div class="border p-4 rounded flex justify-between items-center">

                                <div>
                                    <div class="font-semibold text-lg">
                                        Transaction #{{ $t->id }}
                                    </div>

                                    <div class="text-gray-500 text-sm">
                                        Store: {{ $t->store->name ?? '-' }}
                                    </div>

                                    <div class="text-gray-500 text-sm">
                                        Total: <span class="font-bold">Rp {{ number_format($t->grand_total,0,',','.') }}</span>
                                    </div>

                                    <div class="text-gray-500 text-sm">
                                        Status: {{ ucfirst($t->payment_status) }}
                                    </div>
                                </div>

                                <a href="{{ route('transactions.show', $t->id) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded">
                                    View Details
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
