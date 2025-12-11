<x-user-layout title="Products">

    <h1 class="page-title">All Desserts</h1>

    <div class="grid-products">
        @foreach ($products as $p)
            <a href="{{ route('products.show', $p->id) }}" class="card">
                @if ($p->images->first())
                    <img src="{{ asset('storage/'.$p->images->first()->image) }}" class="h-40 w-full object-cover rounded-lg">
                @endif
                <h3 class="mt-3 font-semibold">{{ $p->name }}</h3>
                <p>Rp {{ number_format($p->price, 0, ',', '.') }}</p>
            </a>
        @endforeach
    </div>

</x-user-layout>