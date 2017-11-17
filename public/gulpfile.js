var gulp = require('gulp');
var uglify = require('gulp-uglify');
var cleanCSS = require('gulp-clean-css');
var rename = require('gulp-rename');

gulp.task('js', function() {
    gulp.src(['./js/*.js', '!./js/*.min.js'])
        .pipe(uglify())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./js/'));
});

gulp.task('css', function() {
    gulp.src(['./css/*.css', '!./css/*.min.css'])
        .pipe(cleanCSS())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('./css/'));
});

gulp.task('build', function() {
  gulp.start('js', 'css');
})