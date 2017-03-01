<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */

if ( !function_exists('theme_setup') ) {

	function theme_setup() {

		// include files in od/includes
		od_includes();

		// setup occhio framework
		Framework::Register();

		// add post thumbnail support
		add_theme_support( 'post-thumbnails' );

		// add feed links
		add_theme_support( 'automatic-feed-links' );

		/*
			load textdomain od for theme translations
			usage: <?php echo __('Fill in your name', 'od'); ?>
		*/
		load_theme_textdomain('od', get_template_directory() . '/languages');

		// Display the XHTML generator that is generated on the wp_head hook, WP version
		remove_action( 'wp_head', 'wp_generator' );

		// add css for editor
		add_editor_style( 'dist/css/app.css' );

		// setup theme with presets
		od_setup();
	}
}

if( !function_exists('od_setup') ) {
	/**
	 * Occhio ISOC Theme setup
	 */
	function od_setup() {
		od_setup_main_pages(); // setup theme with preset pages
		od_setup_options();    // setup theme default options
		od_setup_main_menu();  // setup theme with defaul menu
	}
}


if( !function_exists('od_includes') ) {
	/**
	 * Occhio includes
	 */
	function od_includes() {

		// Array with incdirs.
		$aIncDirs = array(
			get_stylesheet_directory() . '/od/includes', // child theme
			// get_template_directory() . '/od/includes',   // parent theme
		);

		// include files in od/includes
		foreach($aIncDirs as $incDir) {
			foreach(scandir($incDir) as $file) {
				if(substr($file, 0, 1) !== '.' && strpos($file, '.php') !== false) require_once($incDir . '/' . $file);
			}
		}
	}
}

// run theme setup
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Enqueue styles
 */
add_action( 'wp_enqueue_scripts', function(){
	wp_enqueue_style( 'app', get_stylesheet_directory_uri() . '/dist/css/app.min.css', '', getLastCssModified(), 'screen' ); // main style
	wp_enqueue_style( 'print', get_stylesheet_directory_uri() . '/dist/css/print.css', '', getLastCssModified(), 'print' ); // print style

/**
 * Enqueue scripts
 */
	wp_enqueue_script( 'jquery'); // jQuery, in head
	wp_enqueue_script( 'vendor', get_stylesheet_directory_uri() . '/dist/js/vendor.js', array( 'jquery' ), getLastJsModified(), $in_footer = true  ); // vendor scripts, in head
});
