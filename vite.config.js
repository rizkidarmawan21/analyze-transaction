import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/satoshi.css',
                'resources/js/app.js',
                'resources/js/components/chart-01.js',
                'resources/js/components/chart-02.js',
                'resources/js/components/chart-03.js',
                'resources/js/components/chart-04.js',
            ],
            refresh: true,
        }),
    ],
});
