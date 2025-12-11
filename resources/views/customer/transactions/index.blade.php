<x-app-layout>
    {{-- HERO / HEADER --}}
    <x-slot name="header">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 px-6 py-8 shadow-xl">
            <div class="relative z-10 flex flex-col gap-3">
                <div class="inline-flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-2xl">
                        📜
                    </span>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-blue-100">
                            Your Orders
                        </p>
                        <h2 class="font-semibold text-2xl md:text-3xl text-white">
                            Transaction History
                        </h2>
                    </div>
                </div>

                <p class="text-sm md:text-base text-blue-100 max-w-2xl">
                    Lihat riwayat transaksi, detail pesanan, dan status pembayaranmu di satu tempat.
                </p>
            </div>

            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-blue-300/30 blur-3xl"></div>
            <div class="pointer-events-none absolute left-10 -bottom-16 h-48 w-48 rounded-full bg-white/10 blur-3xl"></div>
        </div>
    </x-slot>

    {{-- MAIN CONTENT --}}
    <div class="bg-gray-900 min-h-screen text-gray-100 py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-4">

                @forelse($transactions as $transaction)
                    <div class="bg-gray-900 border border-gray-800 shadow-2xl rounded-2xl p-4 md:p-5 flex justify-between items-center gap-4 hover:border-blue-500 transition-colors">
                        <div>
                            <p class="font-semibold text-gray-100">
                                Transaction #{{ $transaction->code ?? $transaction->id }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                Date: {{ $transaction->created_at->format('d M Y H:i') }}
                            </p>
                            <p class="text-sm text-blue-300 mt-1">
                                Total: Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                            </p>
                            <p class="text-xs mt-1">
                                <span class="uppercase tracking-wide
                                    @if($transaction->payment_status === 'paid')
                                        text-green-400
                                    @else
                                        text-yellow-400
                                    @endif">
                                    {{ $transaction->payment_status }}
                                </span>
                            </p>
                        </div>

                        <a href="{{ route('transaction.detail', $transaction->id) }}"
                           class="shrink-0 inline-flex items-center justify-center bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 rounded-lg text-xs font-medium shadow transition-colors">
                            View Details
                        </a>
                    </div>
                @empty
                    <p class="text-gray-400">
                        You have no transactions yet.
                    </p>
                @endforelse

                {{-- Pagination --}}
                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
