const {mix} = require('laravel-mix');

mix
    .options({
        processCssUrls: false
    })
    .sass('src/resources/assets/sass/app.scss', 'src/public/css')
    .js('src/resources/assets/js/app.js', 'src/public/js');
