<x-guest-layout>
    @section('title', 'Forgot Password')

    <h2 class="text-center text-3xl font-bold text-white mb-6">
        Forgot Your Password?
    </h2>

    <p class="text-white/80 text-center mb-4">
        Enter your email and we will send a password reset link.
    </p>

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="text-white">Email</label>
            <input type="email" name="email" class="w-full mt-1 rounded-lg bg-white/20 text-white border-white/30 placeholder-white/60" required autofocus>
        </div>

        <button class="w-full py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg shadow-md mt-4">
            Send Reset Link
        </button>
    </form>

    <p class="text-center text-white/80 pt-4">
        Remember your password? 
        <a href="{{ route('login') }}" class="text-white underline">Login</a>
    </p>
</x-guest-layout>
