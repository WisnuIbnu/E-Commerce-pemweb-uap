/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
      "./resources/views/**/*.blade.php",
      "./resources/js/**/*.js",
      "./resources/css/**/*.css",
  ],

  theme: {
    extend: {
      colors: {
        sweet: {
          50: '#F5FAFE',
          100: '#E9F4FE',
          200: '#CFF8FF',
          300: '#9AE0FF',
          400: '#42A5F5',
          500: '#0085CC',
          600: '#006DB1',
          700: '#005499',
          800: '#003B75',
          900: '#001D40',
        },
        textdark: '#1B1B1B',
        softgray: '#FAFAFA',
      },
      boxShadow: {
        'soft-lg': '0 10px 25px rgba(13, 42, 67, 0.06)',
      }
    },
  },

  plugins: [
    require('@tailwindcss/forms'),
  ],
};