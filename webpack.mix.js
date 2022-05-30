const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/global/js')
    .sass('resources/scss/app.scss', 'public/css/app.css')
    .sass('resources/scss/front.scss', 'public/css/front.css')
    .sass('resources/scss/admin.scss', 'public/css/admin.css')
    .sass('resources/scss/account.scss', 'public/css/account.css')
    .sass('resources/scss/pdf.scss', 'public/css/pdf.css');

mix.disableNotifications()
mix.browserSync('fintech.io');
