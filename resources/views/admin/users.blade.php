<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Manage Users</h2>
    </x-slot>

    <div class="bg-white shadow p-6 rounded-xl">
        <h3 class="text-lg font-semibold mb-4">Users</h3>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Name</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Role</th>
                        <th class="p-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $u)
                    <tr class="border-t">
                        <td class="p-3">{{ $u->name }}</td>
                        <td class="p-3">{{ $u->email }}</td>
                        <td class="p-3">{{ $u->role }}</td>
                        <td class="p-3 text-center">
                            <button class="px-3 py-1 rounded bg-lunpia-red text-white">
                                Delete
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
