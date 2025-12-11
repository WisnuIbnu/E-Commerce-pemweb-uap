<nav class="border-b border-slate-800/80 bg-slate-950/90 backdrop-blur-md sticky top-0 z-40">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 h-14 sm:h-16 flex items-center justify-between gap-6">

        {{-- Brand --}}
        <a href="{{ url('/') }}" class="flex items-center gap-2 group">
            <div
                class="h-8 w-8 rounded-xl bg-gradient-to-br from-sky-400 to-blue-500 
                       shadow-[0_0_25px_rgba(56,189,248,0.6)] flex items-center justify-center text-slate-950 font-extrabold text-sm">
                E
            </div>
            <span class="text-lg sm:text-xl font-semibold tracking-tight text-slate-100 group-hover:text-white transition-colors">
                ElecTrend
            </span>
        </a>

        {{-- Main links --}}
        <div class="hidden sm:flex items-center gap-6 text-sm font-medium text-slate-300">
            <a href="{{ url('/') }}"
               class="hover:text-sky-300 transition-colors {{ request()->is('/') ? 'text-sky-300' : '' }}">
                Home
            </a>
            <a href="{{ url('/products') }}"
               class="hover:text-sky-300 transition-colors {{ request()->is('products*') ? 'text-sky-300' : '' }}">
                Products
            </a>
        </div>

        {{-- Auth / Actions --}}
        <div class="flex items-center gap-3 text-sm font-medium">
            @auth
                <a href="{{ route('dashboard') }}"
                   class="px-3 py-1.5 rounded-lg border border-slate-700/70 text-slate-100 
                          hover:border-sky-400/70 hover:text-sky-300 transition-colors">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                   class="text-slate-300 hover:text-sky-300 transition-colors">
                    Login
                </a>
                <a href="{{ route('register') }}"
                   class="px-3 py-1.5 rounded-lg bg-gradient-to-r from-sky-500 to-blue-600 
                          text-white shadow-[0_10px_25px_rgba(37,99,235,0.6)]
                          hover:from-sky-400 hover:to-blue-500 transition-colors">
                    Register
                </a>
            @endauth
        </div>
    </div>
</nav>
