import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/auth/auth.css',
                'resources/css/header.css',
                'resources/css/footer.css',
                'resources/css/customer/banner.css',
                'resources/css/customer/category.css',
                'resources/css/dashboard.css',
                'resources/css/customer/product/detail.css',
                'resources/js/customer/product/detail.js',
                'resources/js/app.js',
                'resources/js/header.js',
                'resources/js/footer.js',

                // ← HAPUS 'resources/js/dashboard.js' kalau tidak ada
            ],
            refresh: true,
        }),
    ],
});