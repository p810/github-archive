const gulp = require('gulp'),
      zip  = require('gulp-zip');

/**
 * Metadata about the plugin.
 * 
 * @var object
 */
const plugin = {
    name:      'example-plugin',
    directory: '.'
}

gulp.task('distribute', function () {
    let paths = [
        'vendor/twig/**/*',
        'vendor/composer/**/*',
        'vendor/autoload.php',
        'src/**/*'
    ]
    
    let src = gulp.src(paths, {
        base: './'
    })

    let archive = src.pipe(zip(`${plugin.name}.zip`))

    return archive.pipe(gulp.dest(plugin.directory))
});
