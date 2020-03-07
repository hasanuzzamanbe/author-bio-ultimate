let mix = require('laravel-mix');

mix.setPublicPath('dist');
mix.setResourceRoot('../');
mix
    .js('src/js/Boot.js', 'dist/js/boot.js')
    .js('src/js/main.js', 'dist/js/author-bio.js')
    .js('src/integrations/tinymce.js', 'dist/js/tinymce.js')
    .js('src/Frontend/author-bio.js', 'dist/admin/js/author-bio-frontent.js')

    // .js('src/admin/main.js', 'dist/admin/css/chart-maker-admin.css')
    .sass('src/scss/public/public.scss', 'dist/admin/css/author-bio-public.css')
    .sass('src/scss/admin/app.scss', 'dist/admin/css/author-bio-admin.css')
    .copy('src/libs', 'dist/libs')
    .copy('src/integrations/tinymce_icon.png', 'dist/js/tinymce_icon.png')
    .copy('src/templates', 'dist/admin/templates')
