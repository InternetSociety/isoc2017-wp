'use strict';

module.exports = function (gulp, $, config, error) {
  gulp.task('images', function() {
    return gulp.src(config.images.src)
      .pipe($.plumber({ errorHandler: error }))
      // .pipe($.changed(config.images.src)) // Ignore unchanged files
      // .pipe($.imagemin({ // Optimize images
      //   progressive: true,
      //   svgoPlugins: [{
      //     removeTitle: true,
      //     removeViewBox: false
      //   }]
      // }))
      .pipe(gulp.dest(config.dist + config.images.folder));
  });
};
