'use strict';

module.exports = function (gulp, $, config, error) {
  // Place font in Dis map
  return gulp.task('fonts', function() {
    return gulp.src(config.fonts.src)
      .pipe($.plumber({
          errorHandler: error.error
      }))
      .pipe(gulp.dest(config.dist + config.fonts.folder));
  });
};
