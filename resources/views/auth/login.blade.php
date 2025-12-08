<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">{{ __('Log in') }}</h1>

            {{-- Session Status --}}
            @if (session('status'))
                <div class="auth-status">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                {{-- Email --}}
                <div class="auth-field">
                    <label for="email" class="auth-label">{{ __('Email') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="username"
                        class="auth-input"
                    >
                    @if ($errors->has('email'))
                        <div class="auth-error">
                            @foreach ($errors->get('email') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Password --}}
                <div class="auth-field">
                    <label for="password" class="auth-label">{{ __('Password') }}</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        autocomplete="current-password"
                        class="auth-input"
                    >
                    @if ($errors->has('password'))
                        <div class="auth-error">
                            @foreach ($errors->get('password') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Remember me --}}
                <div class="auth-remember">
                    <label for="remember_me" class="auth-remember-label">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            class="auth-checkbox"
                        >
                        <span class="auth-remember-text">{{ __('Remember me') }}</span>
                    </label>
                </div>

                {{-- Actions --}}
                <div class="auth-actions">
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="auth-link"
                        >
                            {{ __("Don’t have an account?") }}
                        </a>
                    @endif

                    <button type="submit" class="auth-button">
                        {{ __('Log in') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>