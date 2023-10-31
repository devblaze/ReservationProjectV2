import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        laravel({
            input: 'resources/js/app.ts',
            ssr: 'resources/js/ssr.ts',
            refresh: true,
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

// const path = require('path');
// const { defineConfig } = require('vite');
// const { createVuePlugin } = require('vite-plugin-vue2');
//
// module.exports = defineConfig(({ command, mode }) => {
//     return {
//         plugins: [createVuePlugin()],
//         resolve: {
//             alias: {
//                 '@': path.resolve(__dirname, './resources/js'),
//             },
//         },
//         build: {
//             manifest: true,
//             outDir: 'public/assets',
//             rollupOptions: {
//                 input: 'resources/js/app.js',
//             },
//         },
//         server: {
//             host: 'localhost',
//             port: 3000,
//             strictPort: true,
//             proxy: {
//                 '/api': {
//                     target: 'http://localhost:8000',
//                     changeOrigin: true,
//                     rewrite: (path) => path.replace(/^\/api/, ''),
//                 },
//             },
//         },
//     };
// });
