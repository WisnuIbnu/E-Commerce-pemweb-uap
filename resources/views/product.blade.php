<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $product->name }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Images --}}
                <div class="lg:col-span-1">
                    <div class="space-y-3">
                        @php
                            $images = $product->productImages;
                            $main = $images->first()->image ?? null;
                        @endphp

                        <div class="h-64 bg-gray-100 flex items-center justify-center overflow-hidden rounded">
                            @if($main)
                                <img id="main-image" src="{{ asset('storage/products/'.$main) }}" alt="" class="object-cover h-full w-full">
                            @else
                                <div class="text-gray-400">No image</div>
                            @endif
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            @foreach($images as $img)
                                <button type="button" onclick="document.getElementById('main-image').src='{{ asset('storage/products/'.$img->image) }}'">
                                    <img src="{{ asset('storage/products/'.$img->image) }}" class="h-20 w-full object-cover rounded">
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Details --}}
                <div class="lg:col-span-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="text-2xl font-semibold">{{ $product->name }}</h1>
                            <p class="text-sm text-gray-500 mt-1">{{ $product->productCategory->name ?? '-' }} • {{ $product->condition }}</p>
                        </div>
                        <div class="text-2xl font-bold text-indigo-600">Rp {{ number_format($product->price,0,',','.') }}</div>
                    </div>

                    <div class="mt-4 text-gray-700">
                        {!! nl2br(e($product->about ?? $product->description ?? '')) !!}
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <a href="{{ route('checkout.index', $product->id) }}" class="px-5 py-2 bg-green-600 text-white rounded">
                            Buy Now
                        </a>
                        
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button class="px-5 py-2 bg-blue-600 text-white rounded">
                                Add to Cart
                            </button>
                        </form>

                        <div class="text-sm text-gray-500">Stock: {{ $product->stock }}</div>
                    </div>

                    {{-- Reviews --}}
                    <div class="mt-8">
                        <h3 class="font-semibold">Reviews</h3>
                        <div class="mt-3 space-y-4">
                            @forelse($product->productReviews as $review)
                                <div class="border p-3 rounded">
                                    <div class="flex items-center justify-between">
                                        <div class="font-medium">{{ $review->buyer->user->name ?? 'Anonymous' }}</div>
                                        <div class="text-sm text-gray-500">Rating: {{ $review->rating ?? '-' }}</div>
                                    </div>
                                    <div class="text-gray-700 mt-2">{{ $review->review }}</div>
                                </div>
                            @empty
                                <div class="text-gray-500">No reviews yet.</div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
