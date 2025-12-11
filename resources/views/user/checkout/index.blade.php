@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout</h1>

    @if($carts->isEmpty())
        <div class="bg-white p-8 rounded-lg shadow text-center">
            <p class="text-gray-500">Your cart is empty.</p>
            <a href="{{ route('products') }}" class="mt-4 inline-block bg-black text-white px-6 py-2 rounded hover:bg-gray-800">
                Continue Shopping
            </a>
        </div>
    @else
        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Left Column: Form & Items --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Shipping Address --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                                <textarea name="address" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required placeholder="Street name, house number, etc."></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" name="city" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required placeholder="Jakarta">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                <input type="text" name="postal_code" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required placeholder="12345">
                            </div>
                        </div>
                    </div>

                    {{-- Item Summary --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-xl font-semibold mb-4">Order Items</h2>
                        @foreach($carts as $cart)
                            <div class="flex items-center gap-4 py-4 border-b last:border-0">
                                @if($cart->product->productImages->first())
                                    <img src="{{ asset('storage/' . $cart->product->productImages->first()->image) }}" 
                                         alt="{{ $cart->product->name }}" 
                                         class="w-20 h-20 object-cover rounded">
                                @else
                                    <div class="w-20 h-20 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Image</div>
                                @endif
                                <div class="flex-1">
                                    <div class="text-xs text-gray-500 mb-1">{{ $cart->product->store->name ?? 'Store' }}</div>
                                    <h3 class="font-medium">{{ $cart->product->name }}</h3>
                                    <p class="text-sm text-gray-500">Qty: {{ $cart->quantity }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold">Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Right Column: Summary & Payment --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                        <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
                        
                        {{-- Shipment Selection --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Shipment Type</label>
                            <select name="shipping_service" id="shipping_service" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required>
                                <option value="Regular" data-cost="10000">Regular (Rp 10.000)</option>
                                <option value="Express" data-cost="30000">Express (Rp 30.000)</option>
                                <option value="Same Day" data-cost="50000">Same Day (Rp 50.000)</option>
                            </select>
                        </div>

                        {{-- Bank Selection --}}
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Payment Bank</label>
                            <select name="bank" class="w-full border-gray-300 rounded-md shadow-sm focus:border-black focus:ring-black" required>
                                <option value="BCA">BCA</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="CIMB Niaga">CIMB Niaga</option>
                            </select>
                        </div>

                        {{-- Totals --}}
                        <div class="space-y-2 mb-4 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-medium">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping Cost (Est.)</span>
                                <span class="font-medium" id="shipping-cost-display">Rp 10.000</span>
                            </div>
                        </div>

                        <div class="border-t pt-4 mb-6">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Grand Total</span>
                                <span id="grand-total-display">Rp {{ number_format($subtotal + 10000, 0, ',', '.') }}</span>
                            </div>
                            <!-- Assuming simple calculation: Total is Subtotal + Shipping Cost x Number of Stores? 
                                 Wait, the shipment dropdown is GLOBAL for simplicity in UI, but backend splits by store.
                                 Let's assume the user selects ONE shipping method for ALL stores. The cost displayed here is per store? 
                                 Or do we multiply by store count? 
                                 Let's keep it simple: The UI shows the cost for ONE shipment. The backend loop applies it per store.
                                 To avoid confusion, let's just update the display based on "Standard * Store count" if we want accuracy,
                                 but user sees 'Regular - 10k'. Probably easiest to just add ONE shipping cost in display logic for now 
                                 and clarify in backend that it's per shipment.
                                 For this UI, just Subtotal + Selected Cost is fine for estimation.
                            -->
                        </div>

                        <button type="submit" class="w-full bg-black text-white py-3 rounded hover:bg-gray-800 transition font-semibold">
                            Proceed to Payment
                        </button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const shippingSelect = document.getElementById('shipping_service');
        const shippingDisplay = document.getElementById('shipping-cost-display');
        const grandTotalDisplay = document.getElementById('grand-total-display');
        
        // Base subtotal from PHP
        const subtotal = {{ $subtotal }};
        // Count of unique stores (to multiply shipping cost if needed? For now let's just add it once or assume backend handles detail)
        // Let's keep UI simple: Just add value.
        
        // Actually, if we have items from 2 stores, backend creates 2 transactions with 2 shipping costs.
        // It's better if we just show "Estimated Total" or calculate correctly using store count.
        const storeCount = {{ $carts->unique('product.store_id')->count() }}; 

        function updateTotals() {
            const selectedOption = shippingSelect.options[shippingSelect.selectedIndex];
            const costPerShipment = parseInt(selectedOption.getAttribute('data-cost'));
            
            // Total Shipping = Cost * Store Count
            const totalShipping = costPerShipment * storeCount;
            
            // Format numbers helper
            const formatRp = (num) => 'Rp ' + num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

            shippingDisplay.textContent = formatRp(totalShipping);
            grandTotalDisplay.textContent = formatRp(subtotal + totalShipping);
        }

        if(shippingSelect) {
            shippingSelect.addEventListener('change', updateTotals);
            // Init
            updateTotals();
        }
    });
</script>
@endsection
