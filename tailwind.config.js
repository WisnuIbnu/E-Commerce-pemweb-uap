import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                'tumbloo': {
                    'black': '#1a1a1a',        
                    'dark': '#2d2d2d',          
                    'darker': '#0a0a0a',        
                    
                    'gray-dark': '#404040',
                    'gray': '#808080',
                    'gray-light': '#d4d4d4',
                    'gray-lighter': '#f5f5f5',
                    
                    'white': '#fafafa',         
                    'off-white': '#f0f0f0',     
                    
                    'accent': '#333333',        
                    'accent-light': '#666666',  
                },
            },
            fontFamily: {
                'sans': ['Inter', 'system-ui', 'sans-serif'],
            },
        },
    },
    plugins: [],
}