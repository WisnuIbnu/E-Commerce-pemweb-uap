<x-seller-layout title="Daftar Toko">

<div class="max-w-3xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">Daftar Toko</h1>

    @if(session('success')) <div class="bg-green-50 p-3 rounded mb-4">{{ session('success') }}</div> @endif
    @if($errors->any())
        <div class="bg-red-50 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.store.register') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow">
        @csrf

        <label class="block mb-2 font-medium">Nama Toko</label>
        <input name="name" class="w-full border p-2 mb-3" required>

        <label class="block mb-2 font-medium">Logo (opsional)</label>
        <input name="logo" type="file" class="w-full mb-3">

        <label class="block mb-2 font-medium">Tentang Toko</label>
        <textarea name="about" class="w-full border p-2 mb-3" rows="4" required></textarea>

        <label class="block mb-2 font-medium">Telepon</label>
        <input name="phone" class="w-full border p-2 mb-3" required>

        <label class="block mb-2 font-medium">Kota</label>
        <input name="city" class="w-full border p-2 mb-3" required>

        <label class="block mb-2 font-medium">Alamat</label>
        <input name="address" class="w-full border p-2 mb-3" required>

        <label class="block mb-2 font-medium">Kode Pos</label>
        <input name="postal_code" class="w-full border p-2 mb-3" required>

        <button class="bg-sweet-500 text-white px-4 py-2 rounded">Kirim Permintaan Daftar</button>
    </form>
</div>

</x-seller-layout>
