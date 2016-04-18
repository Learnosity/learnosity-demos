var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    minifyCSS = require('gulp-minify-css'),
    gulpCopy = require('gulp-copy'),
    replace = require('gulp-replace');

// default gulp task
gulp.task(
    'default',
    [
        'scripts',
        'styles',
        'copy-fonts'
    ],
    function() {}
);

// TASKS...

gulp.task('scripts', function () {
    return gulp.src([
        './www/static/vendor/jquery/jquery-1.11.?.min.js',
        './www/static/vendor/bootstrap/js/bootstrap.min.js',
        './www/static/js/prettyPrint.js',
        './www/static/js/main.js'
    ])
    .pipe(concat('all.min.js'))
    .pipe(uglify())
    .pipe(gulp.dest('./www/static/dist/'));
});

gulp.task('styles', function () {
    gulp.src([
        './www/static/vendor/bootstrap/css/bootstrap.min.css',
        './www/static/vendor/ladda/ladda.min.css',
        './www/static/css/main.css'
    ])
    .pipe(concat('all.min.css'))
    .pipe(replace('../fonts/', './fonts/'))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./www/static/dist/'));
});

gulp.task('copy-fonts', function () {
    return gulp.src('./www/static/vendor/bootstrap/fonts/*')
      .pipe(gulpCopy('./www/static/dist/fonts/', {prefix: 5}));
});
