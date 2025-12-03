<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">

</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <h1 class="auth-title">{{ __('Register') }}</h1>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Name --}}
                <div class="auth-field">
                    <label for="name" class="auth-label">{{ __('Name') }}</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="auth-input"
                    >
                    @if ($errors->has('name'))
                        <div class="auth-error">
                            @foreach ($errors->get('name') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Email --}}
                <div class="auth-field">
                    <label for="email" class="auth-label">{{ __('Email') }}</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
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
                        autocomplete="new-password"
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

                {{-- Confirm Password --}}
                <div class="auth-field">
                    <label for="password_confirmation" class="auth-label">{{ __('Confirm Password') }}</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        autocomplete="new-password"
                        class="auth-input"
                    >
                    @if ($errors->has('password_confirmation'))
                        <div class="auth-error">
                            @foreach ($errors->get('password_confirmation') as $message)
                                <p>{{ $message }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="auth-actions">
                    <a href="{{ route('login') }}" class="auth-link">
                        {{ __('Already registered?') }}
                    </a>

                    <button type="submit" class="auth-button">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
