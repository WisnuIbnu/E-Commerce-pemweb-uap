<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Your Cart</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow-sm">

                @if(count($cart) === 0)
                    <p class="text-gray-500 text-center py-6">Your cart is empty.</p>
                @else

                    <div class="space-y-4">
                        @foreach ($cart as $id => $item)
                            <div class="flex items-center gap-4 border-b pb-4">

                                {{-- CHECKBOX --}}
                                <input type="checkbox" name="selected_items[]" value="{{ $id }}" class="h-5 w-5 text-indigo-600">

                                {{-- IMAGE --}}
                                <div class="w-24 h-24 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                    @if(isset($item['image']))
                                        <img src="{{ asset('storage/products/'.$item['image']) }}" class="object-cover w-full h-full">
                                    @else
                                        <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                                    @endif
                                </div>

                                {{-- ITEM DETAILS --}}
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold">{{ $item['name'] }}</h3>
                                    <div class="text-sm text-gray-500">
                                        Price: Rp {{ number_format($item['price']) }}  
                                        • Qty: {{ $item['qty'] }}
                                    </div>

                                    <div class="text-indigo-600 font-bold mt-1">
                                        Rp {{ number_format($item['qty'] * $item['price']) }}
                                    </div>
                                </div>

                                {{-- REMOVE BUTTON --}}
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                        Remove
                                    </button>
                                </form>

                            </div>
                        @endforeach
                    </div>

                    {{-- CHECKOUT BUTTON --}}
                    <form action="{{ route('checkout.index') }}" method="GET" class="mt-6 flex justify-end">
                        <button type="submit"
                                class="bg-green-600 text-white px-6 py-3 rounded shadow hover:bg-green-700">
                            Checkout
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
