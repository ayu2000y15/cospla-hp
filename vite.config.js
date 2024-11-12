import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['public/css/style.css'
                , 'public/css/admin-style.css'
                , 'public/css/admin-common.css'
                , 'public/css/admin-photos.css'
                , 'resources/js/app.js'
                , 'public/js/admin-script.js'
                , 'public/js/script.js'
            ],
            refresh: true,
        }),
    ],
});
