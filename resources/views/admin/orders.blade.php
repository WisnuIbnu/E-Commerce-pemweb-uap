<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Manage Orders</h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-8xl mx-auto sm:px-10 lg:px-10 grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            <div class="md:col-span-5">
                <div class="bg-white p-4 rounded-xl shadow">
                    <table class="w-full">
                        <thead class="bg-lunpia-peach">
                            <tr>
                                <th class="p-3 text-left">Order #</th>
                                <th class="p-3 text-left">Customer</th>
                                <th class="p-3 text-left">Total</th>
                                <th class="p-3 text-left">Status</th>
                                <th class="p-3 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                                <tr class="border-b">
                                    <td class="p-3">#{{ $order->id }}</td>
                                    <td class="p-3">{{ $order->user->name ?? '-' }}</td>
                                    <td class="p-3">Rp {{ number_format($order->total,0,',','.') }}</td>
                                    <td class="p-3">{{ $order->status }}</td>
                                    <td class="p-3">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
