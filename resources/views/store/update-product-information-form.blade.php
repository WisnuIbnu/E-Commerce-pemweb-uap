<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Product information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your product's information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('product.update', $product->id) }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="image" :value="__('Image')" />
            @if ($product->productImages->isNotEmpty())
                <img src="{{ asset('storage/' . $product->productImages->first()->image) }}" class="h-40 w-full object-cover rounded mb-2">
            @endif
            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" autocomplete="image" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div>
            <x-input-label for="category" :value="__('Category')" />
            <select id="product_category_id" name="product_category_id" class="mt-1 block w-full border-gray-300 rounded">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('category.create') }}" style="color: blue !important;">Don't see the right category? Create a new category</a>
            <x-input-error class="mt-2" :messages="$errors->get('product_category_id')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', $product->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="about" :value="__('About')" />
            <x-text-input id="about" name="about" type="text" class="mt-1 block w-full" value="{{ old('about', $product->about) }}" required autofocus autocomplete="about" />
            <x-input-error class="mt-2" :messages="$errors->get('about')" />
        </div>

        <div>
            <x-input-label for="slug" :value="__('Slug')" />
            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" value="{{ old('slug', $product->slug) }}" required autofocus autocomplete="slug" />
            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" value="{{ old('description', $product->description) }}" required autofocus autocomplete="description" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="condition" :value="__('Condition')" />
            <select id="condition" name="condition" class="mt-1 block w-full border-gray-300 rounded">
                <option value="">Select Product Condition</option>
                <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                <option value="second" {{ old('condition', $product->condition) == 'second' ? 'selected' : '' }}>Second</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('condition')" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" name="price" type="number" value="{{ old('price', $product->price) }}" class="mt-1 block w-full" required autofocus autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>

        <div>
            <x-input-label for="weight" :value="__('Weight')" />
            <x-text-input id="weight" name="weight" type="number" value="{{ old('weight', $product->weight) }}" class="mt-1 block w-full" required autofocus autocomplete="weight" />
            <x-input-error class="mt-2" :messages="$errors->get('weight')" />
        </div>

        <div>
            <x-input-label for="stock" :value="__('Stock')" />
            <x-text-input id="stock" name="stock" type="number" value="{{ old('stock', $product->stock) }}" class="mt-1 block w-full" required autofocus autocomplete="stock" />
            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>
        </div>
    </form>
</section>
