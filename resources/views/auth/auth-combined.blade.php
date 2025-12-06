<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white shadow-2xl rounded-xl w-[900px] overflow-hidden flex">

    {{-- LEFT SIDE (AUTH IMAGES / ILLUSTRATION) --}}
    <div class="w-1/2 bg-blue-600 text-white flex flex-col items-center justify-center p-10">
        <h1 class="text-4xl font-bold mb-4">Welcome Back!</h1>
        <p class="text-lg opacity-90">Silakan login atau daftar untuk melanjutkan.</p>
    </div>

    {{-- RIGHT SIDE (LOGIN + REGISTER) --}}
    <div class="w-1/2 relative p-10">

        {{-- SWITCH BUTTONS --}}
        <div class="flex justify-between mb-8">
            <button id="btn-login"
                class="tab-btn text-blue-600 font-medium border-b-2 border-blue-600 pb-1">
                Sign In
            </button>

            <button id="btn-register"
                class="tab-btn text-gray-400 font-medium pb-1">
                Sign Up
            </button>
        </div>

        {{-- LOGIN FORM --}}
        <div id="login-form">

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-sm">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div class="flex justify-between text-sm">
                    <a href="{{ route('password.request') }}" class="text-blue-600">
                        Forgot password?
                    </a>
                </div>

                <button class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold">
                    Login
                </button>
            </form>

        </div>

        {{-- REGISTER FORM --}}
        <div id="register-form" class="hidden">

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm">Name</label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-sm">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-sm">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <div>
                    <label class="text-sm">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 border rounded-lg">
                </div>

                <button class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold">
                    Register
                </button>
            </form>

        </div>

    </div>
</div>


<script>
    const loginBtn = document.getElementById('btn-login');
    const registerBtn = document.getElementById('btn-register');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    loginBtn.addEventListener('click', () => {
        loginForm.classList.remove('hidden');
        registerForm.classList.add('hidden');
        loginBtn.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        registerBtn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
    });

    registerBtn.addEventListener('click', () => {
        loginForm.classList.add('hidden');
        registerForm.classList.remove('hidden');
        registerBtn.classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        loginBtn.classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
    });
</script>

</body>
</
