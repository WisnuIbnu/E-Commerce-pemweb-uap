<!DOCTYPE html>
<html>
<head>
    <title>ElecTrend Admin - @yield('title')</title>
    
    {{-- Tailwind CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-900 text-gray-100">

    <div class="flex">

        {{-- SIDEBAR --}}
        <aside class="w-64 h-screen bg-gradient-to-b from-gray-900 via-gray-900 to-gray-800 text-gray-100 fixed left 0 top-0 shadow-xl">

            <div class="p-6 border-b border-gray-700">
                <h1 class="text-2xl font-bold tracking-wide text-white">ElecTrend Admin</h1>
            </div>

            <nav class="p-4 space-y-2">

                <a href="{{ route('admin.stores') }}" 
                   class="block p-3 rounded-lg text-sm font-medium text-gray-200 hover:text-blue-300 hover:bg-gray-800 transition">
                    🏪 Store Verification
                </a>

                <a href="{{ route('admin.users') }}" 
                   class="block p-3 rounded-lg text-sm font-medium text-gray-200 hover:text-blue-300 hover:bg-gray-800 transition">
                    👥 User Management
                </a>

            </nav>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="ml-64 p-10 w-full">

            <h2 class="text-3xl font-bold text-white mb-6">@yield('title')</h2>

            <div>
                @yield('content')
            </div>

        </main>

    </div>

</body>
</html>
