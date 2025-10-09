import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  server: {
    host: '0.0.0.0', 
    port: 5173,
    strictPort: true,
    hmr: {
      host: 'host.docker.internal',
      protocol: 'ws',
    },
  },
});
