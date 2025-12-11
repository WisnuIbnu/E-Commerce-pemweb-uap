<x-user-layout title="Cart">

<div class="container py-8 max-w-4xl mx-auto">

    <h1 class="text-3xl font-bold mb-6">Your Cart</h1>

    <div class="bg-white p-6 rounded-lg shadow border">

        @foreach ($products as $p)
        <div class="flex justify-between items-center border-b py-3">

            <div>
                <p class="font-semibold">{{ $p->name }}</p>
                <p class="text-sm text-gray-600">
                    Qty: {{ $cart[$p->id]['qty'] }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <p>Rp {{ number_format($p->price * $cart[$p->id]['qty'],0,',','.') }}</p>

                <form action="{{ route('cart.remove', $p->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-500 hover:underline text-sm">
                        Hapus
                    </button>
                </form>
            </div>

        </div>
        @endforeach

        <div class="flex justify-between mt-4">

            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded">
                    Hapus Semua
                </button>
            </form>

            <a href="/checkout"
               class="bg-sweet-500 text-white px-4 py-2 rounded hover:bg-sweet-600">
                Proceed to Checkout
            </a>

        </div>

    </div>

</div>

</x-user-layout>
