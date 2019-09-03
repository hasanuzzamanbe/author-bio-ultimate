let mix = require('laravel-mix');

mix.setResourceRoot('../');
mix
    .js('src/js/Boot.js', 'dist/js/boot.js')
    .js('src/js/main.js', 'dist/js/author-bio.js')
    // .js('src/admin/main.js', 'dist/admin/css/chart-maker-admin.css')
