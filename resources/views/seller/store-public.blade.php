<x-user-layout :title="$store->name">

<section class="p-8 max-w-5xl mx-auto">

    {{-- STORE HEADER --}}
    <div class="flex items-center gap-6 mb-10">
        <img src="{{ asset('storage/' . $store->logo) }}"
             class="w-28 h-28 rounded-xl object-cover shadow-md">

        <div>
            <h1 class="text-3xl font-bold text-textdark">{{ $store->name }}</h1>
            <p class="text-gray-600 mt-2 max-w-xl">{{ $store->about }}</p>

            <div class="mt-3 text-sm text-gray-500">
                📍 {{ $store->city }} — {{ $store->address }}
                <br>
                📞 {{ $store->phone }}
            </div>
        </div>
    </div>

    {{-- PRODUCT LIST --}}
    <h2 class="text-2xl font-semibold mb-4">Products</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        @foreach ($products as $p)
            <a href="{{ route('products.show', $p->id) }}" class="block bg-white p-4 rounded-xl shadow-sm border">
                
                @if ($p->images->first())
                    <img src="{{ asset('storage/' . $p->images->first()->image) }}"
                         class="h-32 w-full object-cover rounded-lg mb-3">
                @else
                    <div class="h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                        No Image
                    </div>
                @endif

                <h3 class="font-semibold text-textdark">{{ $p->name }}</h3>
                <p class="text-gray-600 text-sm">
                    Rp {{ number_format($p->price, 0, ',', '.') }}
                </p>
            </a>
        @endforeach
    </div>

</section>

</x-user-layout>