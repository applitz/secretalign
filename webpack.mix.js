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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .babel([
        'node_modules/@pqina/pintura/pintura.js',
        'node_modules/@pqina/filepond-plugin-image-editor/dist/FilePondPluginImageEditor.js',
    ], 'public/js/all.js');

