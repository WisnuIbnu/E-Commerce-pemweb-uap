<x-app-layout>

    <x-slot name="header">
        <h1 class="text-2xl font-bold">My Products</h1>
    </x-slot>

    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">My Products</h1>
            <a href="{{ route('seller.products.create') }}" 
               class="bg-green-600 text-white px-3 py-1 rounded">
               Create Product
            </a>
        </div>

        <div class="grid grid-cols-3 gap-4">
            @foreach($products as $p)
                <div class="bg-white p-4 rounded shadow">
                    
                    @if($p->images->first())
                        <img src="{{ asset('storage/'.$p->images->first()->path) }}" 
                             class="h-40 w-full object-cover mb-2">
                    @endif

                    <h3 class="font-semibold">{{ $p->name }}</h3>
                    <p class="text-sm">{{ Str::limit($p->description,120) }}</p>
                    <p class="font-bold mt-2">
                        Rp {{ number_format($p->price,0,',','.') }}
                    </p>

                    <div class="mt-2 flex space-x-2">
                        <a href="{{ route('seller.products.edit', $p->id) }}" 
                           class="text-blue-600">Edit</a>

                        <form action="{{ route('seller.products.destroy', $p->id) }}" method="POST">
                            @csrf 
                            @method('DELETE')
                            <button class="text-red-600" 
                                    onclick="return confirm('Delete product?')">
                                    Delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

</x-app-layout>
