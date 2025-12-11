<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Your Store Categories') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Manage your products' categories.") }}
        </p>
    </header>

    @if(auth()->user()->store && $store->is_verified == 1)
    <x-secondary-button onclick="window.location='{{ route('category.create') }}'">Create New Category</x-secondary-button>
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @forelse ($categories as $category)
        <div class="border rounded p-4 flex flex-col">
            <img src="{{ asset('storage/' . $category->image) }}" class="h-40 w-full object-cover rounded mb-2">
            <h3 class="text-lg font-semibold">{{ $category->name }}</h3>
            <p class="text-gray-600">{{ $category->slug }}</p>
            <p class="text-gray-600">{{ $category->tagline }}</p>
            <p class="text-gray-600">{{ $category->description }}</p>
            <div class="mt-auto flex justify-between items-center mt-4">
                <x-secondary-button onclick="window.location='{{ route('category.edit', $category->id) }}'">Edit</x-secondary-button>
                <form action="{{ route('products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category from your store?')">
                    @csrf
                    @method('delete')
                    <x-danger-button onclick="window.location='{{ route('category.destroy', $category->id) }}'">Delete</x-danger-button>
                </form>
            </div>
        </div>
    </div>
    @empty You have not added a category.
    @endforelse
    @else No verified store yet.
    @endif
</div>
</section>



