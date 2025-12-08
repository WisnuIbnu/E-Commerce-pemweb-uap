@extends('layouts.app')

@section('title', 'Profil Saya - Tumbloo')

@section('content')
    <!-- Profile Header Section -->
    <div class="relative border-b border-tumbloo-accent w-full">
        <!-- Background with opacity -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30"
            style="background-image: url('{{ asset('images/background.png') }}');">
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Success Message -->
            @if(session('success'))
                <div
                    class="mb-6 bg-green-500/10 border border-green-500 text-green-400 px-6 py-4 rounded-lg max-w-2xl mx-auto text-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Profile Header Card - Landscape -->
            <div class="flex justify-center">
                <div class="bg-tumbloo-dark rounded-xl border border-tumbloo-accent overflow-hidden inline-block">

                    <!-- Profile Info - Horizontal Layout -->
                    <div class="px-8 py-6">
                        <div class="flex items-end gap-6">
                            <!-- Avatar -->
                            <div
                                class="h-24 w-24 rounded-full bg-tumbloo-accent border-4 border-tumbloo-dark flex items-center justify-center text-4xl font-bold shadow-xl flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>

                            <!-- User Info & Button -->
                            <div class="flex items-end justify-between gap-8 flex-1 pb-1">
                                <!-- User Info -->
                                <div>
                                    <h1 class="text-2xl font-bold text-tumbloo-white mb-1">{{ $user->name }}</h1>
                                    <p class="text-sm text-tumbloo-gray mb-2">{{ $user->email }}</p>
                                </div>

                                <!-- Edit Button -->
                                <a href="{{ route('profile.edit') }}"
                                    class="inline-flex items-center gap-2 bg-tumbloo-accent hover:bg-tumbloo-accent-light text-white px-5 py-2 rounded-lg text-sm font-semibold transition whitespace-nowrap">
                                    Edit Profil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-tumbloo-dark min-h-screen py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Left Column: Profile Details -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Personal Information Card -->
                    <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-6 flex items-center gap-2">
                            <i class="fas fa-user-circle text-tumbloo-accent"></i>
                            Informasi Pribadi
                        </h2>

                        <div class="space-y-4">
                            <!-- Name -->
                            <div class="flex items-start gap-4 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div
                                    class="h-10 w-10 rounded-lg bg-blue-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-tumbloo-gray mb-1">Nama Lengkap</p>
                                    <p class="text-tumbloo-white font-medium">{{ $user->name }}</p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="flex items-start gap-4 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div
                                    class="h-10 w-10 rounded-lg bg-purple-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-tumbloo-gray mb-1">Alamat Email</p>
                                    <p class="text-tumbloo-white font-medium">{{ $user->email }}</p>
                                </div>
                            </div>

                            <!-- Role -->
                            <div class="flex items-start gap-4 p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div
                                    class="h-10 w-10 rounded-lg bg-orange-200 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-shield-alt text-white text-sm"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm text-tumbloo-gray mb-1">Role</p>
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400 border border-purple-500/30' : 'bg-blue-500/20 text-blue-400 border border-blue-500/30' }}">
                                        <i class="fas fa-{{ $user->role === 'admin' ? 'crown' : 'user' }}"></i>
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Activity Card -->
                    <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-6 flex items-center gap-2">
                            <i class="fas fa-clock text-tumbloo-accent"></i>
                            Aktivitas Akun
                        </h2>

                        <div class="space-y-4">
                            <!-- Created At -->
                            <div
                                class="flex items-center justify-between p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-green-500/20 flex items-center justify-center">
                                        <i class="fas fa-calendar-plus text-green-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-tumbloo-gray">Bergabung Sejak</p>
                                        <p class="text-tumbloo-white font-medium">{{ $user->created_at->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs text-tumbloo-gray">{{ $user->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Updated At -->
                            <div
                                class="flex items-center justify-between p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                        <i class="fas fa-sync text-blue-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-tumbloo-gray">Terakhir Diperbarui</p>
                                        <p class="text-tumbloo-white font-medium">{{ $user->updated_at->format('d F Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-xs text-tumbloo-gray">{{ $user->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Quick Actions -->
                <div class="space-y-6">

                    <!-- Quick Actions Card -->
                    <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-6 flex items-center gap-2">
                            <i class="fas fa-bolt text-tumbloo-accent"></i>
                            Aksi Cepat
                        </h2>

                        <div class="space-y-3">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 p-4 bg-tumbloo-dark hover:bg-tumbloo-accent/10 rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition group">
                                <div
                                    class="h-10 w-10 rounded-lg bg-pink-200 flex items-center justify-center group-hover:bg-tumbloo-accent/30 transition">
                                    <i class="fas fa-th-large text-tumbloo-accent"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-tumbloo-white font-medium group-hover:text-tumbloo-accent transition">
                                        Dashboard</p>
                                    <p class="text-xs text-tumbloo-gray">Lihat statistik Anda</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-tumbloo-gray group-hover:text-tumbloo-accent transition"></i>
                            </a>

                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 p-4 bg-tumbloo-dark hover:bg-tumbloo-accent/10 rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition group">
                                <div
                                    class="h-10 w-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-tumbloo-accent/30 transition">
                                    <i class="fas fa-edit text-tumbloo-accent"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-tumbloo-white font-medium group-hover:text-tumbloo-accent transition">
                                        Edit Profil</p>
                                    <p class="text-xs text-tumbloo-gray">Perbarui informasi Anda</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-tumbloo-gray group-hover:text-tumbloo-accent transition"></i>
                            </a>

                            <a href="{{ route('settings') }}"
                                class="flex items-center gap-3 p-4 bg-tumbloo-dark hover:bg-tumbloo-accent/10 rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition group">
                                <div
                                    class="h-10 w-10 rounded-lg bg-yellow-200 flex items-center justify-center group-hover:bg-tumbloo-accent/30 transition">
                                    <i class="fas fa-cog text-tumbloo-accent"></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-tumbloo-white font-medium group-hover:text-tumbloo-accent transition">
                                        Pengaturan</p>
                                    <p class="text-xs text-tumbloo-gray">Kelola akun Anda</p>
                                </div>
                                <i
                                    class="fas fa-chevron-right text-tumbloo-gray group-hover:text-tumbloo-accent transition"></i>
                            </a>


                            @php 
                                $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
                            @endphp

                            @if($userStore)
                                @if($userStore->is_verified)
                                    {{-- Toko sudah terverifikasi → Dashboard Toko --}}
                                    <a href="{{ route('store.dashboard') }}"
                                        class="flex items-center gap-3 p-4 bg-tumbloo-dark hover:bg-tumbloo-accent/10 rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition group">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-cyan-400 flex items-center justify-center group-hover:bg-tumbloo-accent/50 transition">
                                            <i class="fas fa-store text-tumbloo-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p
                                                class="text-tumbloo-white font-bold group-hover:text-tumbloo-accent-light transition">
                                                Dashboard Toko</p>
                                            <p class="text-xs text-tumbloo-gray">Kelola toko Anda</p>
                                        </div>
                                        <i
                                            class="fas fa-chevron-right text-tumbloo-gray group-hover:text-tumbloo-accent-light transition"></i>
                                    </a>
                                @else
                                    {{-- Toko belum terverifikasi → Status Pending --}}
                                    <a href="{{ route('store.pending') }}"
                                        class="flex items-center gap-3 p-4 bg-yellow-500/10 hover:bg-yellow-500/20 rounded-lg border border-yellow-400 transition group">
                                        <div
                                            class="h-10 w-10 rounded-lg bg-yellow-400 flex items-center justify-center group-hover:bg-yellow-500 transition">
                                            <i class="fas fa-clock text-tumbloo-white"></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-yellow-300 font-bold group-hover:text-yellow-200 transition">Status Toko
                                            </p>
                                            <p class="text-xs text-yellow-200/80">Toko sedang menunggu verifikasi</p>
                                        </div>
                                        <i class="fas fa-chevron-right text-yellow-300 group-hover:text-yellow-200 transition"></i>
                                    </a>
                                @endif
                            @else
                                {{-- Belum punya toko → Ke Registrasi --}}
                                <a href="{{ route('store.register') }}"
                                    class="flex items-center gap-3 p-4 bg-tumbloo-dark hover:bg-tumbloo-accent/10 rounded-lg border border-tumbloo-accent hover:border-tumbloo-accent-light transition group">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-cyan-400 flex items-center justify-center group-hover:bg-tumbloo-accent/50 transition">
                                        <i class="fas fa-plus-circle text-tumbloo-white"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p
                                            class="text-tumbloo-white font-bold group-hover:text-tumbloo-accent-light transition">
                                            Jual Blog</p>
                                        <p class="text-xs text-tumbloo-gray">Mulai buka toko dan jual produk Anda</p>
                                    </div>
                                    <i
                                        class="fas fa-chevron-right text-tumbloo-gray group-hover:text-tumbloo-accent-light transition"></i>
                                </a>
                            @endif

                        </div>
                    </div>

                    <!-- Security Card -->
                    <div class="bg-tumbloo-black rounded-xl border border-tumbloo-accent p-6">
                        <h2 class="text-xl font-bold text-tumbloo-white mb-6 flex items-center gap-2">
                            <i class="fas fa-shield-alt text-tumbloo-accent"></i>
                            Keamanan
                        </h2>

                        <div class="space-y-4">
                            <!-- Email Verification Status -->
                            <div
                                class="p-4 rounded-lg border
                                {{ $user->email_verified_at ? 'bg-green-500/10 border-green-500/30' : 'bg-yellow-500/10 border-yellow-500/30' }}">
                                <div class="flex items-start gap-3">
                                    <i class="fas fa-{{ $user->email_verified_at ? 'check-circle' : 'exclamation-triangle' }} 
                                        {{ $user->email_verified_at ? 'text-green-400' : 'text-yellow-400' }} mt-1"></i>
                                    <div class="flex-1">
                                        <p
                                            class="font-medium {{ $user->email_verified_at ? 'text-green-400' : 'text-yellow-400' }}">
                                            {{ $user->email_verified_at ? 'Email Terverifikasi' : 'Email Belum Terverifikasi' }}
                                        </p>
                                        <p class="text-sm text-tumbloo-gray mt-1">
                                            {{ $user->email_verified_at ? 'Akun Anda aman dan terverifikasi' : 'Verifikasi email Anda untuk keamanan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Info -->
                            <div class="p-4 bg-tumbloo-dark rounded-lg border border-tumbloo-accent">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <i class="fas fa-key text-tumbloo-accent"></i>
                                        <span class="text-sm text-tumbloo-white">Password</span>
                                    </div>
                                    <a href="{{ route('settings') }}"
                                        class="text-xs text-blue-700 hover:text-blue-200 transition">
                                        Ubah →
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection