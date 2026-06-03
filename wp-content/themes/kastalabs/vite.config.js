import { defineConfig } from 'vite';
import { resolve } from 'node:path';
import tailwindcss from '@tailwindcss/vite';

/**
 * Vite config untuk KastaLabs WordPress theme.
 *
 * Output keluar di /dist/. PHP enqueue (inc/enqueue.php) membaca
 * dist/manifest.json untuk dapat URL hash final.
 *
 * Saat dev: jalankan `npm run dev` di terminal, set
 * `define('KASTA_VITE_DEV', true);` di wp-config.php supaya
 * theme inject bundle dari Vite dev server, bukan dari /dist/.
 */
export default defineConfig({
  base: '/wp-content/themes/kastalabs/dist/',
  plugins: [tailwindcss()],
  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: {
        app: resolve(import.meta.dirname, 'src/js/app.js'),
        editor: resolve(import.meta.dirname, 'src/css/editor.css'),
      },
    },
  },
  server: {
    port: 5173,
    strictPort: true,
    cors: true,
    origin: 'http://localhost:5173',
  },
});