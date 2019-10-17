var postcss = require('gulp-postcss');
var gulp = require('gulp');
//var sass = require('gulp-sass');

gulp.task('css', function () {

    return gulp.src('./public/src/*.css')
        //.pipe(sass().on('error', sass.logError))
        .pipe(postcss())
        .pipe(gulp.dest('./public/css/'));
});