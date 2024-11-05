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
                page: "rgb(var(--color-page))",
                main: "rgb(var(--color-main))",
                light: {
                    DEFAULT: "rgb(var(--color-light))",
                    text: "rgb(var(--color-light-text))"
                },
                neutral: {
                    DEFAULT: "rgb(var(--color-neutral))",
                    text: "rgb(var(--color-neutral-text))"
                },
                dark: {
                    DEFAULT: "rgb(var(--color-dark))",
                    text: "rgb(var(--color-dark-text))"
                },
                accent: {
                    DEFAULT: "rgb(var(--color-accent))",
                    light: "rgb(var(--color-accent-light))",
                    dark: "rgb(var(--color-accent-dark))"
                },
                special: 'rgb(var(--color-special))'
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
