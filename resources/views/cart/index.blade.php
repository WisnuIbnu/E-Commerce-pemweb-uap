<x-app-layout>
    <div class="max-w-5xl mx-auto py-10">
        <h1 class="text-3xl font-bold mb-6">Keranjang Belanja</h1>

        @if($cartItems->count() == 0)
            <p class="text-gray-600">Keranjang kamu kosong.</p>
        @else
            <div class="space-y-4">

                @foreach($cartItems as $item)
                    <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-md">

                        <div class="flex items-center gap-4">
                            <img src="{{ asset('storage/' . ($item->product->productImages->first()->image ?? 'default.jpg')) }}"
                                 class="w-20 h-20 object-cover rounded-lg">

                            <div>
                                <p class="font-semibold">{{ $item->product->name }}</p>

                                <p class="text-orange-600 font-bold">
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                </p>

                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center mt-2">
                                    @csrf
                                    <input
                                        type="number"
                                        name="qty"
                                        min="1"
                                        value="{{ $item->qty }}"
                                        class="w-16 border rounded-lg px-2 py-1"
                                    >
                                    <button
                                        class="ml-3 inline-flex items-center px-3 py-1 bg-orange-500 hover:bg-orange-600
                                               text-white rounded-lg text-sm font-semibold transition"
                                    >
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>

                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button
                                class="text-sm text-red-600 hover:text-red-700 hover:underline font-semibold"
                            >
                                Hapus
                            </button>
                        </form>

                    </div>
                @endforeach

            </div>

            <div class="mt-8 p-6 bg-white shadow-lg rounded-xl flex items-center justify-between">
                <div>
                    <h2 class="text-sm text-gray-500 uppercase tracking-wide">Total</h2>
                    <p class="text-2xl font-bold text-gray-900">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </p>
                </div>

                <a
                    href="{{ route('checkout.index') }}"
                    class="inline-flex items-center bg-orange-500 hover:bg-orange-600 text-white px-6 py-3
                           rounded-lg font-semibold shadow-md transition"
                >
                    Checkout Sekarang →
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
