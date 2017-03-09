// Dependencies
var gulp         = require('gulp');
var sass         = require('gulp-sass');
var notify       = require('gulp-notify');
var sourcemaps   = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var uglify       = require('gulp-uglify');
var saveLicense  = require('uglify-save-license');


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

gulp.task('sass-dev', function() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sourcemaps.init())
      .pipe(sass(sassDevOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(sourcemaps.write())
      .pipe(gulp.dest(config.cssPath));
});

gulp.task('sass', function() {
  return gulp
      .src(config.sassPath + '/style.scss')
      .pipe(sass(sassOptions).on('error', notify.onError(function (error) {
          return "Error: " + error.message;
      })))
      .pipe(autoprefixer())
      .pipe(gulp.dest(config.cssPath));
});

// Watch function (sass) - dev use only
gulp.task('watch',function() {
  gulp
    .watch(config.sassPath + '/**/*.scss', ['sass-dev']);
});



// Dev - full dev build
gulp.task('dev', [
            'sass-dev'
          ]);

// Default - full production build
gulp.task('default', [
            'sass'
          ]);
