  <<div class="min-h-screen bg-[#f3f3f3]">

    {{-- Header --}}
    <header class="flex items-center justify-between px-12 py-6">
        <div class="flex items-center gap-6">
            <button>☰</button>
            <nav class="flex gap-8">
                <a href="#">Home</a>
                <a href="#">Collections</a>
                <a href="#">New</a>
            </nav>
        </div>

        <div class="flex items-center gap-4">
            <button>❤️</button>
            <button class="px-4 py-2 rounded-full border">Cart</button>
            <button>👜</button>
            <button>👤</button>
        </div>
    </header>

    {{-- Content --}}
    <div class="flex gap-12 px-12">

        {{-- Sidebar Categories --}}
        <div class="text-sm tracking-widest flex flex-col gap-2">
            <span>MEN</span>
            <span>WOMEN</span>
            <span>KIDS</span>
        </div>

        <div class="flex-1">
            {{-- Search Bar --}}
            <div class="mb-10 w-[280px]">
                <input class="w-full px-4 py-3 border rounded-lg" placeholder="Search">
            </div>

            {{-- Hero Title --}}
            <h1 class="text-6xl font-bold leading-tight">MPRUY<br>STORE</h1>
            <p class="mt-4 text-gray-600">Winter<br>2025</p>
        </div>

        {{-- Hero Images --}}
        <div class="flex gap-6">
            <img src="/img/hero1.jpg" class="w-[380px] object-cover" />
            <img src="/img/hero2.jpg" class="w-[380px] object-cover" />
        </div>
    </div>

</div>