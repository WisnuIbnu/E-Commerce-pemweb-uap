<x-user-layout title="Categories">

    <h1 class="page-title">All Categories</h1>

    <div class="grid-categories">
        @foreach ($categories as $c)
            <a href="{{ route('categories.products', $c->id) }}" class="card text-center">
                <img src="{{ asset('storage/'.$c->image) }}" class="h-20 mx-auto">
                <p class="mt-2 font-semibold">{{ $c->name }}</p>
            </a>
        @endforeach
    </div>

</x-user-layout>