<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auth</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f3f3f1;
            margin: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .auth-wrapper {
            max-width: 1600px;
            margin: 80px auto;
            padding: 0 32px;
        }

        .auth-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 32px;
        }

        @media (max-width: 900px) {
            .auth-grid {
                grid-template-columns: 1fr;
            }
        }

        .auth-card {
            background-color: #f6f4f2;
            border: 1px solid #d1d5db;
            border-radius: 32px;
            padding: 72px 96px;
            position: relative;
            overflow: hidden;
            min-height: 940px;
        }

        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: radial-gradient(circle at 1px 1px, rgba(0, 0, 0, .08) 1px, transparent 0);
            background-size: 6px 6px;
            opacity: .25;
            pointer-events: none;
        }

        .auth-card-inner {
            position: relative;
        }

        .auth-title {
            font-family: ui-serif, Georgia, "Times New Roman", serif;
            font-size: 56px;
            line-height: 1.1;
            color: #374151;
        }

        .auth-subtitle {
            margin-top: 24px;
            font-size: 14px;
            color: #6b7280;
        }

        .auth-form {
            margin-top: 56px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            max-width: 320px;
        }

        .auth-input {
            width: 100%;
            padding: 10px 18px;
            border-radius: 9999px;
            border: none;
            background-color: #e3e4e6;
            font-size: 12px;
            color: #4b5563;
        }

        .auth-input::placeholder {
            color: #9ca3af;
        }

        .btn-main {
            margin-top: 20px;
            padding: 10px 32px;
            border-radius: 9999px;
            border: none;
            background-color: #111827;
            color: #f9fafb;
            font-size: 12px;
            letter-spacing: 0.08em;
            cursor: pointer;
        }

        .btn-ghost {
            margin-top: 56px;
            padding: 10px 72px;
            border-radius: 9999px;
            border: none;
            background-color: #e3e4e6;
            color: #374151;
            font-size: 12px;
            letter-spacing: 0.08em;
            cursor: pointer;
        }

        .text-center {
            text-align: center;
        }

        .label-small {
            font-size: 11px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 4px;
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">

        {{-- ========== SIGN IN PAGE ========== --}}
        <div id="page-signin" class="auth-grid">

            {{-- LEFT SIGN IN --}}
            <div class="auth-card">
                <div class="auth-card-inner">
                    <h1 class="auth-title">Sign In</h1>
                    <p class="auth-subtitle">
                        Already have an account?<br>
                        Sign In down here.
                    </p>

                    <form method="POST" action="{{ route('login') }}" class="auth-form">
                        @csrf

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="johndoe@gmail.com"
                            required
                            class="auth-input {{ $errors->has('email') ? 'border border-red-500' : '' }}">

                        <!-- Error Message for Email -->
                        @error('email')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        <!-- Password Field -->
                        <input
                            type="password"
                            name="password"
                            placeholder="Johndoe123"
                            required
                            class="auth-input {{ $errors->has('password') ? 'border border-red-500' : '' }}">
                        <!-- Error Message for Password -->
                        @error('password')
                        <div class="text-red-600 text-sm mt-2">{{ $message }}</div>
                        @enderror

                        <!-- General Login Error -->
                        @if(session('error'))
                        <div class="text-red-600 text-sm mt-2">{{ session('error') }}</div>
                        @endif

                        <button type="submit" class="btn-main">
                            Sign In
                        </button>
                    </form>
                </div>
            </div>

            {{-- RIGHT HI THERE --}}
            <div class="auth-card">
                <div class="auth-card-inner text-center">
                    <h2 class="auth-title">Hi, There</h2>
                    <p class="auth-subtitle">
                        Did not have an account yet?<br>
                        Sign Up down here.
                    </p>

                    <button type="button" id="btn-go-signup" class="btn-ghost">
                        Sign Up
                    </button>
                </div>
            </div>

        </div>

        {{-- ========== SIGN UP PAGE ========== --}}
        <div id="page-signup" class="auth-grid" style="display:none;">

            {{-- LEFT WELCOME --}}
            <div class="auth-card">
                <div class="auth-card-inner text-center">
                    <h2 class="auth-title">Welcome</h2>
                    <p class="auth-subtitle">
                        Already have an account? Sign In down here.
                    </p>

                    <button type="button" id="btn-go-signin" class="btn-ghost">
                        Sign In
                    </button>
                </div>
            </div>

            {{-- RIGHT SIGN UP FORM --}}
            <div class="auth-card">
                <div class="auth-card-inner">
                    <h2 class="auth-title">Sign Up</h2>
                    <p class="auth-subtitle">
                        Please fill your data down here.
                    </p>

                    <form method="POST" action="{{ route('register') }}" class="auth-form">
                        @csrf

                        <div>
                            <div class="label-small">Username</div>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="John Doe"
                                required
                                class="auth-input {{ $errors->has('name') ? 'border border-red-500' : '' }}">
                        </div>

                        <div>
                            <div class="label-small">Email</div>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="johndoe@gmail.com"
                                required
                                class="auth-input {{ $errors->has('email') ? 'border border-red-500' : '' }}">
                        </div>

                        <div>
                            <div class="label-small">Password</div>
                            <input
                                type="password"
                                name="password"
                                placeholder="Johndoe123"
                                required
                                class="auth-input {{ $errors->has('password') ? 'border border-red-500' : '' }}">
                        </div>

                        <input
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirm password"
                            required
                            class="auth-input {{ $errors->has('password_confirmation') ? 'border border-red-500' : '' }}">

                        <button type="submit" class="btn-main">
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

        if (btnGoSignup) {
            btnGoSignup.addEventListener('click', () => {
                pageSignin.style.display = 'none';
                pageSignup.style.display = 'grid';
                window.scrollTo({
                    top: 0
                });
            });
        }

        if (btnGoSignin) {
            btnGoSignin.addEventListener('click', () => {
                pageSignup.style.display = 'none';
                pageSignin.style.display = 'grid';
                window.scrollTo({
                    top: 0
                });
            });
        }
    </script>

</body>

</html>