<x-seller-layout title="Profil Toko">

<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Profil Toko</h1>

    <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Nama Toko</label>
        <input name="name" value="{{ old('name', $store->name) }}" class="w-full border p-2 mb-3" required>

        <label class="block mb-2 font-medium">Logo</label>
        @if($store->logo)
            <img src="{{ asset('storage/'.$store->logo) }}" class="w-28 h-28 object-cover mb-2">
        @endif
        <input name="logo" type="file" class="w-full mb-3">

        <label class="block mb-2 font-medium">Tentang</label>
        <textarea name="about" class="w-full border p-2 mb-3" rows="4">{{ old('about', $store->about) }}</textarea>

        <label class="block mb-2 font-medium">Telepon</label>
        <input name="phone" value="{{ old('phone', $store->phone) }}" class="w-full border p-2 mb-3">

        <label class="block mb-2 font-medium">Kota</label>
        <input name="city" value="{{ old('city', $store->city) }}" class="w-full border p-2 mb-3">

        <label class="block mb-2 font-medium">Alamat</label>
        <input name="address" value="{{ old('address', $store->address) }}" class="w-full border p-2 mb-3">

        <label class="block mb-2 font-medium">Kode Pos</label>
        <input name="postal_code" value="{{ old('postal_code', $store->postal_code) }}" class="w-full border p-2 mb-3">

        <h3 class="font-semibold mt-4">Informasi Bank</h3>
        <label class="block mb-2 font-medium">Nama Bank</label>
        <input name="bank_name" value="{{ old('bank_name', $store->bank_name) }}" class="w-full border p-2 mb-3">

        <label class="block mb-2 font-medium">Nama Rekening</label>
        <input name="bank_account_name" value="{{ old('bank_account_name', $store->bank_account_name) }}" class="w-full border p-2 mb-3">

        <label class="block mb-2 font-medium">Nomor Rekening</label>
        <input name="bank_account_number" value="{{ old('bank_account_number', $store->bank_account_number) }}" class="w-full border p-2 mb-3">

        <button class="bg-sweet-500 text-white px-4 py-2 rounded">Simpan Perubahan</button>
    </form>
</div>

</x-seller-layout>
