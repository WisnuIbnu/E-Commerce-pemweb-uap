<x-user-layout :title="$product->name">

<div class="card flex gap-8">

    <img src="{{ asset('storage/'.$product->images->first()->image) }}"
         class="w-80 h-80 object-cover rounded-xl">

    <div>
        <h1 class="text-3xl font-bold">{{ $product->name }}</h1>
        <p class="text-xl text-sweet-500 font-semibold mt-2">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
            @csrf
            <button class="btn-primary">Add to Cart</button>
        </form>
    </div>

</div>

</x-user-layout>