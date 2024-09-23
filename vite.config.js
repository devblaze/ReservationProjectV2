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

export default defineConfig({
    server: {
        host: '0.0.0.0',  // Bind Vite to all interfaces, so it will be accessible from the network.
        port: 5173,        // Ensure Vite is running on port 5173 (or any other open port).
        hmr: {
            host: '192.168.4.1',  // Replace with the local IP address of your server / PC running Vite.
            port: 5173,           // The same port for HMR.
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
