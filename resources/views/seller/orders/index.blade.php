<x-seller-layout title="Orders">

<div class="max-w-6xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Pesanan Masuk</h1>

    <div class="bg-white shadow rounded p-4">
        @forelse ($orders as $order)
            <div class="flex justify-between items-center border-b py-3">
                <div>
                    <p class="font-semibold">{{ $order->code }}</p>
                    <p class="text-sm text-gray-500">Dari: {{ $order->buyer->user->name ?? '–' }} — {{ $order->created_at->format('d M Y H:i') }}</p>
                    <p class="text-sm">Status pembayaran: <strong>{{ $order->payment_status }}</strong></p>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ route('transactions.show', $order->id) }}" class="text-sweet-500">Detail</a>

                    <button onclick="document.getElementById('ship-form-{{ $order->id }}').classList.toggle('hidden')" class="px-3 py-1 border rounded">Update Kirim</button>
                </div>
            </div>

            <div id="ship-form-{{ $order->id }}" class="hidden p-3 bg-gray-50">
                <form action="{{ route('seller.orders.ship', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <label class="block text-sm">Nomor Resi</label>
                    <input name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" class="border p-2 w-full mb-2">
                    <button class="bg-sweet-500 text-white px-3 py-1 rounded">Simpan</button>
                </form>
            </div>
        @empty
            <p class="text-gray-600">Belum ada pesanan.</p>
        @endforelse

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>

</x-seller-layout>
