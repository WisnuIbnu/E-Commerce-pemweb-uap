<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-lunpia-dark">Manage Users</h2>
    </x-slot>

    <div class="py-6 bg-lunpia-cream min-h-screen">
        <div class="max-w-8xl mx-auto sm:px-10 lg:px-10 grid grid-cols-1 md:grid-cols-6 gap-6">
            <div class="md:col-span-1">
                @include('admin.partials.sidebar')
            </div>

            <div class="md:col-span-5">
                <div class="bg-white p-4 rounded-xl shadow">
                    <table class="w-full table-auto">
                        <thead class="bg-lunpia-peach">
                            <tr>
                                <th class="p-3 text-left">Name</th>
                                <th class="p-3 text-left">Email</th>
                                <th class="p-3 text-left">Role</th>
                                <th class="p-3 text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr class="border-b">
                                    <td class="p-3">{{ $user->name }}</td>
                                    <td class="p-3">{{ $user->email }}</td>
                                    <td class="p-3">{{ $user->role }}</td>
                                    <td class="p-3">
                                        <!-- contoh action: set role / delete -->
                                        <form action="{{ route('admin.users') }}" method="POST" style="display:inline;">
                                            @csrf
                                            <!-- action buttons here -->
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
