<x-seller-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            Pendaftaran Toko Sembako
        </h2>
    </x-slot>

    <div class="py-10 bg-gradient-to-br from-orange-50 via-white to-orange-50 min-h-screen">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-xl rounded-2xl px-8 py-8">

                {{-- ALERT VALIDASI --}}
                @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-300 px-4 py-3 text-sm text-red-700">
                    <p class="font-semibold mb-1">Oops, ada yang belum benar:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif


                <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    {{-- Nama Pemilik --}}
                    <div>
                        <label class="block font-medium">Nama Pemilik</label>
                        <input type="text" class="w-full rounded-lg" value="{{ Auth::user()->name }}" disabled>
                    </div>

                    {{-- Nama Toko --}}
                    <div>
                        <label class="block font-medium">Nama Toko</label>
                        <input type="text" name="name" required
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Masukkan nama toko">
                            @error('name')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Logo --}}
                    <div>
                        <label class="block font-medium">Logo Toko</label>
                        <input type="file" name="logo" accept="image/*" class="block w-full">
                        @error('logo')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- About --}}
                    <div>
                        <label class="block font-medium">Deskripsi Toko</label>
                        <textarea name="about" rows="3" class="w-full rounded-lg border-gray-300"
                            placeholder="Tuliskan deskripsi toko"></textarea>
                            @error('about')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label class="block font-medium">Nomor Telepon</label>
                        <input type="tel" name="phone" required class="w-full rounded-lg border-gray-300"
                            placeholder="08xxxxxxxxxx">
                            @error('phone')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- City --}}
                    <div>
                        <label class="block font-medium">Kota</label>
                        <input type="text" name="city" required class="w-full rounded-lg border-gray-300">
                        @error('city')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block font-medium">Alamat Lengkap</label>
                        <textarea name="address" rows="2" required
                            class="w-full rounded-lg border-gray-300"></textarea>
                            @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Postal Code --}}
                    <div>
                        <label class="block font-medium">Kode Pos</label>
                        <input type="text" name="postal_code" required class="w-full rounded-lg border-gray-300">
                        @error('postal_code')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-lg bg-orange-500 text-white hover:bg-orange-600">
                        Daftarkan Toko
                    </button>

                </form>
            </div>
        </div>
    </div>

</x-seller-layout>