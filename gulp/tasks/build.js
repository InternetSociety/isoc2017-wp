'use strict';

module.exports = function (gulp, $, config, error) {
  gulp.task('build', function() {
    return ['sass', 'browserify', 'fonts'];
  });
};
