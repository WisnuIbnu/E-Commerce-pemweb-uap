<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SORAE - Fashion Import')</title>
    
    <!-- Google Fonts - Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #561C24;
            --secondary-color: #E8D8C4;
            --text-dark: #2c3e50;
            --text-light: #6c757d;
        }
        
        * {
            font-family: 'Playfair Display', serif;
        }
        
        body {
            background-color: #f8f9fa;
            color: var(--text-dark);
        }
        
        /* Header Styles */
        .main-header {
            background-color: var(--primary-color);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0;
        }
        
        .navbar-brand {
            font-size: 2rem;
            font-weight: 700;
            color: var(--secondary-color) !important;
            letter-spacing: 3px;
        }
        
        .nav-link {
            color: var(--secondary-color) !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #6d2330;
            border-color: #6d2330;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        /* Footer Styles */
        .main-footer {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            padding: 50px 0 20px;
            margin-top: 80px;
        }
        
        .footer-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            color: #fff;
        }
        
        .footer-link {
            color: var(--secondary-color);
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }
        
        .footer-link:hover {
            color: #fff;
            padding-left: 5px;
        }
        
        .social-icons a {
            color: var(--secondary-color);
            font-size: 1.5rem;
            margin-right: 15px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            color: #fff;
            transform: translateY(-3px);
        }
        
        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }
        
        .card-header {
            background-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 600;
            border-radius: 15px 15px 0 0 !important;
        }
        
        /* Form Styles */
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(86, 28, 36, 0.25);
        }
        
        /* Alert Styles */
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        /* Main Content */
        .main-content {
            min-height: calc(100vh - 400px);
            padding: 40px 0;
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Header -->
    <header class="main-header">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                    <img src="{{ asset('images/logo-sorae.png') }}" alt="SORAE Logo" style="height: 50px; margin-right: 15px;">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="fas fa-home"></i> Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/products') }}">
                                <i class="fas fa-shopping-bag"></i> Products
                            </a>
                        </li>
                        
                        @auth
                            @if(auth()->user()->role === 'buyer')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/transactions') }}">
                                        <i class="fas fa-receipt"></i> My Orders
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'seller')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/seller/dashboard') }}">
                                        <i class="fas fa-store"></i> My Store
                                    </a>
                                </li>
                            @elseif(auth()->user()->role === 'admin')
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/admin/dashboard') }}">
                                        <i class="fas fa-user-shield"></i> Admin
                                    </a>
                                </li>
                            @endif
                            
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/profile') }}">
                                    <i class="fas fa-user"></i> Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <form action="{{ url('/logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="nav-link btn btn-link">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/login') }}">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/register') }}">
                                    <i class="fas fa-user-plus"></i> Register
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="d-flex align-items-center mb-3">
                        <img src="{{ asset('images/logo-sorae.png') }}" alt="SORAE Logo" style="height: 40px; margin-right: 10px;">
                    </div>
                    <p>Premium fashion import store bringing you the finest collections from around the world.</p>
                    <div class="social-icons mt-3">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="footer-title">Quick Links</h3>
                    <a href="{{ url('/') }}" class="footer-link">Home</a>
                    <a href="{{ url('/products') }}" class="footer-link">Products</a>
                    <a href="{{ url('/about') }}" class="footer-link">About Us</a>
                    <a href="{{ url('/contact') }}" class="footer-link">Contact</a>
                </div>
                <div class="col-md-4 mb-4">
                    <h3 class="footer-title">Contact Info</h3>
                    <p><i class="fas fa-map-marker-alt"></i> Malang, East Java, Indonesia</p>
                    <p><i class="fas fa-phone"></i> +62 812-3456-7890</p>
                    <p><i class="fas fa-envelope"></i> info@sorae.com</p>
                </div>
            </div>
            <hr style="border-color: var(--secondary-color); opacity: 0.3;">
            <div class="text-center py-3">
                <p class="mb-0">&copy; 2025 SORAE. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>