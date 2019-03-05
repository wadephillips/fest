require('dotenv').config();
const mix = require('laravel-mix');
let exec = require('child_process').exec;
let path = require('path');

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

mix
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')

    .copy('resources/assets/img', 'public/img')
    .extract()
    .browserSync({
      proxy: 'fest.pocacoop.test',
      open: false,
      // https:true
    })
if (! mix.inProduction()) {
  mix.sourceMaps();
} else {
  mix.webpackConfig({
    resolve: {
      // modules: [
      //   path.resolve(__dirname, 'vendor/laravel/spark-aurelius/resources/assets/js'),
      //   'node_modules'
      // ],
      alias: {
        'vue$': 'vue/dist/vue.common.js'
      }
    }
  }).version();
}
;
