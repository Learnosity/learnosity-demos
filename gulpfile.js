var gulp = require('gulp'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglify'),
    cleanCSS = require('gulp-clean-css'),
    replace = require('gulp-replace'),
    babel = require('gulp-babel');

function scripts() {
    return gulp.src([
        './www/static/vendor/jquery/jquery-1.11.?.min.js',
        './www/static/vendor/bootstrap/js/bootstrap.min.js',
        './www/static/js/prettyPrint.js',
        './www/static/js/main.js',
        './www/static/js/cookieBanner.js'
    ])
    .pipe(concat('all.min.js'))
    .pipe(babel({presets: ['@babel/env']}))
    .pipe(uglify())
    .pipe(gulp.dest('./www/static/dist/'));
}

function styles() {
    return gulp.src([
        './www/static/vendor/bootstrap/css/bootstrap.min.css',
        './www/static/css/main.css'
    ])
    .pipe(concat('all.min.css'))
    .pipe(replace('../fonts/', './fonts/'))
    .pipe(cleanCSS())
    .pipe(gulp.dest('./www/static/dist/'));
}

function copyFonts() {
    return gulp.src([
        './www/static/vendor/bootstrap/fonts/*',
        './www/static/fonts/*'
    ])
    .pipe(gulp.dest('./www/static/dist/fonts/'));
}

// default gulp task
exports.default = gulp.series(scripts, styles, copyFonts);
