const {mix} = require('laravel-mix');
const tailwindcss = require('tailwindcss');

mix
  .options({
    processCssUrls: false,
    postCss: [tailwindcss('./tailwind.js')]
  })
  .setPublicPath('public')
  .sass('src/resources/assets/sass/app.scss', 'src/public/css')
  .js('src/resources/assets/js/app.js', 'src/public/js');
