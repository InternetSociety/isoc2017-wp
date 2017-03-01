<?php

// Move all "advanced" metaboxes above the default editor
add_action('edit_form_after_title', function() {
    global $post, $wp_meta_boxes;
    do_meta_boxes( get_current_screen(), 'advanced', $post );
    unset( $wp_meta_boxes[get_post_type($post)]['advanced'] );
});

function od_metabox_set_page_color( $page ) {

	$aOptions   = array('beige', 'blue', 'purple', 'turquoise', 'yellow');
	$sSelected  = get_post_meta( $page->ID, 'isoc_pagecolor', TRUE );

	if( !$sSelected ) {
		$sSelected = 'beige';
	}

	wp_nonce_field('page-'.$page->ID, 'od_color_nonce');
	Template::Render( 'admin-metabox-color', array('aOptions' => $aOptions, 'sSelected' => $sSelected) );
}

add_action( 'add_meta_boxes_page', function( $page ) {
	add_meta_box( 'isoc_pagecolor', __( 'Page Color', 'od' ),
		'od_metabox_set_page_color', 'page', 'side', 'high'
	);
});

add_action('save_post', function( $post_id, $post, $update ) {
	// early exits
	if( $post->post_type != 'page' ) return $post_id;
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return $post_id;
	if( !isset($_POST['od_color_nonce']) || !wp_verify_nonce($_POST['od_color_nonce'], 'page-'.$post_id) ) return $post_id;
	if( !current_user_can('edit_post', $post_id) ) return $post_id;

	// set page color
	delete_post_meta( $post_id, 'isoc_pagecolor' );
	$sSelectedPageColor = ( isset($_POST['isoc_pagecolor']) ) ? $_POST['isoc_pagecolor'] : 'beige';
	if( !add_post_meta( $post_id, 'isoc_pagecolor', $sSelectedPageColor, TRUE) ) {
		update_post_meta( $post_id, 'isoc_pagecolor', $sSelectedPageColor );
	}

	return $post_id;

}, 10, 3);
