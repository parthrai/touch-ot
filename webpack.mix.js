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

mix
  .js( 'resources/assets/js/app.js', 'public/js' )
  .js( 'resources/assets/js/app-admin.js', 'public/js' )
  .js( 'resources/assets/js/app-tablet-touch-screen.js', 'public/js' )
  .webpackConfig(
    {
      resolve: {
        alias: {
          '@': path.resolve( 'resources/assets/sass' )
        }
      }
    }
  )
  .sass( 'resources/assets/sass/app.scss', 'public/css' )
  .sass( 'resources/assets/sass/public-tablet.scss', 'public/css' )
  .sass(
    'resources/assets/sass/tablet-touch-screen/main.scss',
    'public/tablet-touch-screen/css'
  ).options(
    {
      processCssUrls: false
    }
  )
  .version();
