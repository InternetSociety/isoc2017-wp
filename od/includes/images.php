<?php
// setup  image sizes: $name, $width, $height, $crop
if( function_exists('add_image_size') ) {
	// setup image sizes: $name, $width, $height, $crop
	// add_image_size( 'header_image', 500, 300, true );
	add_image_size( 'ogimage', 640, 428, true );
	add_image_size( 'admin_preview', 300, 200, false );
	add_image_size( 'header', 999999, 500, true );
	add_image_size( 'square', 200, 200, true );
}

// editor images: https://premium.wpmudev.org/blog/adding-custom-images-sizes-to-the-wordpress-media-library/
// add_filter('image_size_names_choose', function( $aSizes ) {
//	$aAddSizes = array(
// 		'header_image' => __( 'Header image', 'od' ),
// 	);
// 	$aNewSizes = array_merge( $aSizes, $aAddSizes );
// 	return $aNewSizes;
// });