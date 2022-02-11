let mix = require('laravel-mix');

mix
  .js('src/resources/assets/js/app.js', 'src/public/js')
  .vue({ version: 3 })
  .postCss('src/resources/assets/css/app.css', 'src/public/css', [
    require('tailwindcss'),
  ]);
