import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                olive: {
                    50: '#f6f7f0',
                    100: '#e8ebd8',
                    200: '#d3d9b5',
                    300: '#b5c08a',
                    400: '#9aaa65',
                    500: '#7d8e48',
                    600: '#627137',
                    700: '#4b572d',
                    800: '#3e4727',
                    900: '#353d24',
                    950: '#1a2010',
                },
                kauman: {
                    primary: '#556B2F',
                    'primary-dark': '#3E5021',
                    'primary-light': '#8FBC5A',
                    secondary: '#2E5090',
                    card: '#F0F4E8',
                    'card-border': '#A8C686',
                    body: '#F5F5F0',
                    whatsapp: '#25D366',
                },
            },
        },
    },

    plugins: [forms],
};
