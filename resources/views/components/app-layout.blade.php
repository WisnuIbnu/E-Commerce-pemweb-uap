<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'SORAÉ - Elevate Style, Embrace Story' }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <style>
        :root {
            --color-primary: #561C24;
            --color-secondary: #6D2932;
            --color-tertiary: #C7B7A3;
            --color-light: #E8D8C4;
            --color-white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--color-light);
            color: var(--color-primary);
            line-height: 1.6;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Navbar */
        .navbar {
            background-color: var(--color-light);
            padding: 20px 0;
            border-bottom: 1px solid var(--color-tertiary);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar-logo img {
            height: 50px;
        }
        
        .navbar-menu {
            display: flex;
            gap: 40px;
            list-style: none;
        }
        
        .navbar-menu a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .navbar-menu a:hover {
            color: var(--color-secondary);
        }
        
        .navbar-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }
        
        .icon-btn {
            background: none;
            border: none;
            color: var(--color-primary);
            font-size: 20px;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .icon-btn:hover {
            color: var(--color-secondary);
        }
        
        /* Button Styles */
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        
        .btn-primary:hover {
            background-color: var(--color-secondary);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(86, 28, 36, 0.3);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: var(--color-primary);
            border: 2px solid var(--color-primary);
        }
        
        .btn-secondary:hover {
            background-color: var(--color-primary);
            color: var(--color-white);
        }
        
        /* Footer */
        .footer {
            background-color: var(--color-secondary);
            color: var(--color-light);
            padding: 60px 0 30px;
            margin-top: 80px;
        }
        
        .footer-content {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 40px;
            margin-bottom: 40px;
        }
        
        .footer-section h3 {
            color: var(--color-white);
            margin-bottom: 20px;
        }
        
        .footer-section ul {
            list-style: none;
        }
        
        .footer-section ul li {
            margin-bottom: 10px;
        }
        
        .footer-section a {
            color: var(--color-light);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-section a:hover {
            color: var(--color-white);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 30px;
            border-top: 1px solid rgba(199, 183, 163, 0.3);
        }
        
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 15px;
        }
        
        .social-icons a {
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transition: background-color 0.3s;
        }
        
        .social-icons a:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .navbar-menu {
                display: none;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="container navbar-container">
            <div class="navbar-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/soraelogo.png') }}" alt="SORAÉ">
                </a>
            </div>
            
            <ul class="navbar-menu">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('products.index') }}">Collections</a></li>
                <li><a href="#">Brands</a></li>
                <li><a href="#">About Us</a></li>
            </ul>
            
            <div class="navbar-actions">
                <button class="icon-btn">🔍</button>
                @auth
                    <a href="{{ route('transactions.index') }}" class="icon-btn">📦</a>
                    <button class="icon-btn">🛒</button>
                    <a href="#" class="icon-btn">👤</a>
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary" style="padding: 8px 20px; font-size: 14px;">Admin</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                @endauth
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main>
        {{ $slot }}
    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>SORAÉ</h3>
                    <p>2023 Soraé Co. All Rights Reserved</p>
                    <div class="social-icons">
                        <a href="#">📘</a>
                        <a href="#">🔗</a>
                        <a href="#">🐦</a>
                        <a href="#">📷</a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3>Pages</h3>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('products.index') }}">Collections</a></li>
                        <li><a href="#">Brands</a></li>
                        <li><a href="#">About Us</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h3>Contact Us</h3>
                    <ul>
                        <li>+62 123 4567</li>
                        <li>sorae@sorae.com</li>
                        <li>www.sorae.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2023 SORAÉ. All rights reserved.</p>
            </div>
        </div>
    </footer>
    
    @stack('scripts')
</body>
</html>
