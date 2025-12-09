<!-- resources/views/admin/dashboard.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-noise text-gray-700 antialiased">
    @include('layouts.admin.admin-navbar') <!-- Optional: Navbar from other layout -->

    <main class="px-16 py-10">
        <h1 class="text-2xl font-semibold mb-6">Admin Dashboard</h1>

        <div class="grid grid-cols-3 gap-8">
            <!-- Store Verification -->
            <div class="bg-white shadow-sm rounded-xl p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Store Verification</h3>
                <table class="min-w-full text-sm text-gray-700">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">Store Name</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $store->name }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.store.verify', $store->id) }}" class="inline">
                                        @csrf
                                        <button class="text-green-600">Verify</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.store.reject', $store->id) }}" class="inline">
                                        @csrf
                                        <button class="text-red-600">Reject</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- User & Store Management -->
            <div class="bg-white shadow-sm rounded-xl p-6 col-span-2">
                <h3 class="text-lg font-medium text-gray-900 mb-4">User & Store Management</h3>

                <h4 class="text-md font-medium mb-2">Users</h4>
                <table class="min-w-full text-sm text-gray-700 mb-6">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">Name</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.user.delete', $user->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <h4 class="text-md font-medium mb-2">Stores</h4>
                <table class="min-w-full text-sm text-gray-700">
                    <thead>
                        <tr class="border-b">
                            <th class="px-4 py-2">Store Name</th>
                            <th class="px-4 py-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($stores as $store)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $store->name }}</td>
                                <td class="px-4 py-2">
                                    <form method="POST" action="{{ route('admin.store.delete', $store->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
                    