@extends('layouts.app')

@section('title', 'Register - SORAE')

@section('styles')
<style>
    .register-container {
        max-width: 600px;
        margin: 50px auto;
    }
    
    .register-card {
        background: white;
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 40px rgba(86, 28, 36, 0.1);
    }
    
    .register-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--primary-color);
        text-align: center;
        margin-bottom: 30px;
    }
    
    .role-selector {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 25px;
    }
    
    .role-option {
        border: 2px solid #e0e0e0;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .role-option:hover {
        border-color: var(--primary-color);
        background-color: rgba(86, 28, 36, 0.05);
    }
    
    .role-option input[type="radio"] {
        display: none;
    }
    
    .role-option input[type="radio"]:checked + label {
        color: var(--primary-color);
    }
    
    .role-option.active {
        border-color: var(--primary-color);
        background-color: rgba(86, 28, 36, 0.1);
    }
    
    .role-icon {
        font-size: 2.5rem;
        margin-bottom: 10px;
        color: var(--primary-color);
    }
</style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-card">
        <h1 class="register-title">Create Account</h1>
        
        <form action="{{ url('/register') }}" method="POST">
            @csrf
            
            <!-- Role Selection -->
            <label class="form-label">I want to:</label>
            <div class="role-selector">
                <div class="role-option active" onclick="selectRole('buyer')">
                    <input type="radio" name="role" value="buyer" id="role_buyer" checked>
                    <label for="role_buyer" style="cursor: pointer;">
                        <div class="role-icon"><i class="fas fa-shopping-bag"></i></div>
                        <strong>Shop</strong>
                        <p class="mb-0 small text-muted">Buy products</p>
                    </label>
                </div>
                <div class="role-option" onclick="selectRole('seller')">
                    <input type="radio" name="role" value="seller" id="role_seller">
                    <label for="role_seller" style="cursor: pointer;">
                        <div class="role-icon"><i class="fas fa-store"></i></div>
                        <strong>Sell</strong>
                        <p class="mb-0 small text-muted">Open a store</p>
                    </label>
                </div>
            </div>
            
            <!-- Name -->
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                       id="name" name="name" placeholder="Full Name" 
                       value="{{ old('name') }}" required>
                <label for="name"><i class="fas fa-user"></i> Full Name</label>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                       id="email" name="email" placeholder="name@example.com" 
                       value="{{ old('email') }}" required>
                <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                       id="password" name="password" placeholder="Password" required>
                <label for="password"><i class="fas fa-lock"></i> Password</label>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">Minimum 8 characters</small>
            </div>
            
            <!-- Confirm Password -->
            <div class="form-floating mb-3">
                <input type="password" class="form-control" 
                       id="password_confirmation" name="password_confirmation" 
                       placeholder="Confirm Password" required>
                <label for="password_confirmation"><i class="fas fa-lock"></i> Confirm Password</label>
            </div>
            
            <!-- Terms & Conditions -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms & Conditions</a>
                </label>
            </div>
            
            <button type="submit" class="btn btn-primary btn-login">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>
        
        <div class="divider">
            <span>OR</span>
        </div>
        
        <div class="text-center">
            <p class="mb-2">Already have an account?</p>
            <a href="{{ url('/login') }}" class="btn btn-outline-primary w-100">
                <i class="fas fa-sign-in-alt"></i> Login
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function selectRole(role) {
        // Remove active class from all options
        document.querySelectorAll('.role-option').forEach(opt => {
            opt.classList.remove('active');
        });
        
        // Add active class to selected option
        event.currentTarget.classList.add('active');
        
        // Check the radio button
        document.getElementById('role_' + role).checked = true;
    }
</script>
@endsection