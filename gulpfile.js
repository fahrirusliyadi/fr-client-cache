const gulp  = require('gulp');
const zip   = require('gulp-zip');

gulp.task('zip', () =>
	gulp.src([
        '**',
        '!bin/**',
        '!coverage-report/**',
        '!node_modules/**',
        '!tests/**',
        '!vendor/**',
        '!.*',
        '!composer.*',
        '!gulpfile.js',
        '!package*.json',
        '!phpunit.xml.*'
    ], {
        base: '..'
    })
		.pipe(zip('fr-client-cache.zip'))
		.pipe(gulp.dest('..'))
);