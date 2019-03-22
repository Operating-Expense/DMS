'use strict';
 
var gulp = require('gulp');
var sass = require('gulp-sass');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');
var autoprefixer = require('gulp-autoprefixer');
 

function styles() {
  return gulp.src('./sass/**/*.scss')
    .pipe(sass())
    .pipe(cleanCSS())
    // pass in options to the stream
    .pipe(rename({
      basename: 'main',
      suffix: '.min'
    }))
    .pipe(gulp.dest('./css'));
}

function watch() {
  gulp.watch('./sass/**/*.scss', styles);
}

exports.styles = styles;
exports.watch = watch;


var build = gulp.series(gulp.parallel(styles/*, scripts*/));

gulp.task('default', build);
