const mix = require('laravel-mix');
const path = require( 'path' );

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

mix.options({
    inProduction: process.env.NODE_ENV=='production' ? true : false,
    setResourceRoot: path.normalize('src'),
    publicPath: path.normalize('./assets'),
    processCssUrls: false, //we want to use relative image urls
});

//admin assets
mix.js(	 'src/admin/js/global.js',       'assets/admin/js/global.js')
   .js(	 'src/admin/js/menupage.js',     'assets/admin/js/menupage.js')
   .sass('src/admin/scss/global.scss',   'assets/admin/css/global.css')
   .sass('src/admin/scss/menupage.scss', 'assets/admin/css/menupage.css');

//public assets
mix.js(	 'src/public/js/public.js',      'assets/public/js/public.js')
   .sass('src/public/scss/public.scss',  'assets/public/css/public.css');

//mix.disableNotifications();

if (mix.config.inProduction){
  mix.version();
}
