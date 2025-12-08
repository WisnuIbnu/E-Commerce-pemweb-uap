{{-- resources/views/transactions/index.blade.php --}}
<x-app-layout>
    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-100 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-2xl font-semibold mb-4">Riwayat Transaksi</h1>

            @if($transactions->isEmpty())
                <p class="text-sm text-gray-600">Belum ada transaksi.</p>
            @else
                <div class="bg-white shadow-sm rounded-lg p-4">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="border-b">
                                    <th class="px-3 py-2 text-left">Kode</th>
                                    <th class="px-3 py-2 text-left">Tanggal</th>
                                    <th class="px-3 py-2 text-right">Total</th>
                                    <th class="px-3 py-2 text-center">Status</th>
                                    <th class="px-3 py-2 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transactions as $transaction)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">
                                            {{ $transaction->code ?? ('#'.$transaction->id) }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $transaction->created_at?->format('d-m-Y H:i') }}
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <span class="{{ $transaction->status_badge_class }}">
                                                {{ $transaction->status_label }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <a
                                                href="{{ route('transactions.show', $transaction->id) }}"
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-md bg-indigo-600 text-white hover:bg-indigo-700"
                                            >
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $transactions->links() }}
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
