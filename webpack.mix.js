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
    .sass('resources/assets/sass/app.scss', 'public/css')
    .copy('node_modules/filepond/dist/filepond.min.css', 'public/css/filepond.css')
    .copy('node_modules/filepond/dist/filepond.min.js', 'public/js/filepond.js')
    .copy('node_modules/filepond-plugin-file-encode/dist/filepond-plugin-file-encode.min.js', 'public/js/filepond-plugin-file-encode.js')
    .copy('node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css', 'public/css/filepond-plugin-image-preview.css')
    .copy('node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js', 'public/js/filepond-plugin-image-preview.js')
    .version();
