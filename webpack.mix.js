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

// Объединяем файлы стилей и js согласно ТЗ

mix.scripts([
    'resources/assets/js/jquery-3.5.0.min.js',
    'resources/assets/js/bootstrap.bundle.min.js',
    'resources/assets/js/feather.min.js',
    'resources/assets/js/dashboard.js',
    ], 'public/js/app.js')
    .scripts([
        'resources/assets/js/script.js',
    ], 'public/js/script.js')
    .styles(['resources/assets/sass/bootstrap.min.css',
        'resources/assets/sass/dashboard.css',
    ], 'public/css/app.css')
    .styles('resources/assets/sass/style.css', 'public/css/style.css');
