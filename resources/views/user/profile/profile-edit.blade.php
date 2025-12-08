<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
    @include('layouts.store-navbar')

    <main class="px-16 py-10">
        <h1 class="text-2xl font-semibold mb-6">Profile</h1>

        <div class="max-w-3xl space-y-6">

            {{-- Update Profile --}}
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Profile</h3>

                @if (session('status') === 'profile-updated')
                    <p class="text-sm text-green-600 mb-3">Profile updated successfully.</p>
                @endif

                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('patch')

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}"
                               class="mt-1 w-full border rounded-md px-3 py-2 text-sm">
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" value="{{ $user->email }}" disabled
                               class="mt-1 w-full border rounded-md px-3 py-2 text-sm bg-gray-100">
                    </div>

                    <button class="px-4 py-2 bg-black text-white rounded-md text-sm">
                        Simpan
                    </button>
                </form>
            </div>

            {{-- Daftar jadi seller --}}
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Seller Status</h3>

                <p class="text-sm text-gray-600 mb-4">
                    Status sekarang: <span class="font-semibold">{{ strtoupper($user->role) }}</span>
                </p>

                @if (session('status') && session('status') !== 'profile-updated')
                    <p class="text-sm text-green-600 mb-3">{{ session('status') }}</p>
                @endif

                {{-- Form pendaftaran seller hanya jika user belum jadi seller --}}
                @if ($user->role !== 'seller')
         <form method="POST" action="{{ route('profile.becomeSeller') }}" class="space-y-4">
        @csrf
        
        {{-- Nama Toko --}}
        <div>
            <label for="store_name" class="block text-sm font-medium text-gray-700">Nama Toko</label>
            <input type="text" id="store_name" name="store_name" class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300" required>
        </div>

        {{-- Deskripsi Toko --}}
        <div>
            <label for="store_about" class="block text-sm font-medium text-gray-700">Deskripsi Toko</label>
            <textarea id="store_about" name="store_about" rows="4" class="mt-1 block w-full px-4 py-2 rounded-lg border border-gray-300" required></textarea>
        </div>

        {{-- Nomor Telepon --}}
        <div>
            <label for="store_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
            <input type="text" id="store_phone" name="store_phone" class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300" required>
        </div>

        {{-- Alamat --}}
        <div>
            <label for="store_address" class="block text-sm font-medium text-gray-700">Alamat</label>
            <input type="text" id="store_address" name="store_address" class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300" required>
        </div>

        {{-- Kota --}}
        <div>
            <label for="store_city" class="block text-sm font-medium text-gray-700">Kota</label>
            <input type="text" id="store_city" name="store_city" class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300" required>
        </div>

        {{-- Kode Pos --}}
        <div>
            <label for="store_postcode" class="block text-sm font-medium text-gray-700">Kode Pos</label>
            <input type="text" id="store_postcode" name="store_postcode" class="mt-1 w-full px-4 py-2 rounded-lg border border-gray-300" required>
        </div>

        <button type="submit" class="px-4 py-2 border border-gray-800 rounded-md text-sm hover:bg-gray-100">
            Daftar jadi seller
        </button>
        </form>
        @else
        <p class="text-sm text-gray-700">
        Kamu sudah terdaftar sebagai seller.
        </p>
        @endif
            </div>

        </div>
    </main>

</body>

</html>