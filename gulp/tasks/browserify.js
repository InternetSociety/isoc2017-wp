'use strict';

const banner = require('../util/banner');

module.exports = (gulp, $, config, error) => {
  gulp.task('browserify', () => {
    return gulp.src(config.js.src)
    .pipe($.plumber({ errorHandler: error }))
    // .pipe($.sourcemaps.init())

    .pipe($.browserify({ // Compile JS
      insertGlobals: false
    }))
    .pipe($.babel({ // Compile ES6
      presets: ['es2015']
    }))
    // .pipe($.uglify())

    // .pipe($.header(banner.full))
    .pipe($.rename(config.js.largeFile))
    .pipe(gulp.dest(config.dist + config.js.folder))

    .pipe($.uglify()) // Minify js
    // .pipe($.sourcemaps.write('./'))
    .pipe($.rename(config.js.destFile))
    .pipe(gulp.dest(config.dist + config.js.folder));
  });
};
