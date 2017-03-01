'use strict';

const browserSync     = require('browser-sync');

module.exports = function (gulp, $, config, error) {
  gulp.task('browser-sync', function() {
    return browserSync({
      files: config.dist + config.sass.folder + '*.css', // This makes sure CSS changes are injected without reloading.
      notify: false,
      proxy: config.local_domain
    });
  });
  };
