export default {
    content: [
        './resources/views/**/*.blade.php',
        './storage/framework/views/*.php',
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                softgray: '#e5e7eb',
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
}