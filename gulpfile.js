'use strict';

const gulp = require('gulp');
const minify = require('gulp-minifier');

gulp.task('build', () => {
    return gulp.src(['src/**'])
        .pipe(minify({
            minify: true,
            collapseWhitespace: true,
            conservativeCollapse: true,
            minifyJS: true,
            minifyCSS: true
        })).pipe(gulp.dest('dest/'));
});
