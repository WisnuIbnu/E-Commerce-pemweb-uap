<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online') - Tech Store</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4f46e5', // Indigo-600
                        'primary-dark': '#4338ca', // Indigo-700
                        'primary-light': '#e0e7ff', // Indigo-100
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .hide-scroll::-webkit-scrollbar { display: none; }
        .hide-scroll { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 flex flex-col min-h-screen selection:bg-primary selection:text-white">

    <nav x-data="{ mobileMenuOpen: false, scrolled: false }" 
         @scroll.window="scrolled = (window.pageYOffset > 10)"
         :class="scrolled ? 'bg-white/95 backdrop-blur-xl shadow-sm border-slate-200' : 'bg-white/50 backdrop-blur-md border-transparent'"
         class="fixed top-0 w-full z-50 transition-all duration-300 border-b">
         
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <a href="{{ route('home') }}" class="group flex items-center gap-2.5">
                    <div class="bg-gradient-to-br from-primary to-purple-600 text-white w-8 h-8 rounded-lg flex items-center justify-center shadow-lg shadow-primary/30 transition-transform duration-300 group-hover:scale-110 group-hover:rotate-12">
                        <i class="fa-solid fa-bag-shopping text-xs"></i>
                    </div>
                    <span class="font-extrabold text-lg tracking-tight text-slate-900">
                        Tech<span class="text-primary">Store.</span>
                    </span>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('home') }}" class="relative text-sm font-bold text-slate-600 hover:text-primary transition-colors group py-2">
                            Beranda
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                        <a href="{{ route('home') }}#katalog" class="relative text-sm font-bold text-slate-600 hover:text-primary transition-colors group py-2">
                            Katalog
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-primary transition-all duration-300 group-hover:w-full"></span>
                        </a>
                    </div>
                    
                    <div class="w-px h-5 bg-slate-200"></div>

                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.outside="open = false" 
                                    class="flex items-center gap-2 pl-1 pr-3 py-1.5 rounded-full border border-slate-200 bg-white hover:border-primary transition-colors group">
                                <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs group-hover:bg-primary-dark transition-colors">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="text-xs font-bold text-slate-700 group-hover:text-primary transition-colors">{{ Auth::user()->name }}</span>
                                <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 transition-transform duration-300" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" 
                                 x-transition.origin.top.right
                                 class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-slate-100 p-1 transform origin-top-right focus:outline-none" 
                                 style="display: none;">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2 text-xs font-bold text-slate-600 hover:bg-slate-50 hover:text-primary rounded-lg transition-colors">
                                    <i class="fa-solid fa-gauge-high w-4 text-center"></i> Dashboard
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 text-left px-3 py-2 text-xs font-bold text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                                        <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-3">
                            <a href="{{ route('login') }}" 
                               class="px-6 py-2.5 rounded-full text-xs font-bold text-slate-700 border border-slate-200 hover:border-primary hover:text-primary bg-white transition-colors duration-300">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" 
                               class="px-6 py-2.5 rounded-full text-xs font-bold text-white bg-primary hover:bg-primary-dark shadow-md shadow-indigo-500/20 transition-colors duration-300">
                                Daftar
                            </a>
                        </div>
                    @endauth
                </div>

                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-slate-600 hover:text-primary transition-colors">
                    <i class="fa-solid fa-bars-staggered text-lg"></i>
                </button>
            </div>
        </div>

        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-slate-100 shadow-xl">
            <div class="p-4 space-y-3">
                <a href="{{ route('home') }}" class="block px-4 py-2 rounded-lg bg-slate-50 text-primary font-bold text-sm">Beranda</a>
                <a href="{{ route('home') }}#katalog" class="block px-4 py-2 rounded-lg hover:bg-slate-50 text-slate-600 font-bold text-sm">Katalog</a>
                @auth
                    <div class="border-t border-slate-100 my-2"></div>
                    <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-50 text-slate-600 font-bold text-sm">Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 rounded-lg text-red-500 font-bold text-sm hover:bg-red-50">Logout</button>
                    </form>
                @else
                    <div class="grid grid-cols-2 gap-3 mt-4">
                        <a href="{{ route('login') }}" class="text-center py-2 border border-slate-200 rounded-lg font-bold text-slate-700 text-sm hover:bg-slate-50">Masuk</a>
                        <a href="{{ route('register') }}" class="text-center py-2 bg-primary text-white rounded-lg font-bold text-sm hover:bg-primary-dark">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow pt-16">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-slate-200 mt-12 py-6">
        <div class="flex flex-col items-center justify-center gap-2">
            
            <div class="flex items-center gap-2.5">
                <div class="bg-gradient-to-br from-primary to-purple-600 text-white w-8 h-8 rounded-lg flex items-center justify-center shadow-lg shadow-primary/30">
                    <i class="fa-solid fa-bag-shopping text-xs"></i>
                </div>
                <span class="font-extrabold text-lg tracking-tight text-slate-900">
                    Tech<span class="text-primary">Store.</span>
                </span>
            </div>
            
            <p class="text-slate-500 text-sm font-medium">
                &copy; {{ date('Y') }} Tech Store. All rights reserved.
            </p>
        </div>
    </footer>

</body>
</html>