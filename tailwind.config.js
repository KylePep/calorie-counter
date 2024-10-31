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
                'main': '#FFFCF2',
                'light': {
                    DEFAULT: '#CCC5B9',
                    'text': '#D4CEC4'
                },
                'neutral': {
                    DEFAULT: '#56524D',
                    'text': '#403D39'
                },
                'dark': {
                    DEFAULT: '#252422',
                    'text': '#252422'
                },
                'accent': {
                    DEFAULT: '#EB5E28',
                    'yellow': "#F6A327",
                    'light': "#EB7328",
                    'dark': '#EB4C28',
                    'red': '#D22E0A'
                },
                'special': '#596D9B'
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

    plugins: [
        function ({ addUtilities }) {
            const newUtilities = {
                '.text-shadow': {
                    textShadow: '2px 2px 4px rgba(0, 0, 0, 0.25)',
                },
                '.text-shadow-md': {
                    textShadow: '3px 3px 6px rgba(0, 0, 0, 0.3)',
                },
                '.text-shadow-lg': {
                    textShadow: '4px 4px 8px rgba(0, 0, 0, 0.4)',
                },
                '.text-shadow-xl': {
                    textShadow: '5px 5px 9px rgba(0, 0, 0, 0.6)',
                },
                '.text-shadow-2xl': {
                    textShadow: '5px 5px 9px rgba(0, 0, 0, 0.8)',
                },
                '.text-shadow-none': {
                    textShadow: 'none',
                },
            };

            addUtilities(newUtilities, ['responsive', 'hover']);
        },
        forms],
};
