import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite'; // Khas Tailwind v4

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    // 👇 TAMBAHKAN BLOK SERVER INI
    server: {
        host: '0.0.0.0',
        hmr: {
            host: 'localhost',
        },
        watch: {
            usePolling: true, // Wajib untuk WSL/Docker agar hot-reload mendeteksi perubahan file
        },
    },
});