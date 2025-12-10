<x-app-layout>

    <div class="p-6">

        <h2 class="text-xl font-semibold mb-4">Latest Products</h2>

        <div class="grid grid-cols-4 gap-4">

            @foreach ($products as $product)
                <div class="border rounded p-3">

                    <img
                        src="{{ asset('storage/' . ($product->thumbnail->image ?? 'default.png')) }}"
                        class="w-full h-40 object-cover rounded"
                    >

                    <h3 class="font-semibold mt-2">{{ $product->name }}</h3>
                    <p>Rp {{ number_format($product->price) }}</p>

                    <a href="{{ route('customer.products.show', $product->slug) }}"
                       class="text-blue-600 text-sm mt-2 inline-block">
                        View Product
                    </a>

                </div>
            @endforeach

        </div>

    </div>

</x-app-layout>
