'use strict';

var browserSync     = require('browser-sync');
var reload          = browserSync.reload;

module.exports = function (gulp, $, config, error) {
  gulp.task('watch', function() {
    gulp.watch(config.php.watch, ['', reload]);
    gulp.watch(config.sass.watch, ['sass', reload]);
    gulp.watch(config.js.watch, ['browserify', reload]);
    gulp.watch(config.fonts.watch, ['fonts', reload]);
    gulp.watch(config.images.watch, ['images', reload]);
  });
};
