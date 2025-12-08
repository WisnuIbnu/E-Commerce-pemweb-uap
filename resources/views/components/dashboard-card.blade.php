@props(['title', 'color' => 'blue', 'icon' => '', 'link' => '#'])

<a href="{{ $link }}" class="block">
    <div class="shadow-sm sm:rounded-lg p-6 transition-colors
        @if($color === 'blue') bg-blue-50 hover:bg-blue-100 text-blue-800 @endif
        @if($color === 'green') bg-green-50 hover:bg-green-100 text-green-800 @endif
        @if($color === 'red') bg-red-50 hover:bg-red-100 text-red-800 @endif
        ">
        <div class="flex items-center space-x-4">
            @if($icon)
                <div class="
                    @if($color === 'blue') text-blue-500 @endif
                    @if($color === 'green') text-green-500 @endif
                    @if($color === 'red') text-red-500 @endif
                    text-3xl
                ">
                    <i class="fas fa-{{ $icon }}"></i>
                </div>
            @endif
            <div>
                <h3 class="font-bold text-xl mb-1">{{ $title }}</h3>
                <p class="text-sm">{{ $slot }}</p>
            </div>
        </div>
    </div>
</a>
