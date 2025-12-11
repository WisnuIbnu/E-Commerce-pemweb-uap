<section>
    {{-- CSS khusus blok foto pembeli --}}
    <style>
        .buyer-avatar-block {
            margin-top: 1.5rem;
        }

        .buyer-avatar-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: #111827;
            margin-bottom: 0.5rem;
        }

        .buyer-avatar-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .buyer-avatar-wrapper {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            overflow: hidden;
            border: 2px solid #d1d5db;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .buyer-avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .buyer-avatar-placeholder-text {
            font-size: 0.75rem;
            color: #6b7280;
            text-align: center;
            padding: 0 0.5rem;
        }
    </style>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informasi Pembeli') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Informasi tambahan untuk profil pembeli Anda.') }}
        </p>
    </header>

    @if($user->buyer)
        <!-- ========================= -->
        <!-- Buyer Sudah Punya Profil -->
        <!-- ========================= -->
        <form method="post" action="{{ route('buyer.profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
            @csrf
            @method('patch')

            {{-- Blok foto profil saat ini (tanpa Tailwind) --}}
            <div class="buyer-avatar-block">
                <div class="buyer-avatar-label">
                    {{ __('Foto Profil Saat Ini') }}
                </div>
                <div class="buyer-avatar-row">
                    @if($user->buyer->profile_picture)
                        <div class="buyer-avatar-wrapper">
                            <img
                                src="{{ asset('storage/' . $user->buyer->profile_picture) }}"
                                alt="Profile Picture"
                            >
                        </div>
                    @else
                        <div class="buyer-avatar-wrapper">
                            <span class="buyer-avatar-placeholder-text">
                                Belum ada foto profil
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Upload New Profile Picture -->
            <div>
                <x-input-label for="profile_picture" :value="__('Upload Foto Profil Baru (Opsional)')" />
                <input
                    id="profile_picture"
                    name="profile_picture"
                    type="file"
                    accept="image/*"
                    class="mt-1 block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-semibold
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100"
                />
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Format: JPG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.') }}
                </p>
                <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
            </div>

            <!-- Phone Number -->
            <div>
                <x-input-label for="phone_number" :value="__('Nomor Telepon')" />
                <x-text-input
                    id="phone_number"
                    name="phone_number"
                    type="text"
                    class="mt-1 block w-full"
                    :value="old('phone_number', $user->buyer->phone_number)"
                    required
                />
                <x-input-error class="mt-2" :messages="$errors->get('phone_number')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Simpan') }}</x-primary-button>

                @if (session('status') === 'buyer-profile-updated')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600">
                       {{ __('Tersimpan.') }}
                    </p>
                @endif

                @if (session('status') === 'profile-picture-deleted')
                    <p x-data="{ show: true }"
                       x-show="show"
                       x-transition
                       x-init="setTimeout(() => show = false, 2000)"
                       class="text-sm text-gray-600">
                       {{ __('Foto profil dihapus.') }}
                    </p>
                @endif
            </div>
        </form>
    @else
        <div class="mt-6">
            <!-- Alert -->
            <div class="rounded-md bg-yellow-50 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            {{ __('Profil Pembeli Belum Lengkap') }}
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>{{ __('Anda belum melengkapi profil pembeli. Silakan lengkapi profil untuk dapat berbelanja.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('buyer.profile.create') }}"
                    class="inline-flex items-center px-3 py-2 bg-gray-800 text-white font-semibold
                        rounded-md shadow hover:bg-gray-900 transition"
                >
                    Lengkapi Informasi
                </a>
            </div>
        </div>
    @endif
</section>