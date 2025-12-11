<x-app-layout>

    {{-- HEADER GRADIENT (WIDTH SAMA) --}}
    <div class="bg-gray-900 pt-6">
        <div class="max-w-7xl mx-auto px-6">
            <div class="relative rounded-2xl overflow-hidden bg-gradient-to-r from-blue-700 to-blue-500 py-8 shadow-xl">
                <div class="relative px-4 sm:px-6">
                    <div class="flex items-center gap-3">
                        <span class="text-3xl">💰</span>
                        <h2 class="text-2xl font-semibold text-white">
                            Store Balance
                        </h2>
                    </div>
                    <p class="text-sm text-blue-100 mt-2">
                        Track and monitor your ElecTrend earnings.
                    </p>
                </div>

                <div class="pointer-events-none absolute top-3 right-6 w-32 h-32 bg-blue-300 bg-opacity-20 rounded-full blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-6 left-0 w-40 h-40 bg-white bg-opacity-10 rounded-full blur-2xl"></div>
            </div>
        </div>
    </div>

    <div class="py-10 bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-8">

            {{-- CURRENT BALANCE BOX --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-100 mb-6">Current Balance</h3>

                <div class="text-center py-8 bg-gradient-to-r from-green-500 to-green-400 text-white rounded-2xl shadow-lg">
                    <p class="text-sm md:text-base">Available Earnings</p>
                    <p class="text-4xl md:text-5xl font-extrabold mt-2 drop-shadow">
                        Rp {{ number_format($balance->balance ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            {{-- BALANCE HISTORY --}}
            <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-3xl p-6 md:p-8">
                <h3 class="text-2xl font-bold text-gray-100 mb-6">Balance History</h3>

                @if($histories->isEmpty())
                    <p class="text-gray-400 text-center">No balance history available.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-200">
                            <thead class="bg-gray-900 border-b border-gray-800 text-xs uppercase tracking-wide text-gray-400">
                                <tr>
                                    <th class="px-4 py-3">Date</th>
                                    <th class="px-4 py-3">Description</th>
                                    <th class="px-4 py-3">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($histories as $item)
                                    <tr class="border-b border-gray-800 hover:bg-gray-800 transition-colors">
                                        <td class="px-4 py-3 text-gray-300">
                                            {{ $item->created_at->format('d M Y H:i') }}
                                        </td>

                                        <td class="px-4 py-3 text-gray-200">
                                            {{ $item->remarks ?? $item->description ?? '-' }}
                                        </td>

                                        <td class="px-4 py-3 font-semibold
                                            {{ $item->amount > 0 ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $item->amount > 0 ? '+' : '-' }}
                                            Rp {{ number_format(abs($item->amount), 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="mt-4">
                            {{ $histories->links() }}
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-app-layout>
