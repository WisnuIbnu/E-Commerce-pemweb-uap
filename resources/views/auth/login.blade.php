<x-guest-layout>

    {{-- WRAPPER UTAMA --}}
    <div class="w-full max-w-6xl mx-auto px-4 md:px-8">

        {{-- ========== SIGN IN PAGE ========== --}}
        <div id="page-signin" class="grid md:grid-cols-2 gap-8">

            {{-- LEFT: SIGN IN CARD --}}
            <div class="relative bg-[#f6f4f2] border border-gray-300 rounded-2xl px-10 py-12">
                {{-- noise tipis --}}
                <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-multiply"
                     style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.08) 1px, transparent 0);
                            background-size: 6px 6px;">
                </div>

                <div class="relative">
                    <h1 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                        Sign In
                    </h1>
                    <p class="mt-6 text-sm md:text-base text-gray-600">
                        Already have an account?<br>
                        Sign In down here.
                    </p>

                    <form method="POST" action="{{ route('login') }}" class="mt-12 space-y-4 max-w-xs">
                        @csrf

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="johndoe@gmail.com"
                            required
                            class="w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                        >

                        <input
                            type="password"
                            name="password"
                            placeholder="Johndoe123"
                            required
                            class="w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                        >

                        <button
                            type="submit"
                            class="mt-6 inline-flex items-center justify-center px-8 py-2.5 rounded-full bg-gray-900 text-white text-xs tracking-[0.18em] uppercase">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIGHT: HI, THERE CARD --}}
            <div class="relative bg-[#f6f4f2] border border-gray-300 rounded-2xl px-10 py-12">
                <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-multiply"
                     style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.08) 1px, transparent 0);
                            background-size: 6px 6px;">
                </div>

                <div class="relative text-center">
                    <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                        Hi, There
                    </h2>
                    <p class="mt-6 text-sm md:text-base text-gray-600">
                        Did not have an account yet?<br>
                        Sign Up down here.
                    </p>

                    <button
                        type="button"
                        id="btn-go-signup"
                        class="mt-12 inline-flex items-center justify-center px-12 py-2.5 rounded-full bg-gray-300 text-xs tracking-[0.18em] uppercase">
                        Sign Up
                    </button>
                </div>
            </div>
        </div>

        {{-- ========== SIGN UP PAGE ========== --}}
        <div id="page-signup" class="grid md:grid-cols-2 gap-8 hidden mt-4">

            {{-- LEFT: WELCOME CARD --}}
            <div class="relative bg-[#f6f4f2] border border-gray-300 rounded-2xl px-10 py-12">
                <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-multiply"
                     style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.08) 1px, transparent 0);
                            background-size: 6px 6px;">
                </div>

                <div class="relative text-center md:text-left">
                    <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                        Welcome
                    </h2>
                    <p class="mt-6 text-sm md:text-base text-gray-600">
                        Already have an account? Sign In down here.
                    </p>

                    <button
                        type="button"
                        id="btn-go-signin"
                        class="mt-12 inline-flex items-center justify-center px-12 py-2.5 rounded-full bg-gray-300 text-xs tracking-[0.18em] uppercase">
                        Sign In
                    </button>
                </div>
            </div>

            {{-- RIGHT: SIGN UP FORM CARD --}}
            <div class="relative bg-[#f6f4f2] border border-gray-300 rounded-2xl px-10 py-12">
                <div class="pointer-events-none absolute inset-0 opacity-30 mix-blend-multiply"
                     style="background-image: radial-gradient(circle at 1px 1px, rgba(0,0,0,.08) 1px, transparent 0);
                            background-size: 6px 6px;">
                </div>

                <div class="relative">
                    <h2 class="font-serif text-5xl md:text-6xl leading-tight text-gray-800">
                        Sign Up
                    </h2>
                    <p class="mt-6 text-sm md:text-base text-gray-600">
                        Please fill your data down here.
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="mt-12 space-y-4 max-w-xs">
                        @csrf

                        <div>
                            <div class="text-[11px] tracking-[0.18em] text-gray-600 mb-1 uppercase">
                                Username
                            </div>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                class="auth-input w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                            >
                        </div>

                        <div>
                            <div class="text-[11px] tracking-[0.18em] text-gray-600 mb-1 uppercase">
                                Email
                            </div>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="johndoe@gmail.com"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                            >
                        </div>

                        <div>
                            <div class="text-[11px] tracking-[0.18em] text-gray-600 mb-1 uppercase">
                                Password
                            </div>
                            <input
                                type="password"
                                name="password"
                                placeholder="Johndoe123"
                                required
                                class="w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                            >
                        </div>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm password"
                            required
                            class="w-full px-4 py-2.5 rounded-full bg-gray-200 text-xs border-0 focus:ring-0 focus:outline-none"
                        >

                        <button
                            type="submit"
                            class="mt-6 inline-flex items-center justify-center px-8 py-2.5 rounded-full bg-gray-900 text-white text-xs tracking-[0.18em] uppercase">
                            Sign Up
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Toggle SignIn / SignUp --}}
    <script>
        const pageSignin = document.getElementById('page-signin');
        const pageSignup = document.getElementById('page-signup');
        const btnGoSignup = document.getElementById('btn-go-signup');
        const btnGoSignin = document.getElementById('btn-go-signin');

        btnGoSignup?.addEventListener('click', () => {
            pageSignin.classList.add('hidden');
            pageSignup.classList.remove('hidden');
            window.scrollTo({ top: 0 });
        });

        btnGoSignin?.addEventListener('click', () => {
            pageSignup.classList.add('hidden');
            pageSignin.classList.remove('hidden');
            window.scrollTo({ top: 0 });
        });
    </script>

</x-guest-layout>