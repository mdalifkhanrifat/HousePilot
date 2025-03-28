import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');

    return {
        server: {
            host: true, // Better for Docker
            port: 5173,
            strictPort: true,
            hmr: {
                host: 'localhost',
            },
            watch: {
                usePolling: true, // WSL & Docker compatibility
            },
            proxy: {
                '/api': {
                    target: env.VITE_BACKEND_URL || 'http://localhost:8000', // Laravel Backend
                    changeOrigin: true,
                    secure: false,
                    ws: true,
                    rewrite: (path) => path.replace(/^\/api/, ''),
                },
            },
            fs: {
                strict: false, // History Mode Fix
            },
        },
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            vue(),
        ],
        resolve: {
            alias: {
                vue: 'vue/dist/vue.esm-bundler.js',
                '@': path.resolve(__dirname, 'resources/js'),
            },
        },
        define: {
            __VUE_OPTIONS_API__: true,
            __VUE_PROD_DEVTOOLS__: false,
        },
    };
});
