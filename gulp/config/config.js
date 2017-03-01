'use strict';

const config = {};

config.cms = 'worpress';
config.domain = 'isoc.nl';
config.dev_user = 'root';
config.dev_domain = config.domain + '.dev.occhio.nl';
config.local_domain = 'local.' + config.domain;
config.dev_path = config.dev_user + '@' + config.dev_domain + ':/var/www/vhosts/' + config.domain + '/httpdocs';

config.dist = './dist/';
config.taskPath = './gulp/tasks/';

config.sass = {
  src: './src/sass/app.scss',
  watch: 'src/sass/**/*.scss',
  destFile: 'app.min.css',
  largeFile: 'app.css',
  folder: 'css'
};

config.js = {
  src: './src/js/vendor/*.js',
  watch: 'src/js/vendor/*.js',
  destFile: 'vendor.min.js',
  largeFile: 'vendor.js',
  folder: 'js'
};

config.fonts = {
  src: './src/fonts/**/*',
  watch: './src/fonts/**/*',
  folder: 'fonts'
};

config.images = {
    watch: 'src/img/**/**',
    src: './src/img/**/**',
    folder: 'img'
};

config.php = {
  watch: ['*.php', '**/*.php'],
};

module.exports = config;
