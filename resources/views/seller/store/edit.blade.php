{{-- resources/views/seller/store/edit.blade.php --}}
<x-seller-layout>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#f97316',
            });
        });
    </script>
    @endif

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#f97316',
            });
        });
    </script>
    @endif

    <div class="py-8">
        <div class="max-w-5xl mx-auto space-y-6">

            {{-- BREADCRUMB --}}
            <div class="text-sm text-gray-500">
                <a href="{{ route('seller.dashboard') }}" class="hover:text-orange-500">Dashboard Toko</a>
                <span class="mx-1">/</span>
                <span class="text-gray-700 font-medium">Pengaturan Toko</span>
            </div>

            {{-- HEADER --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Pengaturan Toko</h1>
                    <p class="text-sm text-gray-500 mt-1">
                        Kelola informasi profil toko dan rekening untuk penarikan saldo.
                    </p>
                </div>

                @if($store?->status === 'verified' || $store?->is_verified)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1.5"></span>
                    Toko sudah terverifikasi
                </span>
                @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 mr-1.5"></span>
                    Menunggu verifikasi admin
                </span>
                @endif
            </div>

            {{-- FORM --}}
            <form action="{{ route('seller.store.update') }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6">
                    {{-- PROFIL TOKO --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold text-gray-800">Profil Toko</h2>
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-orange-50 text-orange-500 border border-orange-100">
                                Wajib diisi
                            </span>
                        </div>

                        {{-- Nama Toko --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Nama Toko <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $store->name ?? '') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                placeholder="Misal: Sembako Jaya Makmur">
                            @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Kota --}}
                        <div class="grid grid-cols-1 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Kota <span class="text-red-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="city"
                                    value="{{ old('city', $store->city ?? '') }}"
                                    class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                    placeholder="Contoh: Malang">
                                @error('city')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Alamat Lengkap --}}
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Alamat Lengkap <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                name="address"
                                rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-orange-400 focus:ring-orange-400 text-sm"
                                placeholder="Jl. Contoh No. 123, RT 01 RW 02, Kelurahan, Kecamatan">{{ old('address', $store->address ?? '') }}</textarea>

                            @error('address')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- KOLOM REKENING BANK --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                        <h2 class="text-sm font-semibold text-gray-700">Rekening Bank</h2>

                        {{-- NAMA BANK --}}
                        <div>
                            <label for="bank_name" class="block text-xs font-medium text-gray-700 mb-1">
                                Nama Bank <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="bank_name"
                                name="bank_name"
                                required
                                class="w-full rounded-lg border-gray-300 text-sm
                       focus:border-orange-400 focus:ring-orange-400
                       @error('bank_name') border-red-500 ring-red-300 @enderror">
                                <option value="">-- Pilih Bank --</option>
                                <option value="BCA" {{ old('bank_name', $store->bank_name) === 'BCA'  ? 'selected' : '' }}>BCA</option>
                                <option value="BRI" {{ old('bank_name', $store->bank_name) === 'BRI'  ? 'selected' : '' }}>BRI</option>
                                <option value="BNI" {{ old('bank_name', $store->bank_name) === 'BNI'  ? 'selected' : '' }}>BNI</option>
                                <option value="Mandiri" {{ old('bank_name', $store->bank_name) === 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                <option value="CIMB Niaga" {{ old('bank_name', $store->bank_name) === 'CIMB Niaga' ? 'selected' : '' }}>CIMB Niaga</option>
                                {{-- tambah bank lain kalau mau --}}
                            </select>
                        </div>

                        {{-- NOMOR REKENING --}}
                        <div>
                            <label for="bank_account_number" class="block text-xs font-medium text-gray-700 mb-1">
                                Nomor Rekening <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="bank_account_number"
                                type="text"
                                name="bank_account_number"
                                required
                                value="{{ old('bank_account_number', $store->bank_account_number) }}"
                                class="w-full rounded-lg border-gray-300 text-sm
                       focus:border-orange-400 focus:ring-orange-400
                       @error('bank_account_number') border-red-500 ring-red-300 @enderror"
                                placeholder="Contoh: 1234567890">
                        </div>

                        {{-- ATAS NAMA REKENING --}}
                        <div>
                            <label for="bank_account_name" class="block text-xs font-medium text-gray-700 mb-1">
                                Atas Nama Rekening <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="bank_account_name"
                                type="text"
                                name="bank_account_name"
                                required
                                value="{{ old('bank_account_name', $store->bank_account_name) }}"
                                class="w-full rounded-lg border-gray-300 text-sm
                                focus:border-orange-400 focus:ring-orange-400
                                @error('bank_account_name') border-red-500 ring-red-300 @enderror"
                                placeholder="Nama pemilik rekening">
                        </div>

                        <p class="text-[11px] text-orange-600 bg-orange-50 px-3 py-2 rounded-lg flex items-start gap-2">
                            <span class="mt-0.5">⚠️</span>
                            <span>Pastikan data rekening benar. Admin akan menggunakan data ini ketika Anda menarik saldo.</span>
                        </p>
                    </div>
                </div>
                {{-- BUTTON AREA (DI LUAR GRID) --}}
                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('seller.dashboard') }}"
                        class="px-4 py-2 text-sm rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Batal
                    </a>

                    <button type="submit"
                        id="save-button"
                        class="px-4 py-2 text-sm rounded-lg bg-orange-500 text-white font-semibold hover:bg-orange-600
                       disabled:opacity-50 disabled:cursor-not-allowed">
                        Simpan Perubahan
                    </button>
                </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankName = document.getElementById('bank_name');
            const bankNumber = document.getElementById('bank_account_number');
            const bankAccountName = document.getElementById('bank_account_name');
            const saveButton = document.getElementById('save-button');

            if (!bankName || !bankNumber || !bankAccountName || !saveButton) {
                // kalau ada yang nggak ketemu, jangan apa-apa biar nggak error
                return;
            }

            const requiredFields = [bankName, bankNumber, bankAccountName];

            function toggleState() {
                let allFilled = true;

                requiredFields.forEach((field) => {
                    const value = (field.value || '').trim();

                    if (!value) {
                        allFilled = false;
                        field.classList.add('border-red-400', 'focus:border-red-500', 'focus:ring-red-400');
                    } else {
                        field.classList.remove('border-red-400', 'focus:border-red-500', 'focus:ring-red-400');
                    }
                });

                if (allFilled) {
                    saveButton.disabled = false;
                } else {
                    saveButton.disabled = true;
                }
            }

            // Cek pertama kali saat halaman load
            toggleState();

            // Pas user ngetik / ganti pilihan
            requiredFields.forEach((field) => {
                field.addEventListener('input', toggleState);
                field.addEventListener('change', toggleState);
            });
        });
    </script>
</x-seller-layout>