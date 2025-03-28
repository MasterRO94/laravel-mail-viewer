import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import * as path from 'node:path';
import { resolve } from 'path';
import { defineConfig } from 'vite';
import eslint from 'vite-plugin-eslint2';
import vueDevTools from 'vite-plugin-vue-devtools';

const config = defineConfig({
  server: {
    cors: true,
    hmr: {
      host: 'localhost',
    },
  },

  build: {
    assetsDir: '',

    outDir: resolve(__dirname, './public/assets'),

    rollupOptions: {
      input: [
        './resources/js/app.ts',
        './resources/css/app.css',
      ],
      output: {
        assetFileNames: '[name][extname]',
        entryFileNames: '[name].js',
      },
    },
  },

  plugins: [
    tailwindcss(),

    eslint({
      lintOnStart: true,
      include: ['resources/js/**/*.{js,ts,vue}', 'resources/css/**/*.css'],
    }),

    vue({
      template: {
        transformAssetUrls: false,
      },
    }),

    vueDevTools({
      appendTo: 'app.ts',
      launchEditor: 'phpstorm',
    }),
  ],

  resolve: {
    alias: {
      '@': path.resolve(__dirname, 'resources/js'),
    },
  },
});

export default config;
