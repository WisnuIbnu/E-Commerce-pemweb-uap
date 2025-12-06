@extends('layouts.app')

@section('title', 'Login - SORAE')

@section('styles')
<style>
    .login-container {
        max-width: 500px;
        margin: 80px auto;
    }
    
    .login-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(86, 28, 36, 0.1);
    }
    
    .login-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 30px;
    }
    
    .form-floating > .form-control {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
    }
    
    .form-floating > .form-control:focus {
        border-color: var(--primary-color);
    }
    
    .btn-login {
        width: 100%;
        padding: 15px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        margin-top: 20px;
    }
    
    .divider {
        text-align: center;
        margin: 30px 0;
        position: relative;
    }
    
    .divider::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        width: 100%;
        height: 1px;
        background: #e0e0e0;
    }
    
    .divider span {
        background: white;
        padding: 0 15px;
        position: relative;
        color: var(--text-light);
    }
</style>
@endsection

@section('content')
<div class="login-container">
    <div class="login-card">
        <h1 class="login-title">Welcome Back</h1>
        
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="name@example.com" 
                       value="{{ old('email') }}" required>
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">
                    Remember me
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="text-center">
            <p class="mb-2">Don't have an account?</p>
            <a href="{{ url('/register') }}" class="btn btn-outline-primary w-100">
                <i class="fas fa-user-plus"></i> Create Account
            </a>
        </div>
        
        <div class="text-center mt-3">
            <a href="{{ url('/forgot-password') }}" class="text-muted">
                <small>Forgot Password?</small>
            </a>
        </div>
    </div>
</div>
@endsection