<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-[#f3f3f1]">

    <div class="w-full max-w-5xl mx-auto px-4 py-10 relative">
        {{-- (opsional) noise background tipis --}}
        <div class="pointer-events-none absolute inset-0 opacity-40 mix-blend-multiply"
             style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.08) 1px, transparent 0);
                    background-size: 6px 6px;">
        </div>

        <div class="relative">

            {{-- ==================== SIGN IN PAGE ==================== --}}
            <div id="page-signin" class="grid md:grid-cols-2 gap-6">
                {{-- LEFT CARD: SIGN IN --}}
                <div class="bg-[#f6f4f2] border border-gray-300 rounded-xl px-10 py-12 flex flex-col justify-between">
                    <div>
                        <h1 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                            Sign In
                        </h1>
                        <p class="mt-6 text-sm md:text-base text-gray-600">
                            Already have an account?<br>
                            Sign In down here.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="mt-10 space-y-4">
                        @csrf

                        <div>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="johndoe@gmail.com"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <div>
                            <input
                                type="password"
                                name="password"
                                placeholder="Johndoe123"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <button
                            type="submit"
                            class="mt-4 inline-flex items-center justify-center px-8 py-2.5 rounded-full bg-gray-800 text-white text-sm tracking-wide hover:bg-gray-900 transition">
                            Sign In
                        </button>
                    </form>
                </div>

                {{-- RIGHT CARD: HI, THERE (LINK TO SIGN UP) --}}
                <div class="bg-[#f6f4f2] border border-gray-300 rounded-xl px-10 py-12 flex flex-col justify-between text-center">
                    <div>
                        <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                            Hi, There
                        </h2>
                        <p class="mt-6 text-sm md:text-base text-gray-600">
                            Did not have an account yet?<br>
                            Sign Up down here.
                        </p>
                    </div>

                    <div class="mt-10">
                        <button
                            type="button"
                            id="btn-go-signup"
                            class="inline-flex items-center justify-center w-full md:w-auto px-10 py-2.5 rounded-full bg-gray-300 text-xs md:text-sm tracking-wide hover:bg-gray-400 transition">
                            Sign Up
                        </button>
                    </div>
                </div>
            </div>

            {{-- ==================== SIGN UP PAGE ==================== --}}
            <div id="page-signup" class="grid md:grid-cols-2 gap-6 hidden">
                {{-- LEFT CARD: WELCOME (LINK TO SIGN IN) --}}
                <div class="bg-[#f6f4f2] border border-gray-300 rounded-xl px-10 py-12 flex flex-col justify-between text-center md:text-left">
                    <div>
                        <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                            Welcome
                        </h2>
                        <p class="mt-6 text-sm md:text-base text-gray-600">
                            Already have an account? Sign In down here.
                        </p>
                    </div>

                    <div class="mt-10">
                        <button
                            type="button"
                            id="btn-go-signin"
                            class="inline-flex items-center justify-center w-full md:w-auto px-10 py-2.5 rounded-full bg-gray-300 text-xs md:text-sm tracking-wide hover:bg-gray-400 transition">
                            Sign In
                        </button>
                    </div>
                </div>

                {{-- RIGHT CARD: SIGN UP FORM --}}
                <div class="bg-[#f6f4f2] border border-gray-300 rounded-xl px-10 py-12 flex flex-col justify-between">
                    <div>
                        <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                            Sign Up
                        </h2>
                        <p class="mt-6 text-sm md:text-base text-gray-600">
                            Please fill your data down here.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="mt-10 space-y-4">
                        @csrf

                        <div>
                            <label class="block text-[11px] tracking-[0.15em] text-gray-600 mb-1">
                                USERNAME
                            </label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-[11px] tracking-[0.15em] text-gray-600 mb-1">
                                EMAIL
                            </label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="johndoe@gmail.com"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <div>
                            <label class="block text-[11px] tracking-[0.15em] text-gray-600 mb-1">
                                PASSWORD
                            </label>
                            <input
                                type="password"
                                name="password"
                                placeholder="Johndoe123"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <div>
                            <input
                                type="password"
                                name="password_confirmation"
                                placeholder="Confirm password"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 border border-transparent focus:border-gray-500 focus:ring-0 text-sm"
                            >
                        </div>

                        <button
                            type="submit"
                            class="mt-4 inline-flex items-center justify-center px-8 py-2.5 rounded-full bg-gray-800 text-white text-sm tracking-wide hover:bg-gray-900 transition">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <script>
        const pageSignin = document.getElementById('page-signin');
        const pageSignup = document.getElementById('page-signup');
        const btnGoSignup = document.getElementById('btn-go-signup');
        const btnGoSignin = document.getElementById('btn-go-signin');

        btnGoSignup?.addEventListener('click', () => {
            pageSignin.classList.add('hidden');
            pageSignup.classList.remove('hidden');
        });

        btnGoSignin?.addEventListener('click', () => {
            pageSignup.classList.add('hidden');
            pageSignin.classList.remove('hidden');
        });
    </script>

</body>
</html>