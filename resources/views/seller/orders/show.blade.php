<x-seller-layout title="Order Detail">

<div class="seller-card">

    <h3 class="font-semibold mb-3">Items</h3>
    @foreach ($order->items as $item)
        <p>{{ $item->product->name }} x {{ $item->qty }}</p>
    @endforeach

    <form method="POST" action="{{ route('seller.orders.ship', $order->id) }}" class="mt-4">
        @csrf @method('PUT')
        <input type="text" name="tracking_number" placeholder="Tracking Number" class="form-input mb-3">
        <button class="seller-btn">Mark as Shipped</button>
    </form>

</div>

</x-seller-layout>