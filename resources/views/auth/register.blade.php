<x-guest-layout>
    <div class="mb-4 text-center">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-gray-800">
                🍪 SnackShop
            </h1>
        </div>
        <h2 class="text-xl font-semibold text-gray-700">
            Daftar Akun Baru
        </h2>
        <p class="text-gray-600 mt-2">
            Bergabunglah dengan SnackShop
        </p>
        <p class="text-sm text-gray-500 mt-1">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                Login Sekarang
            </a>
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="w-full justify-center">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-xs text-gray-500">
            Dengan mendaftar, Anda menyetujui syarat & ketentuan kami
        </p>
        <p class="text-xs text-gray-500 mt-2">
            © 2025 SnackShop. All rights reserved.
        </p>
    </div>
</x-guest-layout>