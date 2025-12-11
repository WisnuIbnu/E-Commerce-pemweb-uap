<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Store Profile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Your store's information.") }}
        </p>
    </header>

    @if(auth()->user()->store && $store->is_verified == 1)
    <form method="post" action="{{ route('store.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Store Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $store->name)" autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="logo" :value="__('Store Logo')" />
            <img src="{{ asset('storage/' . $store->logo) }}" alt="Current Logo" class="h-16 w-16 object-cover rounded">
            <p class="text-sm text-gray-500">Current logo</p>
            <x-text-input id="logo" name="logo" type="file" class="mt-1 block w-full" />
            <x-input-error class="mt-2" :messages="$errors->get('logo')" />
        </div>

        <div>
            <x-input-label for="about" :value="__('About')" />
            <x-text-input id="about" name="about" type="text" class="mt-1 block w-full" :value="old('about', $store->about)" autofocus autocomplete="about" />
            <x-input-error class="mt-2" :messages="$errors->get('about')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $store->phone)" autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address_id" :value="__('Address ID')" />
            <x-text-input id="address_id" name="address_id" type="text" class="mt-1 block w-full" :value="old('address_id', $store->address_id)" autofocus autocomplete="address_id" />
            <x-input-error class="mt-2" :messages="$errors->get('address_id')" />
        </div>

        <div>
            <x-input-label for="city" :value="__('City')" />
            <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $store->city)" autofocus autocomplete="city" />
            <x-input-error class="mt-2" :messages="$errors->get('city')" />
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $store->address)" autofocus autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="postal_code" :value="__('Postal Code')" />
            <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $store->postal_code)" autofocus autocomplete="postal_code" />
            <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Changes') }}</x-primary-button>

            @if (session('status'))
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 5000)"
                    class="text-sm text-gray-600"
                >{{ session('status') }}</p>
            @endif
        </div>
    </form>
    @else No verified store yet.
    @endif
</section>

