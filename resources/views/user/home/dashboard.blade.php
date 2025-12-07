<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
 
<body class="bg-noise text-gray-700 antialiased">

    {{-- NAVBAR --}}
   {{-- NAVBAR --}}
@include('layouts.store-navbar')


    {{-- SEARCH --}}
    <!-- <div class="w-full flex justify-center mt-2 mb-10">
        <div class="flex items-center bg-gray-200 rounded-md px-4 py-3 w-1/2 max-w-lg">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 21l-4.35-4.35m2.1-5.4a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" />
            </svg>

            <input type="text" placeholder="Search"
                class="ml-3 w-full bg-transparent text-sm text-gray-600 focus:outline-none" />
        </div>
    </div> -->

    {{-- MAIN CONTENT --}}
    <section class="px-16 mt-6 grid grid-cols-1 md:grid-cols-3 gap-10">

        {{-- Left Text --}}
        <div class="flex flex-col justify-center">
            <h1 class="text-6xl font-bold tracking-tight leading-none text-gray-700">
                MPRUY<br>STORE
            </h1>

            <p class="mt-4 text-sm text-gray-600 leading-tight">
                Winter<br>2025
            </p>
        </div>

        {{-- Middle Image --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/white-man-sit.png') }}"
                class="rounded-lg shadow-sm object-cover w-[450px] h-[520px]">
        </div>

        {{-- Right Image --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/black-man-stand.png') }}"
                class="rounded-lg shadow-sm object-cover w-[450px] h-[520px]">
        </div>

    </section>


    </div>

</body>

</html>