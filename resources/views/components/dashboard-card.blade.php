@props(['title', 'icon', 'link', 'color' => 'sky'])

<a href="{{ $link }}" class="block group">
    <div
        class="relative overflow-hidden rounded-2xl border border-slate-700/70 
               bg-slate-900/80 p-5 sm:p-6 shadow-[0_16px_40px_rgba(15,23,42,0.7)]
               transition-transform transition-shadow duration-300
               hover:-translate-y-1 hover:shadow-[0_22px_55px_rgba(15,23,42,0.9)] cursor-pointer"
    >
        {{-- Glow accent --}}
        <div class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100
                    bg-[radial-gradient(circle_at_top_left,_rgba(56,189,248,0.35),_transparent_55%)] 
                    transition-opacity duration-300"></div>

        <div class="relative flex items-start gap-4">
            {{-- Icon --}}
            <div
                class="flex items-center justify-center w-12 h-12 sm:w-14 sm:h-14 rounded-xl
                       bg-{{ $color }}-500/15 text-{{ $color }}-400
                       ring-1 ring-{{ $color }}-400/40
                       transition-colors transition-transform duration-300
                       group-hover:bg-{{ $color }}-500 group-hover:text-white group-hover:scale-105"
            >
                <i class="fas fa-{{ $icon }} text-2xl"></i>
            </div>

            {{-- Text content --}}
            <div class="flex-1 min-w-0">
                <h3
                    class="text-base sm:text-lg font-semibold tracking-tight 
                           text-slate-100 group-hover:text-{{ $color }}-300 transition-colors"
                >
                    {{ $title }}
                </h3>
                <p class="mt-2 text-xs sm:text-sm text-slate-300 leading-relaxed">
                    {{ $slot }}
                </p>
            </div>
        </div>
    </div>
</a>
