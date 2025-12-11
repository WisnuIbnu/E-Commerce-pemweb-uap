<x-user-layout :title="$category->name">

<h1 class="page-title">{{ $category->name }}</h1>

<div class="grid-products">
    @foreach ($products as $p)
        <a href="{{ route('products.show', $p->id) }}" class="card">
            <img src="{{ asset('storage/'.$p->images->first()->image) }}" class="h-40 w-full object-cover rounded-lg">
            <h3 class="mt-3 font-semibold">{{ $p->name }}</h3>
        </a>
    @endforeach
</div>

</x-user-layout>