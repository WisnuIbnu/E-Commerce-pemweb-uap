<!-- resources/views/admin/dashboard.blade.php -->
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-700 antialiased">
    @include('layouts.admin.admin-navbar') <!-- Navbar with Logo and Title -->

    <main class="px-16 py-10">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome, Admin!</h1>
            <p class="text-gray-600 mt-2">Here's what's happening with your platform today.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Users</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $users->count() }}</p>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Stores -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Total Stores</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $storesVerified->count() + $storesUnverified->count() }}</p>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Verifications -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Pending Stores</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $storesUnverified->count() }}</p>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Verified Stores -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Verified Stores</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $storesVerified->count() }}</p>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <a href="{{ route('admin.storeVerification') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="bg-blue-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Verify Stores</h3>
                        <p class="text-sm text-gray-500">Review pending stores</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.usersAndStores') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="bg-green-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Manage Users</h3>
                        <p class="text-sm text-gray-500">View all users & stores</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.withdrawals.index') }}" class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="bg-purple-100 p-3 rounded-full mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">Withdrawals</h3>
                        <p class="text-sm text-gray-500">Process requests</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Recent Activity Tables -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Recent Pending Stores -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Pending Stores</h3>
                <table class="min-w-full text-sm text-gray-700">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">Store Name</th>
                            <th class="px-4 py-2 text-left">Owner</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($storesUnverified->take(5) as $store)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $store->name }}</td>
                                <td class="px-4 py-2">{{ $store->user->name }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-center text-gray-500">No pending stores</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                @if($storesUnverified->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.storeVerification') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all →</a>
                    </div>
                @endif
            </div>

            <!-- Recent Users -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Users</h3>
                <table class="min-w-full text-sm text-gray-700">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users->sortByDesc('created_at')->take(5) as $user)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($users->count() > 5)
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.usersAndStores') }}" class="text-blue-600 hover:text-blue-800 text-sm">View all →</a>
                    </div>
                @endif
            </div>
        </div>

    </main>
</body>
</html>
