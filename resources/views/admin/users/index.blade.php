<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">User & Store Management</h2>
    </x-slot>

    <div class="p-6 space-y-6">

        {{-- Users Table --}}
        <h3 class="text-lg font-bold mb-2">Users</h3>
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">Name</th>
                    <th class="p-3 border">Email</th>
                    <th class="p-3 border">Store</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="border p-3">{{ $user->name }}</td>
                        <td class="border p-3">{{ $user->email }}</td>
                        <td class="border p-3">
                            {{ $user->store->name ?? 'No store' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        {{-- Stores Table --}}
        <h3 class="text-lg font-bold mt-10 mb-2">Stores</h3>
        <table class="min-w-full border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 border">Store</th>
                    <th class="p-3 border">Owner</th>
                    <th class="p-3 border">Status</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($stores as $store)
                    <tr>
                        <td class="border p-3">{{ $store->name }}</td>
                        <td class="border p-3">{{ $store->user->name }}</td>
                        <td class="border p-3 capitalize">{{ $store->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</x-app-layout>
