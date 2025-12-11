<x-seller-layout title="Penarikan">

<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Penarikan Dana</h1>

    <div class="bg-white p-6 rounded shadow">
        <form action="{{ route('seller.withdraw.request') }}" method="POST">
            @csrf
            <label>Jumlah (min Rp 10.000)</label>
            <input name="amount" type="number" class="border w-full p-2 mb-3" required>

            <button class="bg-sweet-500 text-white px-4 py-2 rounded">Ajukan Penarikan</button>
        </form>
    </div>
</div>

</x-seller-layout>
