const {mix} = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.js')]
  })
  .setPublicPath('public')
  .sass('src/resources/assets/sass/app.scss', 'css')
  .js('src/resources/assets/js/app.js', 'js');
