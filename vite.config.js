import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";

// import { commonjs } from 'vite-plugin-commonjs';
import { viteCommonjs } from '@originjs/vite-plugin-commonjs';
export default defineConfig({
    plugins: [
        
        laravel({
            input: ["resources/sass/app.scss", "resources/js/app.js"],
            refresh: true,
        }),
        viteCommonjs(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
        },
    },
    // server: {
    //     port: 3000,
    //     open: true,
    //     proxy: {
    //         "/": {
    //             target: "http://localhost:8000",
    //             ws: true,
    //         },
    //     },
    //     hmr: {
    //         overlay: true,
    //     },
    //     root: "public",
    // },
    // build: {
    //     rollupOptions: {
    //         input: {
    //             main: './resources/js/app.js',
    //             play: "./resources/js/play-functions.js",
    //         },
    //     },
    // },
});
