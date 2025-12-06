import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/auth/auth.css',
                'resources/css/footer.css',
                'resources/js/app.js',
                'resources/js/footer.js'
            ],
            refresh: true,
        }),
    ],
});
