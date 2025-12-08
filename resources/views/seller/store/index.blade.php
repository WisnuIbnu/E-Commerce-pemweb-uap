<x-app-layout>

    <x-slot name="header">
        <h1 class="text-2xl font-bold">My Store</h1>
    </x-slot>

    <div class="container mx-auto py-6">

        {{-- If Store Exists --}}
        @if($store)
            <div class="bg-white p-6 rounded shadow mb-6">

                <h2 class="text-xl font-semibold mb-2">{{ $store->name }}</h2>

                @if($store->logo)
                    <img src="{{ asset('storage/'.$store->logo) }}" class="h-24 mb-3" alt="logo">
                @endif

                <p class="mb-1">{{ $store->about }}</p>
                <p class="mb-1">{{ $store->address }}, {{ $store->city }}</p>
                <p class="mb-3">Verified: <strong>{{ $store->is_verified ? 'Yes' : 'No' }}</strong></p>

                <form action="{{ route('seller.store.update', $store->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="font-semibold">Store Name</label>
                    <input type="text" name="name" value="{{ $store->name }}" class="border p-2 w-full mb-3 rounded">

                    <label class="font-semibold">Logo</label>
                    <input type="file" name="logo" class="w-full mb-3">

                    <label class="font-semibold">About</label>
                    <textarea name="about" class="border p-2 w-full mb-3 rounded">{{ $store->about }}</textarea>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded">
                        Update Store
                    </button>
                </form>
            </div>

        {{-- If No Store Yet --}}
        @else
            <div class="bg-white p-6 rounded shadow">

                <h2 class="text-xl font-semibold mb-4">Create Store</h2>

                <form action="{{ route('seller.store.create') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <label class="font-semibold">Store Name</label>
                    <input name="name" placeholder="Store name" class="border p-2 w-full mb-3 rounded">

                    <label class="font-semibold">Logo</label>
                    <input type="file" name="logo" class="w-full mb-3">

                    <label class="font-semibold">About</label>
                    <textarea name="about" placeholder="About your store..." class="border p-2 w-full mb-3 rounded"></textarea>

                    <button class="bg-green-600 text-white px-4 py-2 rounded">
                        Create
                    </button>
                </form>
            </div>
        @endif

    </div>

</x-app-layout>
