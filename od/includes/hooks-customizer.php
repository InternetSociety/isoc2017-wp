<?php

add_action( 'customize_register', function( $wp_customize ) {

	// add logo upload to Site Identity
	$wp_customize->add_setting( 'isoc_logo' );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'isoc_logo', array(
		'label'       => __( 'Chapter Logo', 'od' ),
		'section'     => 'title_tagline',
		'settings'    => 'isoc_logo',
		'description' => __('The Chapter Logo is used to display in the menu bar. Logos must be rectangular (landscape) and at least 200 pixels wide and 50 pixels tall.', 'od'),
	)) );

	// add menu color setting to Site Identity
	$wp_customize->add_setting( 'isoc_menucolor', array(
        'default'     => 'normal',
        'transport'   => 'postMessage'
    ) );
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'isoc_menucolor', array(
		'label'       => __( 'Menu Color', 'od' ),
		'section'     => 'title_tagline',
		'settings'    => 'isoc_menucolor',
		'type'        => 'select',
		'choices'     => array(
			'light'   => __('Light', 'od'),
			'normal'  => __('Normal', 'od'),
		),
	)) );

	$wp_customize->add_section( 'isoc_defaults', array(
		'title'       => __('ISOC Defaults', 'od'),
		'priority'    => 80,
		'description' => '',
	) );

	// add header upload to Site Identity
	$wp_customize->add_setting( 'isoc_header' );
	$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, 'isoc_header', array(
		'label'       => __( 'Default Header', 'od' ),
		'section'     => 'isoc_defaults',
		'settings'    => 'isoc_header',
		'description' => __('The Default Header is used as a fallback when no Featured Image is provided. Headers must be rectangular (landscape) and at least 1600 pixels wide and 500 pixels tall.', 'od'),
	)) );

	// add menu color setting to Site Identity
	$wp_customize->add_setting( 'isoc_404' );
	$wp_customize->add_control( new WP_Customize_Control($wp_customize, 'isoc_404', array(
		'label'       => __( '404 Page', 'od' ),
		'section'     => 'isoc_defaults',
		'settings'    => 'isoc_404',
		'type'        => 'dropdown-pages',
		'description' => __('The 404 Page is shown when the visitor ends up on a page that is not there.', 'od'),
	)) );
});

/**
 * Gets the post thumbnail url (headersize) or the fallback image url
 * @return   string   The URL of the header image
 */
function od_get_header_url( $post_id ) {
	// Check if header is set
	if( has_post_thumbnail( $post_id ) && (is_single() || is_page()) ) {
		$sHeaderUrl = get_the_post_thumbnail_url($post_id, 'header');
	} else {
		$sHeaderUrl = esc_url( get_theme_mod('isoc_header') );
		if( !$sHeaderUrl ) {
			$sHeaderUrl = get_stylesheet_directory_uri().'/dist/img/header-isoc.png';
			set_theme_mod( 'isoc_header', $sHeaderUrl );
		}
	}
	return $sHeaderUrl;
}

/**
 * Gets the ISOC logo url or the fallback logo url
 * @return   string   The URL of the logo
 */
function od_get_logo_url() {
	// Check if ISOC logo is set
	$sLogoUrl = esc_url( get_theme_mod('isoc_logo') );
	if( !$sLogoUrl ) {
		$sLogoUrl = get_stylesheet_directory_uri().'/dist/img/main-logo-isoc.png';
		set_theme_mod( 'isoc_logo', $sLogoUrl );
	}
	return $sLogoUrl;
}

/**
 * Gets the menu color settings
 * @return   string   The menu color settings
 */
function od_get_menu_color() {
	// Check if menu color is set
	$sMenuColor = get_theme_mod( 'isoc_menucolor' );
	if( !$sMenuColor ) {
		$sMenuColor = 'normal';
		set_theme_mod( 'isoc_menucolor', $sMenuColor );
	}
	return $sMenuColor;
}

function od_get_favicon() {
	// Check if favicon is set
	$sFavicon = get_theme_mod( 'site_icon' );
	if( !$sFavicon ) { $sFavicon = get_stylesheet_directory_uri().'/favicon.ico'; }
	return '<link rel="shortcut icon" href="'.$sFavicon.'" />';
}
add_action('wp_head', 'od_get_favicon');

function od_get_404_page() {
	$iNotFound = get_theme_mod( 'isoc_404' );
	if( !$iNotFound ) {
		$oPage     = get_page_by_path( 'not-found' );

		// check if page exists, else create a page
		if( !isset($oPage->ID) ) {
			$iPageId = od_create_page( __('Oops! This page is not found', 'od'), 90, "<h2>Something went wrong!</h2><p>The page you're looking for, was not found.</p><h2>What went wrong?</h2><p>The page you looked for, doesn't exist (anymore) or is moved to another location.</p><h2>What can you do now?</h2><p>Check the url you provided.</p>", 'od' );
			$oPage   = get_post($iPageId);
		}
		$iNotFound = $oPage->ID;
		set_theme_mod( 'isoc_404', $iNotFound );
	}
	return $iNotFound;
}

function od_get_page_color( $post_id ) {
	$sColor = get_post_meta( $post_id, 'isoc_pagecolor', TRUE );
	if( !$sColor ) {
		$sColor = 'beige';
	}
	return $sColor;
}

function od_page_color( $post_id ) {
	echo od_get_page_color( $post_id );
}
