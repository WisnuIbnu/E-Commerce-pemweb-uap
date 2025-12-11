<x-guest-layout>
    
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
        <p class="text-slate-500 text-sm mt-2">Masukan akun Anda untuk melanjutkan.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-2">Email Address</label>
            <input id="email" 
                   class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/20 transition-all outline-none font-medium shadow-sm" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required autofocus autocomplete="username" 
                   placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block font-bold text-sm text-slate-700 mb-2">Password</label>
            <input id="password" 
                   class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-gray-900 placeholder-gray-400 focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/20 transition-all outline-none font-medium shadow-sm"
                   type="password" 
                   name="password" 
                   required autocomplete="current-password" 
                   placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-all cursor-pointer h-4 w-4" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors font-medium">{{ __('Ingat saya') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors hover:underline" href="{{ route('password.request') }}">
                    {{ __('Lupa password?') }}
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" 
                    class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/40 transition-colors duration-200 flex justify-center items-center gap-2 tracking-wide">
                <span>MASUK SEKARANG</span>
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </div>
    </form>
    
    <div class="mt-8 text-center text-sm text-slate-500 font-medium">
        Belum punya akun? 
        <a href="{{ route('register') }}" class="font-bold text-indigo-600 hover:text-indigo-800 hover:underline">Buat Akun Baru</a>
    </div>
</x-guest-layout>