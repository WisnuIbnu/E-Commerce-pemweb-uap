<x-app-layout>
    <div class="max-w-7xl mx-auto py-10">
        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
        <p class="text-gray-600 mt-2">Rp {{ number_format($product->price) }}</p>
    </div>
</x-app-layout>
