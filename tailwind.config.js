import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            colors: {
                'page': '#FFFCF2',
                'text': {
                    'light': '#CCC5B9',
                    DEFAULT: '#403D39',
                    'dark': '#252422'
                },
                'main': '#FFFCF2',
                'light': '#CCC5B9',
                'neutral': '#403D39',
                'dark': '#252422',
                'accent': '#EB5E28'
            },
            animation: {
                'infinite-scroll': 'infinite-scroll 15s linear infinite',
            },
            keyframes: {
                'infinite-scroll': {
                    from: { transform: 'translateX(50%)' },
                    to: { transform: 'translateX(-50%)' },
                }
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
