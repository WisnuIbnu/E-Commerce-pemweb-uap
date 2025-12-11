import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/pages/landing.css',
                'resources/css/pages/user.css',    // FIX
                'resources/css/pages/seller.css',  // FIX
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
