<x-seller-layout title="Riwayat Saldo">
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Riwayat Saldo</h1>

    <div class="bg-white p-6 rounded shadow">
        @if(count($history) === 0)
            <p class="text-gray-600">Belum ada riwayat.</p>
        @else
            <ul>
                @foreach($history as $h)
                    <li class="py-2 border-b">{{ $h->note }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
</x-seller-layout>
