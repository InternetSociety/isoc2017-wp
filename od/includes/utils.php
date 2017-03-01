<?php

/* Useful utils
/* ------------------------------------ */

/**
 * Strips url from obsolete stuff, for prettier display
 * @param      string  $url    The url
 * @return     string  The cleaned up & pretty url for displaying
 */
function od_strip_url( $url ) {
	return rtrim( str_replace(array( 'https://', 'http://', 'www.' ), '', $url), '/' );
}

/**
 * Creates a link with attributes (if provided) => no more dirty HTML in php
 * @param      string  $url    The url (can be post id too)
 * @param      string  $text   The text
 * @param      array   $attr   The attribute
 * @return     string  The compiled <a href...>
 */
function od_get_link( $url, $text, $attr = NULL ) {
	// early exit on no values
	if( empty($url) || empty($text) || $url == 'mailto:' || $url == 'tel:' ) { return; }

	// check if url is just a post id
	if( is_int($url) ) {
		$post_id = $url;
		$url     = get_the_permalink( $post_id );
		// early exit
		if( empty($url) ) { return; }
	}

	// setup start of a href
	$html = '<a href="'.str_replace( ' ', '', $url ).'"';

	// add attributes
	if( $attr != NULL ) {
		foreach( $attr as $name => $value ) { $html .= ' '.$name.'="'.$value.'"'; }
	}

	// finish off the link
	$html .= '>'.$text.'</a>';

	// and return
	return $html;
}
function od_link( $url, $text, $attr = NULL ) {
	echo od_get_link( $url, $text, $attr = NULL );
}

/**
 * Adds an extra class on content p's
 * @param      string  $sContent  The content
 * @param      string  $sClass    The class
 * @return     string  Pretty content with added class
 */
function od_add_content_class( $sContent, $sClass = NULL ) {

	$sPrettyContent = apply_filters( 'the_content', $sContent );
	return str_replace( '<p>', '<p class="'.$sClass.'">', $sPrettyContent );
}

/**
 * Gets the post/page ID by slug
 * @param    string   $object_slug   The post slug
 * @return   integer/NULL   The post ID
 */
function od_get_id_by_slug( $object_slug ) {
	$object = get_page_by_path( $object_slug );
	if( $object ) { return $object->ID; }
	else { return NULL; }
}

/**
 * Method to check if a slug exists
 * @param      string   $slug  The post name
 * @return     boolean  If the slug exists
 */
function od_slug_exists( $slug ) {
	global $wpdb;
	if( $wpdb->get_row("SELECT post_name FROM od_posts WHERE post_name = '".$slug."'", 'ARRAY_A') ) { return TRUE; }
	else { return FALSE; }
}
