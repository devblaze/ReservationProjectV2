// V3
// import { defineConfig } from 'vite';
// import vue from '@vitejs/plugin-vue';
// import path from 'path';
//
// export default defineConfig({
//     plugins: [vue()],
//     resolve: {
//         alias: {
//             '@': path.resolve(__dirname, './resources/js'),
//         },
//     },
// });


// V2
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import * as fs from "node:fs";

export default defineConfig(({ command }) => {
    const hmrHost = process.env.VITE_HMR_HOST || 'localhost'; // Local IP

    return {
        server: {
            host: '0.0.0.0', // Bind to all interfaces
            port: 5173,      // Vite development server port
            hmr: {
                host: hmrHost,
                port: 5173,
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
    };
});

// V1
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
