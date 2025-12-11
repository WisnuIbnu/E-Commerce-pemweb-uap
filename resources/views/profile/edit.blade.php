<x-app-layout>
    <div class="flex min-h-screen bg-gray-50">
        {{-- Sidebar Navbar --}}
        @include('profile.partials.navbar')

        {{-- Main Content --}}
        <div class="flex-1">
            {{-- Header dengan Breadcrumb --}}
            <div class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{-- Breadcrumb --}}
                    <div class="breadcrumb-wrapper mb-4">
                        <div class="breadcrumb-container">
                            <a href="{{ route('dashboard') }}" class="breadcrumb-link">Home</a>
                            <span class="breadcrumb-separator">›</span>
                            <span class="breadcrumb-current">User Info</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content --}}
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Breadcrumb Styles --}}
    <style>
        .breadcrumb-wrapper {
            margin-bottom: 1rem;
        }

        .breadcrumb-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .breadcrumb-link {
            color: #984216;
            text-decoration: none;
            transition: color 0.2s;
        }

        .breadcrumb-link:hover {
            color: #7a3412;
            text-decoration: underline;
        }

        .breadcrumb-separator {
            color: #9ca3af;
            font-size: 1rem;
        }

        .breadcrumb-current {
            color: #6b7280;
            font-weight: 500;
        }
    </style>
</x-app-layout>