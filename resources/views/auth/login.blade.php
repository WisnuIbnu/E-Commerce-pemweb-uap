@extends('layouts.app')

@section('content')
<div class="container">
    <div class="form-container">
        <h2>Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <input class="input-field" type="email" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
            
            <!-- Password -->
            <input class="input-field" type="password" name="password" placeholder="Password" required>

            <!-- Error message -->
            @if ($errors->has('email') || $errors->has('password'))
                <div class="error-message">
                    <strong>{{ $errors->first('email') }}</strong>
                    <strong>{{ $errors->first('password') }}</strong>
                </div>
            @endif

            <!-- Login Button -->
            <button type="submit" class="btn">Login</button>

            <!-- Register Link -->
            <div class="link">
                Belum punya akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>
        </form>
    </div>
</div>
@endsection
