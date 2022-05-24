const mix = require('laravel-mix');
// Admin
mix.setPublicPath('public/dist/admin');
mix.sass('resources/admin/scss/vendors.scss', 'css')
    .sass('resources/admin/scss/app.scss', 'css');
mix.js('resources/admin/js/app.js','js').extract(['vue']).vue({ version: 2 });
