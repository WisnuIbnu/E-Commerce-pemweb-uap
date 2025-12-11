<x-guest-layout>
    @section('title', 'Login')

    <h2 class="text-center text-3xl font-bold text-white mb-6">
        Welcome Back to ElecTrend
    </h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email -->
        <div>
            <label class="text-white">Email</label>
            <input type="email" name="email" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required autofocus>
        </div>

        <!-- Password -->
        <div>
            <label class="text-white">Password</label>
            <input type="password" name="password" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60 focus:border-blue-300" required>
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2">
            <input type="checkbox" name="remember" id="remember" class="rounded bg-white/20 border-white/30 text-blue-500">
            <label class="text-white" for="remember">Remember me</label>
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="text-sm text-white hover:underline" href="{{ route('password.request') }}">
                Forgot your password?
            </a>

            <button class="px-5 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-md">
                Login
            </button>
        </div>

        <p class="text-center text-white/80 pt-4">
            Don't have an account? 
            <a href="{{ route('register') }}" class="text-white underline">Register</a>
        </p>
    </form>
</x-guest-layout>
