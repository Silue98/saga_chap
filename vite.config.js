import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',  // Si tu utilises toujours ce fichier CSS
                'resources/js/app.js',    // Fichier JS
                'resources/sass/app.scss' // Fichier SCSS avec le bon chemin
            ],
            refresh: [`resources/views/**/*`],
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
    },
});
