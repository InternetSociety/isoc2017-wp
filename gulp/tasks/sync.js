'use strict';

module.exports = function (gulp, $, config, error) {
// Place font in Dis map
const rsync = require('rsyncwrapper');

// Create sync paths
const syncPaths = [{
  uploads: {
    local : '../../uploads/',
    dev : config.dev_path + '/wp-content/uploads/',
  }
  },{
    plugins: {
      local : '../../plugins/',
      dev : config.dev_path + '/wp-content/plugins/',
    }
  }, {
    parentTheme: {
      local : '../occhio/',
      dev : config.dev_path + '/wp-content/themes/occhio/',
    }
  }];

  // Default rsync settings
  const rsyncSettings = {
    ssh: true,
    recursive: true,
    syncDest: true,
    args: ['--verbose']
  };

  const rsyncCallback = (err, stdout, stderr, cmd) => {
    if (err) { console.log('err: ', err); }
    console.log(stdout);
  };

  /**
  * loop all sync paths and create gulp tasks
  * call these like:
  * gulp sync:uploads
  * gulp sync:plugins (for wordpress)
  * gulp sync:modules (for drupal)
  * etc
  */
  syncPaths.forEach((single, i, arr) => {
    const key = Object.keys(single)[0]; // get each key of syncPaths array (like: uploads)
    return gulp.task('sync:' + key, () => {
      // add settings to rsync
      rsyncSettings.src = single[key].dev;
      rsyncSettings.dest = single[key].local;
      // log settings
      console.log(rsyncSettings);
      // rsync
      rsync(rsyncSettings, rsyncCallback);
    });
  });
};
