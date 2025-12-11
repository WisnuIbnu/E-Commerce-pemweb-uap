<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pengaturan Profil
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kelola informasi akun dan keamanan Sembako Mart kamu.
                </p>
            </div>

            @php
                $user = auth()->user();
                $initial = $user ? mb_strtoupper(mb_substr($user->name ?? 'A', 0, 1)) : 'A';
                $phoneNumber = optional($user->buyer)->phone_number;
            @endphp

            {{-- mini badge profil di header --}}
            <div class="hidden sm:flex items-center gap-3 bg-white px-3 py-2 rounded-full shadow-sm">
                <div class="flex items-center justify-center w-9 h-9 rounded-full bg-orange-500 text-white font-semibold">
                    {{ $initial }}
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-semibold text-gray-800">
                        {{ $user->name ?? 'User' }}
                    </span>
                    <span class="text-xs text-gray-500">
                        {{ $user->email }}
                    </span>
                    @if ($phoneNumber)
                        <span class="text-xs text-gray-400">
                            {{ $phoneNumber }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Kolom kiri --}}
                <div class="space-y-4">
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Profil Akun</h3>
                        <p class="text-xs text-gray-500 leading-relaxed">
                            Ubah nama, email, dan nomor HP akun kamu. Informasi ini akan digunakan di seluruh sistem Sembako Mart.
                        </p>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2">Keamanan</h3>
                        <p class="text-xs text-gray-500 mb-2">
                            Rutin ganti password untuk menjaga keamanan akunmu.
                        </p>
                        <div class="inline-flex items-center px-2 py-1 rounded-full text-[11px] font-medium bg-green-50 text-green-700 border border-green-200">
                            ● Status: Aman
                        </div>
                    </div>

                    <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
                        <h3 class="text-sm font-semibold text-orange-700 mb-1">Tips</h3>
                        <p class="text-xs text-orange-600 leading-relaxed">
                            Gunakan email aktif dan password yang berbeda dengan akun lain untuk keamanan maksimal.
                        </p>
                    </div>
                </div>

                {{-- Kolom kanan --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Informasi Profil --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-800">Informasi Profil</h3>
                                <p class="text-xs text-gray-500">
                                    Perbarui nama, email, dan nomor HP akun kamu.
                                </p>
                            </div>
                        </div>

                        {{-- === FORM UPDATE PROFILE FULL === --}}
                        @php
                            $buyerPhone = old('phone_number', optional($user->buyer)->phone_number);
                        @endphp

                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                            @csrf
                            @method('patch')

                            {{-- Name --}}
                            <div>
                                <x-input-label for="name" value="Name" />
                                <x-text-input id="name" name="name" type="text"
                                    class="mt-1 block w-full"
                                    :value="old('name', $user->name)"
                                    required autofocus />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            {{-- Email --}}
                            <div>
                                <x-input-label for="email" value="Email" />
                                <x-text-input id="email" name="email" type="email"
                                    class="mt-1 block w-full"
                                    :value="old('email', $user->email)"
                                    required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            {{-- Nomor HP --}}
                            <div>
                                <x-input-label for="phone_number" value="Nomor HP" />
                                <x-text-input id="phone_number" name="phone_number" type="text"
                                    class="mt-1 block w-full"
                                    :value="$buyerPhone"
                                    autocomplete="tel" />
                                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Simpan</x-primary-button>

                                @if (session('status') === 'profile-updated')
                                    <p class="text-sm text-gray-600">Tersimpan.</p>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Update password --}}
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-base font-semibold text-gray-800">Ubah Password</h3>
                                <p class="text-xs text-gray-500">
                                    Gunakan password yang kuat dan unik.
                                </p>
                            </div>
                        </div>

                        @include('profile.partials.update-password-form')
                    </div>

                    {{-- Hapus Akun --}}
                    @if (View::exists('profile.partials.delete-user-form'))
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-red-100">
                            <h3 class="text-base font-semibold text-red-600 mb-2">Hapus Akun</h3>
                            @include('profile.partials.delete-user-form')
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
