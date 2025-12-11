<!-- Admin Dashboard Blade (example) -->
@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">
    <!-- HEADER -->
    <div class="bg-primary pt-12 pb-24 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <i class="fa-solid fa-bag-shopping text-9xl absolute -bottom-10 -right-10 text-white transform rotate-12"></i>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2"></h1>
            <p class="text-indigo-100 text-sm"></p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- SIDEBAR ADMIN -->
            <div class="w-full lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                    <div class="p-6 bg-slate-50 border-b border-slate-100 flex flex-col items-center text-center">
                        <div class="w-20 h-20 rounded-full bg-rose-100 flex items-center justify-center text-rose-600 text-2xl font-bold mb-3 border-4 border-white shadow-sm">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">{{ Auth::user()->name }}</h3>
                        <p class="text-sm text-slate-500 mb-3">{{ Auth::user()->email }}</p>

                        <span class="text-xs font-bold px-3 py-1 rounded-full bg-rose-100 text-rose-600">Administrator</span>
                    </div>

                    <nav class="p-4 space-y-1">
                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Admin</div>

                        <a href="{{ route('admin.store.verification') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.store.verification') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-circle-check w-5"></i> Verifikasi Toko
                        </a>

                        <a href="{{ route('admin.management') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('admin.management') ? 'text-indigo-600 bg-indigo-50' : 'text-slate-600 hover:bg-slate-50' }} rounded-xl font-medium transition">
                            <i class="fa-solid fa-users-gear w-5"></i> Manajemen User & Toko
                        </a>

                        <div class="border-t border-slate-100 my-2"></div>

                        <div class="px-4 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Akun</div>

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-slate-600 hover:bg-slate-50 rounded-xl font-medium transition">
                            <i class="fa-solid fa-user-pen w-5"></i> Edit Akun User
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50 rounded-xl font-medium transition mt-4">
                                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-slate-800">Ringkasan Aktivitas Admin</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-indigo-500 hover:shadow-md transition group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-slate-500 mb-1 group-hover:text-indigo-600 transition font-bold">Pengajuan Toko</div>
                                    <div class="text-2xl font-bold text-slate-800">-</div>
                                </div>
                                <div class="w-12 h-12 bg-rose-100 rounded-full flex items-center justify-center text-rose-600 group-hover:bg-rose-200 transition">
                                    <i class="fa-solid fa-store text-xl"></i>
                                </div>
                            </div>
                        </a>

                        <a class="block bg-white p-6 rounded-2xl shadow-sm border border-slate-200 hover:border-indigo-500 hover:shadow-md transition group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm text-slate-500 mb-1 group-hover:text-indigo-600 transition font-bold">Total User</div>
                                    <div class="text-2xl font-bold text-slate-800">-</div>
                                </div>
                                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 group-hover:bg-blue-200 transition">
                                    <i class="fa-solid fa-users text-xl"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="bg-slate-50 rounded-xl p-10 text-center border-2 border-dashed border-slate-200 mt-10">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-white text-slate-300 mb-4 shadow-sm">
                            <i class="fa-solid fa-clipboard-list text-3xl"></i>
                        </div>
                        <h3 class="font-bold text-slate-800 text-lg">Tidak ada data ditampilkan</h3>
                        <p class="text-slate-500 mt-2 mb-6">Pilih menu di sidebar untuk mulai mengelola sistem.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection