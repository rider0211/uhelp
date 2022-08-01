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
 mix.sass('resources/assets/updatestyle/updatestyles.scss', 'public/assets/css')
 mix.sass('resources/assets/scss/style.scss', 'public/assets/css')
 mix.copyDirectory('resources/assets/custom-theme/custom', 'public/assets/css')
 mix.sass('resources/assets/custom-theme/dark.scss', 'public/assets/css')
 mix.sass('resources/assets/custom-theme/skin-modes.scss', 'public/assets/css')
 mix.sass('resources/assets/custom-theme/sidemenu.scss', 'public/assets/css')
 mix.copyDirectory('resources/assets/plugins', 'public/assets/plugins')
 mix.copyDirectory('resources/assets/images', 'public/assets/images')
 mix.copyDirectory('resources/assets/plugins/sticky', 'public/assets/js')
 mix.js('resources/assets/js/jquery.showmore.js', 'public/assets/js')
 mix.js('resources/assets/js/custom.js', 'public/assets/js')
 mix.js('resources/assets/js/form-browser.js', 'public/assets/js')
 mix.js('resources/assets/js/select2.js', 'public/assets/js')
 mix.js('resources/assets/js/support/support-ticketview.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-createticket.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-admindash.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-articles.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-customer.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-sidemenu.js', 'public/assets/js/support')
 mix.js('resources/assets/js/support/support-landing.js', 'public/assets/js/support')


 mix.options({
    processCssUrls: false
});

mix.browserSync('http://127.0.0.1:8000');
