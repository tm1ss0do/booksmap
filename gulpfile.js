// gulp
const { src, dest, watch, series, parallel } = require("gulp");
// Sassコンパイル
const sass = require("gulp-sass");
// CSS圧縮
const cleanCSS = require("gulp-clean-css");
//FLOCSS
const sassGlob = require("gulp-sass-glob");
// rename
const rename = require("gulp-rename");
//画像圧縮
const imagemin = require("gulp-imagemin");
//さらにJPEG画像圧縮
const imageminMozjpeg  = require("imagemin-mozjpeg");
//さらにpng画像圧縮
const imageminPngquant  = require("imagemin-pngquant");
//変更されたら実行
const changed = require("gulp-changed");
//browserify
const browserify = require("gulp-browserify");

//監視対象ファイル
const paths = {
  'src': {
    'scss': 'public/assets/css/src/scss/**/**.scss',
    'img': 'public/assets/img/src/*.+(jpg|jpeg|png|gif)',
    'js': 'public/assets/js/src/js/**/*.js'
  },
  'dist': {
    'css': 'public/assets/css/dist/css/',
    'img': 'public/assets/img/dist/',
    'js': 'public/assets/js/dist/js',
  }
};

/**
 * Task
 */
//Sassコンパイル------------------------
const compileSass = () =>
  // style.scssファイルを取得
  src( paths.src.scss )
    // Sassのコンパイルを実行
    .pipe(sassGlob())
    .pipe(sass())
    .pipe(cleanCSS())
    .pipe(rename({
      suffix: ".min",
    }))
    // cssフォルダー以下に保存
    .pipe(dest(paths.dist.css));


//画像圧縮------------------------
var imageminOption = [
  imageminPngquant({ quality: [0.65, 0.8] }),
  imageminMozjpeg({ quality: 85 }),
  imagemin.gifsicle({
    interlaced: false,
    optimizationLevel: 1,
    colors: 256
  }),
  imagemin.mozjpeg(),
  imagemin.optipng(),
  imagemin.svgo()
]

const imageMin = () =>
  // style.scssファイルを取得
  src( paths.src.img )
    // Sassのコンパイルを実行
    .pipe(changed(paths.dist.img))
    .pipe(imagemin(imageminOption))
    // distフォルダー以下に保存
    .pipe(dest(paths.dist.img));

//js------------------------

//browserify
const Browserify = () =>
  // style.scssファイルを取得
  src( paths.src.js )
    // Sassのコンパイルを実行
    .pipe(browserify())
    .pipe(rename("build.js"))
    // distフォルダー以下に保存
    .pipe(dest(paths.dist.js));

/**
* Watch
*/
//Sassコンパイル------------------------
const watchSassFiles = () => watch(paths.src.scss, compileSass);
//画像圧縮------------------------
const watchImage = () => watch(paths.src.img, imageMin);
//browserify------------------------
const watchBrowserify = () => watch(paths.src.js, Browserify);

/**
 * exports
 */
// npx gulp
exports.default = parallel(watchSassFiles, watchImage, watchBrowserify);
