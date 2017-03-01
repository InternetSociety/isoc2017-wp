<?php
// hooks for programmatically seting up some setup basic pages, menu and stuff

/**
 * Set some main options on activating this theme
 */
function od_setup_options() {
	if( isset($_GET['activated']) && is_admin() ) {
		// set homepage
		if( get_option( 'show_on_front' ) != 'posts' ) {
			update_option( 'show_on_front', 'posts' );
		}

		// set permalink structure
		if( get_option( 'permalink_structure' ) != '/%postname%/' ) {
			od_setup_rewrite_permalinks();
		}

		// set main category to news, instead of "no category"
		$oMainTerm = get_term_by('id', 1, 'category');
		if( $oMainTerm->name == __('Uncategorized') ) {
			wp_update_term( 1, 'category', array(
				'name' => __('News', 'od'),
				'slug' => 'news'
			));
		}

		// set main widgets
		$aWidgets = get_option('sidebars_widgets');
		if( !isset($aWidgets['sidebar_home'][0]) ) {
			$aWidgets['sidebar_home'][0] = 'text';
		}
		if( !isset($aWidgets['sidebar'][0]) ) {
			$aWidgets['sidebar'][0] = 'recent-posts';
		}
		update_option( 'sidebars_widgets', $aWidgets );
	}
}

function od_setup_rewrite_permalinks() {
	global $wp_rewrite;
	// write the rule
	$wp_rewrite->set_permalink_structure('/%category%/%postname%/');
	// set the option
	update_option( "rewrite_rules", FALSE );
	// flush the rules and tell it to write htaccess
	$wp_rewrite->flush_rules( true );
}

/**
 * Creates pages right into de WP DB
 * @param      string   $sPageTitle  The page title
 * @param      integer  $iMenuOrder  The menu order number
 * @return     integer  The page ID
 */
function od_create_page( $sPageTitle, $iMenuOrder = NULL, $sPageContent = NULL ) {
	// init
	$iPageId    = NULL;
	$sPageSlug  = sanitize_title( $sPageTitle );
	// get page by title / see if it already exists
	$oPageCheck = get_page_by_title( $sPageTitle );

	// early exit - there's already a page with this title
	if( isset($oPageCheck->ID) ) { return $oPageCheck->ID; }

	// early exit - slug exists
	if( od_slug_exists($sPageSlug) ) {
		global $wpdb;
		$oPost = $wpdb->get_row("SELECT post_name FROM od_posts WHERE post_name = '".$sPageSlug."'");
		// we've got ourselves a page
		if( $oPost->post_type == 'page' ) { return $oPost->ID; }
		// not a page, better create one then
		$bCreate = TRUE;
	}

	// insert page if not exists
	if( (!isset($oPageCheck->ID) && !od_slug_exists($sPageSlug)) || isset($bCreate) ) {
		$oPage = array(
			'post_type'    => 'page',
			'post_title'   => $sPageTitle,
			'post_status'  => 'publish',
			'post_author'  => 1,
			'post_slug'    => $sPageSlug,
			'post_name'    => $sPageSlug
		);

		if( $sPageContent != NULL ) {
			$oPage['post_content'] = $sPageContent;
		} else {
			$oPage['post_content'] = sprintf( "This is a placeholder for the %s page. Proin magna. Ut non enim eleifend felis pretium feugiat. Praesent egestas neque eu enim. Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui. Etiam ultricies nisi vel augue.", strtolower($sPageTitle) );
		}

		if( $iMenuOrder != NULL ) { $oPage['menu_order'] = $iMenuOrder; }
		$iPageId = wp_insert_post( $oPage );
	}

	return $iPageId;
}

/**
 * Sets the page color
 * @param   integer   $post_id  The post id
 * @param   string    $color    The color
 */
function od_setup_page_color( $post_id, $color = NULL ) {
	$aBaseColors = array(
		'News'          => 'beige',
		'Events'        => 'blue',
		'European news' => 'turquoise',
		'About'         => 'purple',
		'Contact'       => 'yellow'
	);

	if( $color == NULL ) {
		$oPage = get_post( $post_id );
		if( !isset($oPage->ID) ) { return; }
		$color = $aBaseColors[$oPage->post_title];
	}
	if( !in_array($color, $aBaseColors) ) {
		$color = 'beige';
	}
	if( !add_post_meta( $post_id, 'isoc_pagecolor', $color, TRUE) ) {
		update_post_meta( $post_id, 'isoc_pagecolor', $color );
	}
}

/**
 * Sets up some pages on activation of this theme
 */
function od_setup_main_pages() {
	if( isset($_GET['activated']) && is_admin() ) {
		// list of pages and their menu order
		$aPages  = array(0 => 'News', 10 => 'Events', 20 => 'European news', 30 => 'About', 40 => 'Contact', 90 => 'Not found');

		foreach( $aPages as $iMenuOrder => $sPageTitle ) {
			$iPageId = od_create_page( $sPageTitle, $iMenuOrder );
			od_setup_page_color( $iPageId );
		}
	}
}

/**
 * Sets up the main menu
 */
function od_setup_main_menu() {
	if( isset($_GET['activated']) && is_admin() ) {

		// Check if the menu exists
		$sMainMenuName = 'Main Menu';
		$bMenuExists   = wp_get_nav_menu_object( $sMainMenuName );

		// if it doesn't exist yet, let's create it
		if( !$bMenuExists ) {
			$iMenuId    = wp_create_nav_menu( $sMainMenuName );

			// loop all the pages we'd like to add to this Main Menu
			$aMenuItems = array(0 => 'News', 10 => 'Events', 20 => 'European news', 30 => 'About', 40 => 'Contact');
			foreach( $aMenuItems as $iMenuOrder => $sPageTitle ) {
				$sPageSlug = sanitize_title( $sPageTitle );
				$oPage     = get_page_by_path( $sPageSlug );

				// check if page exists, else create a page
				if( !isset($oPage->ID) ) {
					$iPageId = od_create_page( $sPageTitle, $iMenuOrder );
					od_setup_page_color( $iPageId );
					$oPage   = get_post( $iPageId );
				}

				// skip the first page, this one doesn't need to be in the menu
				if( $iMenuOrder == 0 ) { continue; }
				// create menu items
				wp_update_nav_menu_item( $iMenuId, 0, array(
					'menu-item-title'     => $oPage->post_title,
					'menu-item-object-id' => $oPage->ID,
					'menu-item-object'    => $oPage->post_type,
					'menu-item-type'      => 'post_type',
					'menu-item-classes'   => $sPageSlug,
					'menu-item-url'       => get_permalink( $oPage->ID ),
					'menu-item-status'    => 'publish')
				);
			}

			// set Main Menu as primary
			$aMenuLocations = get_theme_mod('nav_menu_locations');
			$aMenuLocations['primary'] = $iMenuId;
			set_theme_mod( 'nav_menu_locations', $aMenuLocations );
		}
	}
}
