// Dependencies
var gulp         = require('gulp');
    sass         = require('gulp-sass');
    notify       = require('gulp-notify');
    sourcemaps   = require('gulp-sourcemaps');
    autoprefixer = require('gulp-autoprefixer');
    uglify       = require('gulp-uglify');
    saveLicense  = require('uglify-save-license');


// Path Configs
var config = {
  sassPath: './sass',
  cssPath:  '.',
  npmPath:  './node_modules'
}

/**
 * Sass Configurations
 *
 * Dev and Prod configuration profiles for sass
 *
 **/

// Production
var sassOptions = {
  outputStyle: 'compressed',
  sourceComments: false,
  includePaths: [
      config.sassPath,
      config.npmPath + '/bootstrap-sass/assets/stylesheets',
      config.npmPath + '/bourbon/app/assets/stylesheets',
      config.npmPath + '/bootstrap-accessibility-plugin/plugins/css'
  ],
  precision: 10
}

//Dev
var sassDevOptions = {
  outputStyle: 'nested',
  sourceComments: true,
  includePaths: [
      config.sassPath,
      config.npmPath + '/bootstrap-sass/assets/stylesheets',
      config.npmPath + '/bourbon/app/assets/stylesheets',
      config.npmPath + '/bootstrap-accessibility-plugin/plugins/css'
  ],
  precision: 10
}

/**
 * Uglify Options
 *
 * Tell uglify to keep certiain comments, etc
 *
 **/
var uglifyOptions = {
  output: {
    comments: saveLicense
  }
}

/**
 * Sass Compilers
 *
 * Dev and Prod compilers
 *
 **/
function sassDev() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sourcemaps.init())
      .pipe(sass(sassDevOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.cssPath));
}

function sassProd() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sass(sassOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(gulp.dest(config.cssPath));
}


function watch() {
  sassDev();
  gulp.watch(config.sassPath + '/**/*.scss', sassDev)
}



// Dev - full dev build
const dev = gulp.series(sassDev);

// Default - full production build
const prod = gulp.series(sassProd);


// Export Tasks for Use
exports.dev = dev;
exports.default = prod;
exports.watch = watch;