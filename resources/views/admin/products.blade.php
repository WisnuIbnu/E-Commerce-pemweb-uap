<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Manage Products</h2>
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
                                <th class="p-3 text-left">Image</th>
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Seller</th>
                                <th class="p-3 text-left">Price</th>
                                <th class="p-3 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                                <tr class="border-b">
                                    <td class="p-3"><img src="{{ $product->image_url }}" alt="" class="w-16"></td>
                                    <td class="p-3">{{ $product->name }}</td>
                                    <td class="p-3">{{ $product->seller->name ?? '-' }}</td>
                                    <td class="p-3">Rp {{ number_format($product->price,0,',','.') }}</td>
                                    <td class="p-3">{{ $product->status ?? 'active' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
