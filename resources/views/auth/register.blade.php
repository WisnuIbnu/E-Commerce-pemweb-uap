<x-guest-layout>
    @section('title', 'Register')

    <h2 class="text-center text-3xl font-bold text-white mb-6">
        Create Your ElecTrend Account
    </h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Name -->
        <div>
            <label class="text-white">Name</label>
            <input type="text" name="name" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required autofocus>
        </div>

        <!-- Email Address -->
        <div>
            <label class="text-white">Email</label>
            <input type="email" name="email" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required>
        </div>

        <!-- Password -->
        <div>
            <label class="text-white">Password</label>
            <input type="password" name="password" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label class="text-white">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-white hover:underline" href="{{ route('login') }}">
                Already registered?
            </a>

            <button class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-md">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
