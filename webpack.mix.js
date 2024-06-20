const mix = require('laravel-mix');
const WebpackRTLPlugin = require('webpack-rtl-plugin');
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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/vfs_fonts.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .ts('resources/js/app-tsx.tsx', 'public/js')
    .react()
    .webpackConfig({
        plugins: [new WebpackRTLPlugin()],
    })
    .version()
    .sourceMaps();
