@props(['product'])

<div class="bg-white rounded-2xl border hover-card overflow-hidden">

  <a href="{{ route('products.show', $product->id) }}">
    @if($product->images->first())
      <img src="{{ asset('storage/'.$product->images->first()->image) }}"
           class="w-full h-48 object-cover">
    @else
      <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">No Image</div>
    @endif
  </a>

  <div class="p-4">
    <h3 class="font-semibold text-lg text-textdark truncate">
      {{ $product->name }}
    </h3>

    <div class="text-sm text-gray-500 mt-1">
      Rp {{ number_format($product->price,0,',','.') }}
    </div>

    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-4">
      @csrf
      <input type="hidden" name="qty" value="1">
      <button class="w-full bg-sweet-400 hover:bg-sweet-500 text-white py-2 rounded-lg shadow">
        Add to Cart
      </button>
    </form>
  </div>
</div>