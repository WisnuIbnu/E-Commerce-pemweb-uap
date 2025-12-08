<x-app-layout>

    <x-slot name="header">
        <h1 class="text-2xl font-bold">Checkout</h1>
    </x-slot>

    <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">

        @if(empty($items))
            <div class="text-gray-600">Keranjang kosong.</div>
        @else

            <ul class="mb-4">
                @foreach($items as $it)
                <li class="mb-2">
                    <span class="font-medium">{{ $it['product']->name }}</span>
                    x {{ $it['qty'] }} —
                    <span class="font-semibold">
                        Rp {{ number_format($it['sub'], 0, ',', '.') }}
                    </span>
                </li>
                @endforeach
            </ul>

            <div class="text-xl font-bold mb-6">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Alamat Pengiriman</label>
                    <textarea 
                        name="shipping_address" 
                        required
                        rows="3"
                        class="w-full border rounded p-2 focus:ring focus:ring-blue-300"
                    ></textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">Jenis Pengiriman</label>
                    <select 
                        name="shipping_type" 
                        required
                        class="w-full border rounded p-2 focus:ring focus:ring-blue-300"
                    >
                        <option value="jne">JNE</option>
                        <option value="tiki">TIKI</option>
                        <option value="jnt">JNT</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-semibold mb-1">No. Telp</label>
                    <input 
                        type="text" 
                        name="phone" 
                        required
                        class="w-full border rounded p-2 focus:ring focus:ring-blue-300"
                    />
                </div>

                <button 
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Bayar & Konfirmasi
                </button>

            </form>

        @endif

    </div>

</x-app-layout>
