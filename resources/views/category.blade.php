<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ $category->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            <h3 class="text-lg font-semibold mb-4">
                Products in "{{ $category->name }}"
            </h3>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <a href="{{ route('product.show', $product->slug) }}"
                       class="border rounded p-3 bg-white shadow-sm hover:shadow-md transition">

                        @php
                            $img = $product->productImages->first()->image ?? null;
                        @endphp

                        <div class="h-40 bg-gray-100 rounded overflow-hidden">
                            @if($img)
                                <img src="{{ asset('storage/products/'.$img) }}" 
                                     class="object-cover w-full h-full">
                            @endif
                        </div>

                        <h4 class="mt-2 font-medium">{{ $product->name }}</h4>

                        <div class="text-indigo-600 font-bold">
                            Rp {{ number_format($product->price) }}
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
