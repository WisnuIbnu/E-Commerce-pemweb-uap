<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        @include('profile.partials.navbar')

        <div class="flex-1">
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <div class="breadcrumb-wrapper mb-4">
                        <div class="breadcrumb-container">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">›</span>
                            <span class="breadcrumb-current">Register Store</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Daftar Toko</h2>
                            
                            <form method="POST" action="{{ route('store.register.submit') }}">
                                @csrf
                                
                                <!-- Name Field -->
                                <div class="mb-6">
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Toko <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 @error('name') border-red-500 @enderror"
                                        placeholder="Masukkan nama toko"
                                    >
                                    @error('name')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Description Field -->
                                <div class="mb-6">
                                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                        Deskripsi <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="description" 
                                        name="description" 
                                        rows="4"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 @error('description') border-red-500 @enderror"
                                        placeholder="Deskripsikan toko Anda"
                                    >{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Address Field -->
                                <div class="mb-6">
                                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea 
                                        id="address" 
                                        name="address" 
                                        rows="3"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 @error('address') border-red-500 @enderror"
                                        placeholder="Masukkan alamat lengkap toko"
                                    >{{ old('address') }}</textarea>
                                    @error('address')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Phone Field -->
                                <div class="mb-6">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nomor Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        value="{{ old('phone') }}"
                                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition duration-200 @error('phone') border-red-500 @enderror"
                                        placeholder="Contoh: 081234567890"
                                    >
                                    @error('phone')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <div class="flex items-center justify-end mt-8">
                                    <button 
                                        type="submit"
                                        class="px-6 py-3 bg-orange-700 text-white font-medium rounded-lg hover:bg-orange-800 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition duration-200"
                                        style="background-color: #984216;"
                                        onmouseover="this.style.backgroundColor='#7a3412'"
                                        onmouseout="this.style.backgroundColor='#984216'"
                                    >
                                        Daftarkan Toko
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .breadcrumb-wrapper { margin-bottom: 1rem; }
        .breadcrumb-container { display:flex; align-items:center; gap:0.5rem; font-size:0.875rem; }
        .breadcrumb-link { color:#984216; text-decoration:none; transition:color .2s; }
        .breadcrumb-link:hover { color:#7a3412; text-decoration:underline; }
        .breadcrumb-separator { color:#9ca3af; font-size:1rem; }
        .breadcrumb-current { color:#6b7280; font-weight:500; }
    </style>
</x-app-layout>