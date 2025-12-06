@extends('layouts.app')

@section('title', 'My Profile - SORAE')

@section('content')
<div class="row">
    <div class="col-lg-4 mb-4">
        <div class="card text-center">
            <div class="card-body">
                @if($user->role === 'buyer' && $user->buyer && $user->buyer->profile_picture)
                    <img src="{{ asset('storage/' . $user->buyer->profile_picture) }}" 
                         alt="{{ $user->name }}" 
                         class="rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="rounded-circle mb-3 mx-auto d-flex align-items-center justify-content-center"
                         style="width: 150px; height: 150px; background: var(--secondary-color);">
                        <i class="fas fa-user" style="font-size: 4rem; color: var(--primary-color);"></i>
                    </div>
                @endif
                
                <h4 style="color: var(--primary-color);">{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <span class="badge" style="background: var(--primary-color); font-size: 1rem;">
                    {{ ucfirst($user->role) }}
                </span>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user-edit"></i> Edit Profile</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('/profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    @if($user->role === 'buyer')
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone_number" class="form-control" 
                               value="{{ old('phone_number', $user->buyer->phone_number ?? '') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Profile Picture</label>
                        <input type="file" name="profile_picture" class="form-control @error('profile_picture') is-invalid @enderror"
                               accept="image/*">
                        @error('profile_picture')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max 2MB (JPG, PNG)</small>
                    </div>
                    @endif
                    
                    <hr class="my-4">
                    
                    <h5 style="color: var(--primary-color);">Change Password</h5>
                    <p class="text-muted small">Leave blank if you don't want to change password</p>
                    
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" 
                               class="form-control @error('current_password') is-invalid @enderror">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="new_password" 
                               class="form-control @error('new_password') is-invalid @enderror">
                        @error('new_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control">
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection