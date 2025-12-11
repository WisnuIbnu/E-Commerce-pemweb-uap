@props(['title' => 'Seller Panel'])

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }} - SweetMart Seller</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

    {{-- SIDEBAR SELLER --}}
    <div class="flex">

        <aside class="w-64 bg-white shadow h-screen sticky top-0 p-6">

            <h2 class="text-xl font-bold mb-6 text-sweet-500">Seller Panel</h2>

            <nav class="flex flex-col gap-3 text-[15px]">

                <a href="{{ route('seller.dashboard') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.dashboard') ? 'font-bold text-sweet-500' : '' }}">
                    Dashboard
                </a>

                <a href="{{ route('seller.products.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.products.*') ? 'font-bold text-sweet-500' : '' }}">
                    Produk
                </a>

                <a href="{{ route('seller.categories.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.categories.*') ? 'font-bold text-sweet-500' : '' }}">
                    Kategori Produk
                </a>

                <a href="{{ route('seller.orders.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.orders.*') ? 'font-bold text-sweet-500' : '' }}">
                    Pesanan
                </a>

                <a href="{{ route('seller.store.profile') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.store.profile') ? 'font-bold text-sweet-500' : '' }}">
                    Profil Toko
                </a>

                <a href="{{ route('seller.balance.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.balance.*') ? 'font-bold text-sweet-500' : '' }}">
                    Saldo Toko
                </a>

                <a href="{{ route('seller.withdraw.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.withdraw.*') ? 'font-bold text-sweet-500' : '' }}">
                    Penarikan Dana
                </a>

                <a href="{{ route('seller.bank.index') }}"
                    class="hover:text-sweet-500 {{ request()->routeIs('seller.bank.*') ? 'font-bold text-sweet-500' : '' }}">
                    Informasi Bank
                </a>

            </nav>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

    </div>

</body>
</html>
