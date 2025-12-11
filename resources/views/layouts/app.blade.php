{{-- File: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite([
            'resources/css/app.css',
            'resources/css/auth/auth.css',
            'resources/css/header.css',
            'resources/css/footer.css',
            'resources/css/customer/banner.css',
            'resources/css/customer/category.css',
            'resources/css/dashboard.css',
            'resources/js/app.js',
            'resources/js/header.js',
            'resources/js/footer.js'
        ])

        <!-- Fix Modal & Overlay Issues -->
        <style>
            /* Paksa body bisa scroll */
            body {
                overflow: auto !important;
                padding-right: 0 !important;
            }

            /* Sembunyikan backdrop yang tertinggal */
            .modal-backdrop {
                display: none !important;
            }

            /* Fix z-index issues */
            .modal-open {
                overflow: auto !important;
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        
        <!-- Header -->
        @include('layouts.header')

        <div class="min-h-screen bg-gray-100">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        @include('layouts.footer')

        <!-- Fix JavaScript Errors & Modal Issues -->
        <script>
            // Jalankan setelah DOM loaded
            document.addEventListener('DOMContentLoaded', function() {
                
                // Fix 1: Hapus semua modal backdrop yang tertinggal
                setTimeout(function() {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    backdrops.forEach(backdrop => {
                        backdrop.remove();
                    });
                }, 100);

                // Fix 2: Pastikan body bisa di-scroll
                document.body.classList.remove('modal-open');
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';

                // Fix 3: Tutup semua modal yang mungkin terbuka (Bootstrap 5)
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                });

                // Fix 4: Jika pakai jQuery & Bootstrap 4
                if (typeof $ !== 'undefined' && $.fn.modal) {
                    $('.modal').modal('hide');
                    $('.modal-backdrop').remove();
                    $('body').removeClass('modal-open');
                    $('body').css('overflow', 'auto');
                }

                // Fix 5: Handle klik di luar modal (jika ada)
                document.addEventListener('click', function(e) {
                    if (e.target.classList.contains('modal-backdrop')) {
                        e.target.remove();
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = 'auto';
                    }
                });

                console.log('✅ Layout fixes applied');
            });

            // Fix 6: Cegah body scroll lock
            window.addEventListener('load', function() {
                document.body.style.overflow = 'auto';
                document.body.style.paddingRight = '0';
            });
        </script>
    </body>
</html>