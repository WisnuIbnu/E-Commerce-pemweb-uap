<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-lunpia-dark leading-tight">
            {{ __('Manage Products') }}
        </h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-5">

                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold mb-4 text-lunpia-dark">Product List</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full border border-gray-200 rounded-lg">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="p-3 text-left">ID</th>
                                    <th class="p-3 text-left">Product Name</th>
                                    <th class="p-3 text-left">Seller</th>
                                    <th class="p-3 text-left">Price</th>
                                    <th class="p-3 text-left">Stock</th>
                                    <th class="p-3 text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($products as $product)
                                <tr class="border-t">
                                    <td class="p-3">{{ $product->id }}</td>
                                    <td class="p-3">{{ $product->name }}</td>
                                    <td class="p-3">{{ $product->seller->name }}</td>
                                    <td class="p-3">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td class="p-3">{{ $product->stock }}</td>
                                    <td class="p-3 text-center">
                                        <button class="px-3 py-1 bg-lunpia-red text-white rounded-md hover:bg-red-600">
                                            Delete
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