let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/bootstrap.js', 'public/js')
    .js('resources/assets/js/jquery.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');

mix.browserSync('localhost:8000');

mix.sass('resources/views/auth/login.scss', 'public/css')
    .sass('resources/views/layouts/app_layout.scss', 'public/css')
    .sass('resources/views/dashboard/dashboard.scss', 'public/css')
    .sass('resources/views/route/route.scss', 'public/css')
    .sass('resources/views/announcement/announcement.scss', 'public/css')
    .sass('resources/views/bus/bus.scss', 'public/css')
    .sass('resources/views/driver/driver.scss', 'public/css');
