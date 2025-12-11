<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">{{ $product->name }}</h2>
    </x-slot>

    <div class="p-6 grid grid-cols-2 gap-6">
        {{-- Images --}}
        <div>
            @forelse ($product->images as $img)
                <img src="{{ asset('storage/' . $img->image) }}" alt="{{ $product->name }}" class="mb-4 w-full rounded">
            @empty
                <div class="w-full h-64 bg-gray-200 flex items-center justify-center rounded mb-4">
                    No Image
                </div>
            @endforelse
        </div>

        {{-- Product Info --}}
        <div class="space-y-2">
            <p><strong>Category:</strong> {{ $product->category->name }}</p>
            <p><strong>Condition:</strong> {{ ucfirst($product->condition) }}</p>
            <p><strong>Price:</strong> Rp {{ number_format($product->price) }}</p>
            <p><strong>Weight:</strong> {{ $product->weight }} grams</p>
            <p><strong>Stock:</strong> {{ $product->stock }}</p>
            <p><strong>Description:</strong></p>
            <p class="whitespace-pre-line">{{ $product->description }}</p>
        </div>
    </div>
</x-app-layout>
