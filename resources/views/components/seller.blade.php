<!-- resources/views/components/seller.blade.php -->
@props(['title' => 'Seller Dashboard'])

<x-user-layout :title="$title">
    <div class="min-h-screen bg-softgray">
        <div class="flex">
            {{-- sidebar --}}
            <aside class="w-64 bg-white p-5 border-r hidden md:block">
                <h3 class="font-bold text-lg mb-4">Seller Menu</h3>

                <nav class="flex flex-col gap-2">
                    <a href="{{ route('seller.dashboard') }}" class="block py-2 px-3 rounded hover:bg-softgray">Dashboard</a>
                    <a href="{{ route('seller.products.index') }}" class="block py-2 px-3 rounded hover:bg-softgray">Produk</a>
                    <a href="{{ route('seller.categories.index') }}" class="block py-2 px-3 rounded hover:bg-softgray">Kategori</a>
                    <a href="{{ route('seller.orders.index') }}" class="block py-2 px-3 rounded hover:bg-softgray">Pesanan</a>
                    <a href="{{ route('seller.wallet') }}" class="block py-2 px-3 rounded hover:bg-softgray">Saldo</a>
                    <a href="{{ route('seller.withdraw') }}" class="block py-2 px-3 rounded hover:bg-softgray">Penarikan</a>
                    <a href="{{ route('seller.store.profile') }}" class="block py-2 px-3 rounded hover:bg-softgray">Profil Toko</a>
                </nav>
            </aside>

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-user-layout>
