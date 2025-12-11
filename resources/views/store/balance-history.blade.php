<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Store Balance') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-medium">Current Store Balance</h3>
                Rp. {{ number_format($balance->amount, 2) }}
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mt-6">
                <h3 class="text-lg font-medium">Balance History</h3>
                <table class="min-w-full mt-4 border-collapse">
                    <thead>
                        <tr>
                            <th class="border px-4 py-2">Type</th>
                            <th class="border px-4 py-2">Reference</th>
                            <th class="border px-4 py-2">Amount</th>
                            <th class="border px-4 py-2">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($history as $p)
                            <tr>
                                <td class="border px-4 py-2">
                                    @if ($p->type == 'income') Income
                                    @else Withdraw
                                    @endif
                                </td>
                                <td class="border px-4 py-2">Rp. {{ number_format($p->amount, 2) }}</td>
                                <td class="border px-4 py-2">{{ $p->reference_type }}: {{ $p->reference_id }}</td>
                                <td class="border px-4 py-2">{{ $p->remarks }}</td>
                            </tr>
                    </tbody>
                </table>

                @empty No balance history found.
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
