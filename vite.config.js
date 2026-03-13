import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    base: '/', // ensures assets load correctly on Vercel
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: false, // turn off hot reload for static build
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});