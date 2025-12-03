<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Store Verification</h2>
    </x-slot>

    <div class="p-6 bg-lunpia-cream min-h-screen">

        <div class="bg-white p-6 rounded-xl shadow">
            <h3 class="text-lg font-semibold text-lunpia-dark mb-4">Pending Seller Verification</h3>

            <ul>
                @forelse($sellers as $seller)
                    <li class="border-b py-3">
                        <strong>{{ $seller->name }}</strong> — {{ $seller->email }}
                    </li>
                @empty
                    <p class="text-lunpia-dark">No pending seller verification.</p>
                @endforelse
            </ul>
        </div>

    </div>
</x-app-layout>