<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lunpia-dark">
            {{ __('Orders Management') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-6 gap-6">

            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            <div class="md:col-span-5">

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-lunpia-dark">Order List</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">Order ID</th>
                                    <th class="p-3 text-left">User</th>
                                    <th class="p-3 text-left">Total</th>
                                    <th class="p-3 text-left">Status</th>
                                    <th class="p-3 text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($orders as $order)
                                <tr class="border-t">
                                    <td class="p-3">{{ $order->id }}</td>
                                    <td class="p-3">{{ $order->user->name }}</td>
                                    <td class="p-3">Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                                    <td class="p-3">{{ $order->status }}</td>
                                    <td class="p-3 text-center">
                                        <button class="px-3 py-1 bg-lunpia-red text-white rounded-md hover:bg-red-600">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>