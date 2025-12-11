<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Purchase History</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
    @include('layouts.user.store-navbar')

    {{-- PAGE WRAPPER --}}
    <main class="px-16 py-8">

        {{-- Title + small filter --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Purchase History</h1>
                <p class="text-sm text-gray-500 mt-1">Track all your past orders in one place.</p>
            </div>

            <div class="flex gap-3">
                <button class="border px-4 py-2 rounded-full text-sm hover:bg-gray-100">
                    All
                </button>
                <button class="border px-4 py-2 rounded-full text-sm hover:bg-gray-100">
                    Completed
                </button>
                <button class="border px-4 py-2 rounded-full text-sm hover:bg-gray-100">
                    On Delivery
                </button>
                <button class="border px-4 py-2 rounded-full text-sm hover:bg-gray-100">
                    Canceled
                </button>
            </div>
        </div>

        {{-- HISTORY LIST WRAPPER --}}
        <section class="bg-white/80 backdrop-blur rounded-2xl shadow-sm border border-gray-200 px-6 py-4 space-y-4">

            @forelse ($transactions as $transaction)
                <article class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b last:border-b-0 py-4">

                    {{-- Left: basic info --}}
                    <div class="flex-1">
                        <div class="flex items-center gap-3 text-sm text-gray-500 mb-1">
                            <span class="uppercase tracking-wide">Order #{{ $transaction->id }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-400"></span>
                            <span>{{ $transaction->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <div class="font-semibold text-lg">
                            {{ $transaction->store ? $transaction->store->name : 'Unknown Store' }}
                        </div>
                        <div class="text-sm text-gray-500 mt-1">
                            Shipped to: {{ $transaction->shipping_address ?? 'Address not set' }}
                        </div>
                    </div>

                    {{-- Middle: status + total --}}
                    <div class="flex flex-col items-start md:items-end gap-2 min-w-[150px]">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if ($transaction->status === 'completed') bg-green-100 text-green-700
                            @elseif ($transaction->status === 'shipping') bg-yellow-100 text-yellow-700
                            @elseif ($transaction->status === 'canceled') bg-red-100 text-red-700
                            @else bg-gray-100 text-gray-700 @endif">
                            {{ ucfirst($transaction->status) }}
                        </span>

                        <div class="text-right">
                            <div class="text-xs text-gray-500">Total</div>
                            <div class="text-lg font-semibold">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                        </div>
                    </div>

                    {{-- Right: actions --}}
                    <div class="flex flex-col items-start md:items-end gap-2 min-w-[130px]">
                        <!-- <button class="text-sm underline underline-offset-4 hover:text-black">
                            View Details
                        </button> -->
                        <!-- <button class="text-sm border px-4 py-2 rounded-full hover:bg-gray-100">
                            Buy Again
                        </button> -->
                    </div>

                </article>
            @empty
                <div class="p-8 text-center text-gray-500">
                    You haven't placed any orders yet.
                </div>
            @endforelse

        </section>

    </main>

</body>
</html>
