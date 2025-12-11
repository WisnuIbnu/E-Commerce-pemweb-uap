<x-app-layout>
    <x-slot name="header">
        <div class="rounded-2xl bg-gradient-to-r from-blue-700 to-blue-500 text-white px-6 py-8 shadow-xl">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <span class="text-3xl">🏬</span>
                    <h2 class="font-semibold text-2xl">
                        Your Store Overview
                    </h2>
                </div>
                <p class="text-sm text-blue-100">
                    Kelola profil toko, informasi kontak, dan alamat usahamu di ElecTrend.
                </p>
            </div>
        </div>
    </x-slot>

<div class="bg-gray-900 min-h-screen text-gray-100 py-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="bg-gray-900 border border-gray-800 rounded-3xl p-6 md:p-8 shadow-2xl">
                @if(!$store)
                    <h3 class="text-lg font-bold mb-4 text-gray-100">Create Store</h3>

                    <form action="{{ route('seller.store.create') }}" method="POST" enctype="multipart/form-data"
                          class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-sm text-gray-200">Store Name</label>
                                <input type="text" name="name"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Logo</label>
                                <input type="file" name="logo"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400">
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-sm text-gray-200">About</label>
                                <textarea name="about" rows="3"
                                          class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                          required></textarea>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Phone</label>
                                <input type="text" name="phone"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Address ID</label>
                                <input type="text" name="address_id"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">City</label>
                                <input type="text" name="city"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Postal Code</label>
                                <input type="text" name="postal_code"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-sm text-gray-200">Full Address</label>
                                <textarea name="address" rows="3"
                                          class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                          required></textarea>
                            </div>
                        </div>

                        <button
                            class="bg-blue-500 hover:bg-blue-400 text-white px-4 py-2 mt-4 rounded shadow transition-colors">
                            Create Store
                        </button>
                    </form>
                @else
                    <h3 class="text-lg font-bold mb-4 text-gray-100">Update Store</h3>

                    <form action="{{ route('seller.store.update', $store->id) }}" method="POST" enctype="multipart/form-data"
                          class="bg-gray-800 border border-gray-700 rounded-2xl p-6 shadow-xl">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="font-semibold text-sm text-gray-200">Store Name</label>
                                <input type="text" name="name" value="{{ $store->name }}"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Logo</label>
                                <input type="file" name="logo"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400">
                                @if($store->logo)
                                    <img src="{{ asset('storage/'.$store->logo) }}" class="w-20 mt-2 rounded-lg border border-gray-600">
                                @endif
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-sm text-gray-200">About</label>
                                <textarea name="about" rows="3"
                                          class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                          required>{{ $store->about }}</textarea>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Phone</label>
                                <input type="text" name="phone" value="{{ $store->phone }}"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Address ID</label>
                                <input type="text" name="address_id" value="{{ $store->address_id }}"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">City</label>
                                <input type="text" name="city" value="{{ $store->city }}"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div>
                                <label class="font-semibold text-sm text-gray-200">Postal Code</label>
                                <input type="text" name="postal_code" value="{{ $store->postal_code }}"
                                       class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="font-semibold text-sm text-gray-200">Full Address</label>
                                <textarea name="address" rows="3"
                                          class="mt-1 border border-gray-600 bg-gray-900 text-gray-100 p-2 w-full rounded focus:outline-none focus:border-blue-400"
                                          required>{{ $store->address }}</textarea>
                            </div>
                        </div>

                        <button
                            class="bg-green-500 hover:bg-green-400 text-white px-4 py-2 mt-4 rounded shadow transition-colors">
                            Update Store
                        </button>
                    </form>

                    <form action="{{ route('seller.store.delete', $store->id) }}" method="POST" class="mt-4">
                        @csrf
                        @method('DELETE')
                        <button
                            class="bg-red-500 hover:bg-red-400 text-white px-4 py-2 rounded shadow transition-colors">
                            Delete Store
                        </button>
                    </form>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
