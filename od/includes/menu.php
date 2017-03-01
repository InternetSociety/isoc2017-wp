<?php

register_nav_menus( array(
    'primary'       => __( 'Primary Navigation', 'base' ),
    // 'primary-right' => __( 'Primary Navigation (right)', 'base' ),
    // 'footer'        => __( 'Footer Navigation', 'base' ),
    // 'service'       => __( 'Service Navigation', 'base' ),
) );

/* Replace Standart WP Menu Classes */
function change_menu_classes($css_classes) {

    $aCssClasses = array(
        "current-menu-item",
        "current-menu-parent",
        "current_page_item",
        "current-page-ancestor",
        'current_page_parent',
    );

    $replaceCssClass = "active";

    $css_classes = str_replace($aCssClasses, $replaceCssClass, $css_classes);

    return $css_classes;
}
add_filter('nav_menu_css_class', 'change_menu_classes', 100, 1);
add_filter('page_css_class',     'change_menu_classes', 100, 1);

/*
 * Adds archive pages from all posttypes to possible selections when building a menu
 * https://codeseekah.com/2012/03/01/custom-post-type-archives-in-wordpress-menus-2/#tldr
 */

// inject cpt archives meta box
add_action( 'admin_head-nav-menus.php', 'inject_cpt_archives_menu_meta_box' );
function inject_cpt_archives_menu_meta_box() {
	add_meta_box( 'add-cpt', 'Archiefpagina\'s', 'wp_nav_menu_cpt_archives_meta_box', 'nav-menus', 'side', 'default' );
}

// render custom post type archives meta box
function wp_nav_menu_cpt_archives_meta_box() {
	// get custom post types with archive support
	$post_types = get_post_types( array( 'show_in_nav_menus' => true, 'has_archive' => true ), 'object' );

	// hydrate the necessary object properties for the walker
	foreach ( $post_types as &$post_type ) {
		$post_type->classes 	= array();
		$post_type->type 		= $post_type->name;
		$post_type->object_id 	= $post_type->name;
		$post_type->title 		= $post_type->labels->name . ' Archief';
		$post_type->object 		= 'cpt-archive';
		$post_type->menu_item_parent 	= 0;
		$post_type->url 		= 0;
		$post_type->target 		= 0;
		$post_type->attr_title 	= 0;
		$post_type->xfn 		= 0;
		$post_type->db_id 		= 0;
	}

	$walker = new Walker_Nav_Menu_Checklist( array() );
	?>
	<div id="cpt-archive" class="posttypediv">
		<div id="tabs-panel-cpt-archive" class="tabs-panel tabs-panel-active">
			<ul id="ctp-archive-checklist" class="categorychecklist form-no-clear">
		  	<?php echo walk_nav_menu_tree( array_map('wp_setup_nav_menu_item', $post_types), 0, (object) array( 'walker' => $walker) ); ?>
			</ul>
		</div><!-- end of tabs-panel -->

		<p class="button-controls">
			<span class="add-to-menu">
		  		<input type="submit"<?php disabled( $nav_menu_selected_id, 0 ); ?> class="button-secondary right submit-add-to-menu" value="<?php esc_attr_e('Add to Menu'); ?>" name="add-ctp-archive-menu-item" id="submit-cpt-archive" />
				<span class="spinner"></span>
			</span>
		</p>
	</div>
	<?php
}

// take care of the urls
add_filter( 'wp_get_nav_menu_items', 'cpt_archive_menu_filter', 10, 3 );
function cpt_archive_menu_filter( $items, $menu, $args ) {
	// alter the URL for cpt-archive objects
	foreach ( $items as &$item ) {
		if ( $item->object != 'cpt-archive' ) continue;

		$item->url = get_post_type_archive_link( $item->type );

		// set current
		if ( get_query_var( 'post_type' ) == $item->type ) {
			$item->classes []= 'current-menu-item';
			$item->current = true;
		}
	}
	return $items;
}