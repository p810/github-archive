var gulp  = require('gulp'),
    less  = require('gulp-less'),
    watch = require('gulp-watch'),
    clean = require('gulp-clean-css');

function build (filepath) {
    return gulp
            .src('./src/less/main.less')

            .pipe(less({
                paths: [ './less' ]
            }))

            .pipe(clean({debug: true}, function (data) {
                console.info('Reduced filesize from ' + data.stats.originalSize + ' to ' + data.stats.minifiedSize + ' bytes');
            }))

            .pipe(gulp.dest('./www/css'));
}

gulp.task('default', function () {
    return watch('./src/less/**/*.less', function () {
        build();
    });
});
