<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Add Product to Your Store') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Fill your product's information.") }}
        </p>
    </header>

    <form method="post" action="{{ route('product.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf

        <div>
            <x-input-label for="image" :value="__('Image')" />
            <x-text-input id="image" name="image" type="file" class="mt-1 block w-full" autofocus autocomplete="image" />
            <x-input-error class="mt-2" :messages="$errors->get('image')" />
        </div>

        <div>
            <x-input-label for="category" :value="__('Category')" />
            <select id="product_category_id" name="product_category_id" class="mt-1 block w-full border-gray-300 rounded">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
            <a href="{{ route('category.create') }}" style="color: blue !important;">Don't seems to find the right category? Create new category</a>
            <x-input-error class="mt-2" :messages="$errors->get('product_category_id')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="about" :value="__('About')" />
            <x-text-input id="about" name="about" type="text" class="mt-1 block w-full" required autofocus autocomplete="about" />
            <x-input-error class="mt-2" :messages="$errors->get('about')" />
        </div>

        <div>
            <x-input-label for="slug" :value="__('Slug')" />
            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" required autofocus autocomplete="slug" />
            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
        </div>

        <div>
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" name="description" type="text" class="mt-1 block w-full" required autofocus autocomplete="description" />
            <x-input-error class="mt-2" :messages="$errors->get('description')" />
        </div>

        <div>
            <x-input-label for="condition" :value="__('Condition')" />
            <select id="condition" name="condition" class="mt-1 block w-full border-gray-300 rounded">
                <option value="">Select Product Condition</option>
                <option value="new">New</option>
                <option value="second">Second</option>
            </select>
            <x-input-error class="mt-2" :messages="$errors->get('condition')" />
        </div>

        <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" name="price" type="number" class="mt-1 block w-full" required autofocus autocomplete="price" />
            <x-input-error class="mt-2" :messages="$errors->get('price')" />
        </div>

        <div>
            <x-input-label for="weight" :value="__('Weight')" />
            <x-text-input id="weight" name="weight" type="number" class="mt-1 block w-full" required autofocus autocomplete="weight" />
            <x-input-error class="mt-2" :messages="$errors->get('weight')" />
        </div>

        <div>
            <x-input-label for="stock" :value="__('Stock')" />
            <x-text-input id="stock" name="stock" type="number" class="mt-1 block w-full" required autofocus autocomplete="stock" />
            <x-input-error class="mt-2" :messages="$errors->get('stock')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Add') }}</x-primary-button>

        </div>
    </form>
</section>

