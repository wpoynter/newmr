import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
  build: {
    emptyOutDir: true,
    outDir: 'dist',
    rollupOptions: {
      input: path.resolve(__dirname, 'src/index.css'),
      output: {
        assetFileNames: 'style.css',
      },
    },
  },
});
