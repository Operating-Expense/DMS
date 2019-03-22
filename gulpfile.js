'use strict';
 
// var gulp = require('gulp');
// var sass = require('gulp-sass');
// var cleanCSS = require('gulp-clean-css');
// var rename = require('gulp-rename');
// var autoprefixer = require('gulp-autoprefixer');
// var browserSync = require('browser-sync').create();

// function styles() {
//   return gulp.src('./sass/**/*.scss')
//     .pipe(sass())
//     .pipe(cleanCSS())
//     // pass in options to the stream
    // .pipe(rename({
    //   basename: 'main',
    //   suffix: '.min'
    // }))
//     .pipe(gulp.dest('./css'))
//     .pipe(browserSync.stream());
// }

// function watch() {
//   gulp.watch('./sass/**/*.scss', styles);
// }

// exports.styles = styles;
// exports.watch = watch;


// var build = gulp.series(gulp.parallel(styles/*, scripts*/));

// gulp.task('default', build);



var gulp        = require('gulp');
var browserSync = require('browser-sync').create();
var sass        = require('gulp-sass');
var rename = require('gulp-rename');
var cleanCSS = require('gulp-clean-css');

// Static Server + watching scss/html files
gulp.task('serve', ['sass'], function() {

    browserSync.init({
        server: "./"
    });

    gulp.watch("./sass/*.scss", ['sass']);
    gulp.watch("./*.html").on('change', browserSync.reload);
});

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', function() {
    return gulp.src("./sass/*.scss")
        .pipe(sass())
        .pipe(cleanCSS())
        .pipe(rename({
          basename: 'main',
          suffix: '.min'
        }))
        .pipe(gulp.dest("./css"))
        .pipe(browserSync.stream());
});

gulp.task('default', ['serve']);