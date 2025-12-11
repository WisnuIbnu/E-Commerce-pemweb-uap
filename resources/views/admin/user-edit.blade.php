{{-- resources/views/admin/user-edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="bg-slate-50 min-h-screen pb-12">

    {{-- HEADER ATAS --}}
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

        {{-- ⭐ NAVBAR FLOATING MODERN --}}
<div class="w-full bg-white rounded-2xl shadow-md px-6 py-4 mb-6 flex items-center justify-between border border-slate-200">

    {{-- Back Button --}}
    <a href="{{ route('admin.management') }}"
       class="text-slate-500 hover:text-slate-700 text-sm font-medium flex items-center gap-1">
        <i class="fa-solid fa-arrow-left text-sm"></i> Kembali
    </a>

    {{-- Center Title --}}
    <div class="absolute left-1/2 transform -translate-x-1/2">
        <span class="text-lg font-semibold text-slate-800 tracking-tight">
            Edit User
        </span>
    </div>

    {{-- Save Button --}}
    <button form="editUserForm"
            class="bg-primary hover:bg-primary-dark text-black px-5 py-2.5 rounded-full text-sm font-semibold shadow">
        Save
    </button>

</div>



        <div class="flex flex-col lg:flex-row gap-8">

            {{-- MAIN CONTENT --}}
            <div class="flex-1">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">

                    <h2 class="text-xl font-bold text-slate-800 mb-1">Informasi User</h2>
                    <p class="text-sm text-slate-500 mb-6">Kelola data user dan role akses.</p>

                    {{-- ALERT SUCCESS --}}
                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 rounded-xl bg-green-50 text-green-700 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- FORM EDIT USER --}}
                    <form id="editUserForm"
                          action="{{ route('admin.user.update', $user->id) }}"
                          method="POST"
                          class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="w-full rounded-xl border border-slate-300 h-11 px-3 text-sm focus:ring-primary focus:border-primary">
                            </div>

                            {{-- Email --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="w-full rounded-xl border border-slate-300 h-11 px-3 text-sm focus:ring-primary focus:border-primary">
                            </div>

                            {{-- Role --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Role</label>
                                <select name="role"
                                        class="w-full rounded-xl border border-slate-300 h-11 px-3 text-sm focus:ring-primary focus:border-primary">
                                    <option value="admin"  {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="seller" {{ $user->role === 'seller' ? 'selected' : '' }}>Seller</option>
                                    <option value="member" {{ $user->role === 'member' ? 'selected' : '' }}>Member</option>
                                </select>
                            </div>

                            {{-- Toko yang dimiliki --}}
                            <div>
                                <label class="block text-xs font-bold text-slate-600 uppercase mb-1">Toko yang dimiliki</label>
                                <div class="h-11 flex items-center rounded-xl border border-slate-200 px-3 text-sm bg-slate-50">
                                    {{ $user->store->name ?? '-' }}
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.management') }}"
                           class="text-sm text-slate-500 hover:text-slate-700 inline-block mt-2">
                           ← Kembali ke Manajemen User & Toko
                        </a>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
