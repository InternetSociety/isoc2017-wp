'use strict';

const $ = require('gulp-load-plugins')();
module.exports = function(error) {
  $.notify.onError({
    title:    'Error in ',
    message:  'Error: <%= error.message %>'
  })(error);

 this.emit('end');
};
