const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  darkMode: 'class',

  content: [
    './src/resources/**/*.blade.php',
    './src/resources/**/*.js',
    './src/resources/**/*.vue',
  ],

  theme: {
    extend: {
      container: {
        center: 'center',
      },

      fontFamily: {
        primary: ['Nunito\\ Sans', ...defaultTheme.fontFamily.sans],
      },
    },
  },

  plugins: [],
};
