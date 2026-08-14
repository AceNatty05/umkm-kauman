import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

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
                    accent: '#C8A951',
                    'accent-warm': '#D4956A',
                },
            },
            animation: {
                'fade-up': 'fadeUp 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards',
                'slide-in-right': 'slideInRight 0.4s ease-out forwards',
                'pulse-soft': 'pulseSoft 2s ease-in-out infinite',
            },
            keyframes: {
                fadeUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideInRight: {
                    '0%': { opacity: '0', transform: 'translateX(20px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
            },
            boxShadow: {
                'glow-olive': '0 8px 30px -6px rgba(85, 107, 47, 0.25)',
                'glow-lg': '0 20px 50px -12px rgba(85, 107, 47, 0.3)',
            },
        },
    },

    plugins: [forms, typography],
};
