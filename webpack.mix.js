const mix = require('laravel-mix');
const SVGSpritemapPlugin = require('svg-spritemap-webpack-plugin');

require('laravel-mix-jigsaw');

mix.disableSuccessNotifications();
mix.setPublicPath('source/assets/build/');

mix.js('source/_assets/js/main.js', 'js')
  .js('source/_assets/js/spritemap.js', '')
  .sass('source/_assets/sass/main.scss', 'css/main.css')
  .jigsaw({
    watch: ['config.php', 'source/**/*.md', 'source/**/*.php', 'source/**/*.scss'],
  })
  .options({
      processCssUrls: false,
      postCss: [
        require('tailwindcss'),
      ],
  })
  .webpackConfig({
    plugins: [
      new SVGSpritemapPlugin('source/_assets/icons/*.svg', {
        output: {
          filename: 'icons/spritemap.svg',
          svg4everybody: false,
          svgo: false,
        },
        sprite: {
          generate: {
            symbol: true,
            use: true,
          }
        }
      })
    ]
  })
  .sourceMaps()
  .version();
