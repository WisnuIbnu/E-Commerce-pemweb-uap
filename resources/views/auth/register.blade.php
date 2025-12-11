<x-guest-layout>
    
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Buat Akun Baru</h2>
        <p class="text-slate-500 text-sm mt-2">Isi data diri Anda untuk bergabung.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="block font-bold text-sm text-slate-700 mb-2">Nama Lengkap</label>
            <input id="name" 
                   class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all outline-none font-medium shadow-sm" 
                   type="text" 
                   name="name" 
                   :value="old('name')" 
                   required autofocus autocomplete="name" 
                   placeholder="Contoh: Budi Santoso" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block font-bold text-sm text-slate-700 mb-2">Email Address</label>
            <input id="email" 
                   class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all outline-none font-medium shadow-sm" 
                   type="email" 
                   name="email" 
                   :value="old('email')" 
                   required autocomplete="username" 
                   placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block font-bold text-sm text-slate-700 mb-2">Password</label>
            <input id="password" 
                   class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all outline-none font-medium shadow-sm"
                   type="password" 
                   name="password" 
                   required autocomplete="new-password" 
                   placeholder="Minimal 8 karakter" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block font-bold text-sm text-slate-700 mb-2">Konfirmasi Password</label>
            <input id="password_confirmation" 
                   class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3.5 text-slate-900 placeholder-slate-400 focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all outline-none font-medium shadow-sm"
                   type="password" 
                   name="password_confirmation" 
                   required autocomplete="new-password" 
                   placeholder="Ulangi password Anda" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-4">
            <button type="submit" 
                    class="w-full py-3 bg-primary hover:bg-primary-dark text-white font-bold rounded-xl shadow-lg shadow-indigo-500/40 transition-colors duration-200 flex justify-center items-center gap-2 tracking-wide ring-offset-2 focus:ring-2 focus:ring-primary">
                DAFTAR SEKARANG <i class="fa-solid fa-user-plus ml-1"></i>
            </button>
        </div>
    </form>

    <div class="mt-8 text-center text-sm text-slate-500 font-medium">
        Sudah punya akun? 
        <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark hover:underline">Masuk disini</a>
    </div>
</x-guest-layout>