@extends('admin.layouts.layout')

@section('title', 'Edit User')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.users.show', $user->id) }}" 
            class="text-sm text-tumbloo-gray hover:text-tumbloo-black inline-flex items-center mb-2">
            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Detail User
        </a>
        <h1 class="text-3xl font-bold text-tumbloo-black">Edit User</h1>
        <p class="text-tumbloo-gray mt-1">Ubah informasi user: {{ $user->name }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <div class="card p-6">
                <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="label">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                                class="input-field @error('name') border-red-500 @enderror" required>
                            @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="label">Email <span class="text-red-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                                class="input-field @error('email') border-red-500 @enderror" required>
                            @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role -->
                        <div>
                            <label for="role" class="label">Role <span class="text-red-500">*</span></label>
                            <select id="role" name="role" class="select-field @error('role') border-red-500 @enderror" required>
                                <option value="customer" {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="seller" {{ old('role', $user->role) == 'seller' ? 'selected' : '' }}>Seller</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-sm text-tumbloo-gray mt-2">
                                <strong>Catatan:</strong> Mengubah role dapat mempengaruhi akses dan fitur yang tersedia untuk user ini.
                            </p>
                        </div>

                        <div class="divider"></div>

                        <!-- Password Section -->
                        <div class="bg-tumbloo-offwhite p-4 rounded-lg">
                            <h3 class="font-semibold text-tumbloo-black mb-3">Ubah Password (Opsional)</h3>
                            <p class="text-sm text-tumbloo-gray mb-4">Biarkan kosong jika tidak ingin mengubah password</p>

                            <div class="space-y-4">
                                <!-- New Password -->
                                <div>
                                    <label for="password" class="label">Password Baru</label>
                                    <input type="password" id="password" name="password" 
                                        class="input-field @error('password') border-red-500 @enderror">
                                    @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="label">Konfirmasi Password Baru</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" 
                                        class="input-field">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center space-x-4 pt-4">
                            <button type="submit" class="btn-primary">
                                <svg class="h-5 w-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn-secondary">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Current Info -->
            <div class="card p-6">
                <h2 class="text-xl font-bold text-tumbloo-black mb-4">Informasi Saat Ini</h2>
                
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="h-12 w-12 rounded-full bg-tumbloo-black flex items-center justify-center text-tumbloo-white font-semibold">
                            {{ substr($user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-semibold text-tumbloo-black">{{ $user->name }}</p>
                            <p class="text-sm text-tumbloo-gray">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-tumbloo-gray">Role Saat Ini</span>
                            @if($user->role == 'admin')
                            <span class="badge badge-danger">Admin</span>
                            @elseif($user->role == 'seller')
                            <span class="badge badge-info">Seller</span>
                            @else
                            <span class="badge badge-success">Customer</span>
                            @endif
                        </div>
                        
                        <div class="flex justify-between text-sm">
                            <span class="text-tumbloo-gray">Member Sejak</span>
                            <span class="font-medium text-tumbloo-black">{{ $user->created_at->format('d M Y') }}</span>
                        </div>

                        <div class="flex justify-between text-sm">
                            <span class="text-tumbloo-gray">Terakhir Update</span>
                            <span class="font-medium text-tumbloo-black">{{ $user->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warning Card -->
            <div class="card p-6 border-2 border-yellow-500">
                <div class="flex items-start space-x-3">
                    <svg class="h-6 w-6 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <div>
                        <h3 class="font-semibold text-tumbloo-black mb-2">Perhatian</h3>
                        <ul class="text-sm text-tumbloo-gray space-y-1">
                            <li>• Pastikan email yang dimasukkan valid dan unik</li>
                            <li>• Perubahan role akan mempengaruhi akses user</li>
                            <li>• Password minimal 8 karakter</li>
                            <li>• Semua perubahan akan langsung diterapkan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($user->role != 'admin')
            <div class="card p-6 border-2 border-red-500">
                <h3 class="font-semibold text-red-600 mb-3">Danger Zone</h3>
                <p class="text-sm text-tumbloo-gray mb-4">
                    Menghapus user akan menghapus semua data terkait secara permanen. Tindakan ini tidak dapat dibatalkan.
                </p>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full btn-secondary btn-sm bg-red-600 hover:bg-red-700 text-white" 
                        onclick="return confirm('Apakah Anda yakin ingin menghapus user ini? Data tidak dapat dikembalikan!')">
                        <svg class="h-4 w-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus User
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection