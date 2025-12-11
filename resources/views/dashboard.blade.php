<x-app-layout>
    {{-- HEADER / HERO --}}
    <div class="bg-slate-950">
        <div class="relative overflow-hidden">
            <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_top,_rgba(59,130,246,0.6),_transparent_55%),_radial-gradient(circle_at_bottom,_rgba(56,189,248,0.4),_transparent_55%)]"></div>

            <header class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-6 lg:pt-12 lg:pb-8 flex flex-col gap-4">
                <div>
                    <p class="text-xs font-semibold tracking-[0.25em] uppercase text-sky-300/80">
                        Electrify your shopping
                    </p>
                    <h1 class="mt-3 text-3xl md:text-4xl lg:text-5xl font-extrabold text-white leading-tight">
                        Welcome, {{ Auth::user()->name }} 👋
                    </h1>
                    <p class="mt-3 text-sm md:text-base text-slate-200 max-w-xl">
                        ElecTrend, your trusted destination for discovering, selling, and managing quality electronics in one modern ecosystem.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <span class="inline-flex items-center gap-2 rounded-full border border-sky-400/40 bg-slate-900/60 px-3 py-1 text-[11px] font-medium text-sky-100 backdrop-blur">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Role:
                        <span class="capitalize">
                            {{ Auth::user()->role }}
                        </span>
                    </span>
                </div>
            </header>
        </div>

        {{-- MAIN --}}
        <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12 lg:pb-16">
            {{-- WELCOME BOX --}}
            <section class="mt-4 mb-8">
                <div class="relative overflow-hidden rounded-2xl border border-slate-700/60 bg-slate-900/80 shadow-[0_18px_45px_rgba(15,23,42,0.7)] backdrop-blur-md">
                    <div class="absolute inset-0 opacity-40 bg-[radial-gradient(circle_at_top_left,_rgba(59,130,246,0.5),_transparent_55%),_radial-gradient(circle_at_bottom_right,_rgba(37,99,235,0.4),_transparent_55%)]"></div>

                    <div class="relative px-6 py-6 sm:px-8 sm:py-7 lg:px-10 lg:py-9 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            {{-- TITLE & COPY PER ROLE --}}
                            @if(Auth::user()->role === 'customer')
                                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                                    Your Smart Shopping Hub
                                </h2>

                                <p class="mt-3 text-sm md:text-base text-slate-200/95 leading-relaxed max-w-2xl">
                                    Jelajahi semua produk elektronik, filter berdasarkan kategori, dan temukan produk yang paling sesuai dengan kebutuhanmu.
                                    Kelola keranjang belanja, isi detail pembayaran, dan selesaikan pesananmu dengan alur checkout yang sederhana dan aman.
                                    Lihat kembali riwayat transaksi untuk mengecek detail pembelian dan status pesanan kapan saja.
                                </p>

                            @elseif(Auth::user()->role === 'seller')
                                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                                    Your Store Control Center
                                </h2>

                                <p class="mt-3 text-sm md:text-base text-slate-200/95 leading-relaxed max-w-2xl">
                                    Bangun profil toko yang profesional dan kelola seluruh katalog produk, termasuk kategori dan gambar produk dalam satu tempat.
                                    Pantau dan perbarui pesanan masuk, atur informasi pengiriman dan nomor resi agar pelanggan selalu terinformasi.
                                    Kendalikan kesehatan finansial tokomu dengan melihat saldo, riwayat saldo, dan mengajukan penarikan ke rekening bank yang kamu kelola sendiri.
                                </p>

                            @else
                                <h2 class="text-2xl md:text-3xl font-bold text-white tracking-tight">
                                    Admin Control Panel
                                </h2>

                                <p class="mt-3 text-sm md:text-base text-slate-200/95 leading-relaxed max-w-2xl">
                                    Tinjau dan verifikasi pengajuan toko baru untuk memastikan hanya penjual terpercaya yang aktif di ElecTrend.
                                    Lihat dan kelola data seluruh pengguna dan toko terdaftar untuk menjaga keamanan, kualitas layanan, dan kelancaran operasional platform.
                                </p>
                            @endif
                        </div>

                        <div class="flex flex-col items-start md:items-end gap-3 text-xs text-slate-300">
                            <p class="font-semibold text-sky-300 uppercase tracking-[0.18em]">
                                Quick overview
                            </p>
                            <p class="max-w-xs">
                                Gunakan kartu fitur di bawah untuk mengakses menu utama sesuai peran akun kamu.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            {{-- FEATURES GRID --}}
            <section>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-7">

                    {{-- CUSTOMER DASHBOARD --}}
                    @if(Auth::user()->role === 'customer')
                        @component('components.dashboard-card', [
                            'title' => 'Browse All Products',
                            'icon'  => 'tv',
                            'link'  => route('products')
                        ])
                            Explore all electronics available in the store.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Browse by Category',
                            'icon'  => 'layer-group',
                            'link'  => route('product.category', 1)
                        ])
                            Filter electronics by category.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Check Out',
                            'icon'  => 'shopping-cart',
                            'link'  => route('cart.index')
                        ])
                            Complete your purchase for selected products.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Transaction History',
                            'icon'  => 'receipt',
                            'link'  => route('transaction.history')
                        ])
                            View your previous purchases.
                        @endcomponent
                    @endif

                    {{-- SELLER DASHBOARD --}}
                    @if(Auth::user()->role === 'seller')
                        @component('components.dashboard-card', [
                            'title' => 'Store Profile',
                            'icon'  => 'store',
                            'link'  => route('seller.store')
                        ])
                            Create or manage your store profile.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Order Management',
                            'icon'  => 'box',
                            'link'  => route('seller.orders')
                        ])
                            View and process customer orders.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Balance & Withdraw',
                            'icon'  => 'wallet',
                            'link'  => route('seller.balance')
                        ])
                            Check earnings and request withdrawals.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Manage Products',
                            'icon'  => 'tags',
                            'link'  => route('seller.products.index')
                        ])
                            Add, update, or delete products.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'Manage Categories',
                            'icon'  => 'folder-tree',
                            'link'  => route('categories.index')
                        ])
                            Organize products into categories.
                        @endcomponent
                    @endif

                    {{-- ADMIN DASHBOARD --}}
                    @if(Auth::user()->role === 'admin')
                        @component('components.dashboard-card', [
                            'title' => 'Store Verification',
                            'icon'  => 'check-circle',
                            'link'  => route('admin.stores')
                        ])
                            Verify or reject seller store applications.
                        @endcomponent

                        @component('components.dashboard-card', [
                            'title' => 'User & Store Management',
                            'icon'  => 'users-cog',
                            'link'  => route('admin.users')
                        ])
                            Manage users and store data.
                        @endcomponent
                    @endif

                </div>
            </section>
        </main>
    </div>
</x-app-layout>
