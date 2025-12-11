<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Your Store Products') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Manage your store products.") }}
        </p>
    </header>

    @if(auth()->user()->store && $store->is_verified == 1)
    <x-secondary-button onclick="window.location='{{ route('product.create') }}'">Add New Product</x-secondary-button>
    @forelse ($store->products as $product)
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <div class="border rounded p-4 flex flex-col">
            @if ($product->productImages->isNotEmpty())
            <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" alt="{{ asset('storage/' . $product->productImages->first()->image) }}">
            @else
            <div class="h-40 w-full bg-gray-200 rounded flex items-center justify-center">No image</div>
            @endif
            <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
            <p class="text-gray-600">{{ $product->description }}</p>
            <p class="text-gray-600">{{ $product->condition }}</p>
            <p class="text-gray-600">{{ $product->weight }}</p>
            <p class="text-gray-600">{{ $product->stock }}</p>
            <p class="text-gray-600">{{ $product->price }}</p>
            <div class="mt-auto flex justify-between items-center mt-4">
                <x-secondary-button onclick="window.location='{{ route('product.edit', $product->id) }}'">Edit</x-secondary-button>
                <form action="{{ route('product.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product from your store?')">
                    @csrf
                    @method('delete')
                    <x-danger-button onclick="window.location='{{ route('product.create') }}'">Delete</x-danger-button>
                </form>
            </div>
        </div>
        </div>
    </div>
    @empty You have not added a product.
    @endforelse
    @else No verified store yet.
    @endif
</section>


