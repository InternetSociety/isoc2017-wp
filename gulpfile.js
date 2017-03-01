'use strict';

const fs						= require('fs');
const gulp 					= require('gulp');
const $ 						= require('gulp-load-plugins')(); // Require all gulp plugins
const config 				= require('./gulp/config/config');
const error 				= require('./gulp/tasks/error');

// Loop thrue all tasks and load them
const tasks = fs.readdirSync(config.taskPath);
tasks.forEach(task => {
	if (task === 'error.js') { return; }
	require(config.taskPath + task)(gulp, $, config, error);
});

// ------------- The main tasks list -------------
//
gulp.task('build', ['sass', 'browserify', 'fonts', 'images']);
gulp.task('default', ['sass', 'fonts', 'images', 'browserify', 'browser-sync', 'watch']);

// Call gulp help to view all possible tasks of this gulp file
gulp.task('help', $.taskListing);


// tasks todo
// - Fonts -> font sqrl
