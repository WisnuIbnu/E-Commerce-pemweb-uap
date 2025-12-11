<x-guest-layout>
    @section('title', 'Reset Password')

    <h2 class="text-center text-3xl font-bold text-white mb-6">
        Reset Your Password
    </h2>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="text-white">Email</label>
            <input type="email" name="email" class="w-full mt-1 rounded-lg bg-white/20 text-white" required>
        </div>

        <div>
            <label class="text-white">New Password</label>
            <input type="password" name="password" class="w-full mt-1 rounded-lg bg-white/20 text-white" required>
        </div>

        <div>
            <label class="text-white">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full mt-1 rounded-lg bg-white/20 text-white" required>
        </div>

        <button class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-md mt-4">
            Reset Password
        </button>
    </form>
</x-guest-layout>
