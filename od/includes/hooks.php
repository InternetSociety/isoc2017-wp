<?php
// hooks

/* Customize the search form
/* ------------------------------------ */
add_filter( 'get_search_form', function( $form ) {
	$sSearchHolder = __('What are you looking for?', 'od');
	return <<<EOHTML
		<form method="get" class="searchform" action="/">
			<div class="input-group">
				<input name="s" type="search" class="form-control" placeholder="{$sSearchHolder}">
				<span class="input-group-btn">
					<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-search"></span></button>
				</span>
			</div>
		</form>
EOHTML;
});

/*  Add responsive container to embeds
/* ------------------------------------ */
function od_embed_html( $html, $url, $attr ) {

	// ugly version load oembed class
	require_once('wp-includes/class-oembed.php');

	// slow process to check data type
	$oEmbed   = new WP_oEmbed();
	$provider = $oEmbed->get_provider( $url, $args );
	$data     = $oEmbed->fetch( $provider, $url, $args );

	// if type is video
	if( $data->type == 'video' ) {

		// check if class already exists
		if( strpos($html, 'class="') ) {
			// add class
			$html = str_replace( 'class="', 'class="embed-responsive-item ', $html );
		} else {
			// dirty string replace to add class
			$html = str_replace( '<iframe', '<iframe class="embed-responsive-item"', $html );
		}

		return <<<EOHTML
	<div class="embed-responsive embed-responsive-16by9">
		{$html}
	</div>

EOHTML;
	}

	return $html;

}

add_filter( 'embed_oembed_html', 'od_embed_html', 10, 3 );
add_filter( 'video_embed_html', 'od_embed_html', 10, 3 );

/* Move Yoast to bottom
/* ------------------------------------ */
add_filter( 'wpseo_metabox_prio', function() {
	return 'low';
});

/*  Modify TinyMCE
/* ------------------------------------ */
add_filter( 'tiny_mce_before_init', function( $toolbars ) {

	# customize the buttons
	$toolbars['toolbar1'] = 'bold,italic,underline,bullist,numlist,hr,blockquote,link,unlink,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent';
	$toolbars['toolbar2'] = 'formatselect,pastetext,pasteword,charmap,undo,redo,styleselect';

	# Keep the "kitchen sink" open:
	$toolbars[ 'wordpress_adv_hidden' ] = FALSE;

	return $toolbars;
});

/* Add in a core button that's disabled by default
/* ------------------------------------ */
add_filter( 'mce_buttons_2', function( $buttons ) {
	// Add in a core button that's disabled by default
	$buttons[] = 'styleselect';
	return $buttons;
});

/* Callback function to filter the MCE settings
/* ------------------------------------ */
add_filter( 'tiny_mce_before_init', function( $toolbars ) {

	// Define the style_formats array
	$style_formats = array(
		// Each array child is a format with it's own settings
		array(
			'title' => 'Action button',
			'block' => 'span',
			'classes' => 'btn btn-primary btn-lg',
			'wrapper' => false,
		)
	);
	// Insert the array, JSON ENCODED, into 'style_formats'
	$toolbars['style_formats'] = json_encode( $style_formats );
	return $toolbars;
});

/* replaces [...] with ... in excerpt
/* ------------------------------------ */
add_filter( 'excerpt_more', function( $more ) {
	return '...';
});

/*
	Gravity Forms Bootstrap Styles

	Applies bootstrap classes to various common field types.
	* Requires Bootstrap to be in use by the theme.

	Using this function allows use of Gravity Forms default CSS
	* in conjuction with Bootstrap (benefit for fields types such as Address).

	@see  gform_field_content
	* @link http://www.gravityhelp.com/documentation/page/Gform_field_content

	@return string Modified field content
*/
add_filter( 'gform_field_content', function( $content, $field, $value, $lead_id, $form_id ) {

	// Currently only applies to most common field types, but could be expanded.
	if($field["type"] != 'hidden' && $field["type"] != 'list' && $field["type"] != 'multiselect' && $field["type"] != 'checkbox' && $field["type"] != 'fileupload' && $field["type"] != 'date' && $field["type"] != 'html' && $field["type"] != 'address') {
		$content = str_replace('class=\'medium', 'class=\'form-control medium', $content);
	}
	if($field["type"] == 'name' || $field["type"] == 'address') {
		$content = str_replace('<input ', '<input class=\'form-control\' ', $content);
	}
	if($field["type"] == 'textarea') {
		$content = str_replace('class=\'textarea', 'class=\'form-control textarea', $content);
	}
	if($field["type"] == 'checkbox') {
		$content = str_replace('li class=\'', 'li class=\'checkbox ', $content);
		$content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	}
	if($field["type"] == 'radio') {
		$content = str_replace('li class=\'', 'li class=\'radio ', $content);
		$content = str_replace('<input ', '<input style=\'margin-left:1px;\' ', $content);
	}
	if($field["type"] == 'date') {
		$content = str_replace('select', 'select class="form-control" ', $content);
	}
	return $content;
}, 10, 5);

add_filter( 'gform_submit_button', function( $button, $form ) {
	return "<button class='button btn btn-default' id='gform_submit_button_{$form["id"]}'><span>{$form['button']['text']}</span></button>";
}, 10, 2);

/* Add css class to form
/* ------------------------------------ */
add_filter( 'gform_form_tag', function( $form_tag, $form ) {
	$cssClass = 'class="gform_form gform_form_' . $form['fields'][0]['formId'] . '"';
	$form_tag = str_replace('id=', $cssClass . ' id=', $form_tag );
	return $form_tag;
}, 10, 2 );

/* Nice logo for admin login
/* ------------------------------------ */
add_filter( 'login_headerurl', function() { ?>
 	<style>
	body.login {
		background-color: #40b2a4;
	}
 	#login h1 a {
 		background: none;
 	}
 	#login form {
 		background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/src/img/logo-isoc.gif');
 		background-repeat: no-repeat;
 		background-size: 85%;
 		background-position: center 30px;
 		padding-top: 160px;
 	}
 	</style>
<?php
});

/* Change the admin footer 
/* ------------------------------------ */
add_filter( 'admin_footer_text', function() {
	echo '<span id="footer-thankyou">'.__('The template of this website is made available', 'od').' <a href="https://github.com/InternetSocietyChapters/isoc2017-wp" target="_blank">open source</a>.</span>';
});

/* Extra filter for the_title breakingpoints
/* ------------------------------------ */
add_filter( 'the_title', function( $title ) {
	return str_replace('||', '&shy;', $title);
});

/* Rename WP standard 'Berichten' to 'news'
/* ------------------------------------ */
add_action( 'admin_menu', function() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'News';
	$submenu['edit.php'][5][0] 	= __('News', 'od');
	$submenu['edit.php'][10][0] = __('Add news', 'od');
	$submenu['edit.php'][16][0] = __('News Tags', 'od');
});
add_action( 'init', function() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name 			= __('News', 'od');
	$labels->singular_name 	= __('News', 'od');
	$labels->all_items 		= __('All news', 'od');
	$labels->add_new 		= __('Add news', 'od');
	$labels->add_new_item 	= __('Add news', 'od');
	$labels->edit_item 		= __('Edit news', 'od');
	$labels->new_item 		= __('News', 'od');
	$labels->view_item 		= __('View news', 'od');
	$labels->search_items 	= __('Zoek news', 'od');
	$labels->not_found 		= __('No news found', 'od');
	$labels->not_found_in_trash = __('No news found in the trash', 'od');
	$labels->all_items 		= __('All news', 'od');
	$labels->menu_name 		= __('News', 'od');
	$labels->name_admin_bar = __('News', 'od');
});

/* Hide certain admin sections for "simple users"
/* ------------------------------------ */
add_action('wp_dashboard_setup', function() {
	if( current_user_can('editor') ) {
		remove_meta_box('dashboard_quick_press', 'dashboard', 'side'); 			// Quick Press widget
		remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side'); 		// Recent Drafts
		remove_meta_box('dashboard_primary', 'dashboard', 'side'); 				// WordPress.com Blog
		// remove_meta_box('dashboard_secondary', 'dashboard', 'side'); 		// Other WordPress News
		// remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal'); 	// Incoming Links
		// remove_meta_box('dashboard_plugins', 'dashboard', 'normal'); 		// Plugins
		// remove_meta_box('dashboard_right_now', 'dashboard', 'normal'); 		// Right Now
		// remove_meta_box('rg_forms_dashboard', 'dashboard', 'normal'); 		// Gravity Forms
		remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); 	// Recent Comments
		// remove_meta_box('icl_dashboard_widget', 'dashboard', 'normal'); 		// Multi Language Plugin
		remove_meta_box('dashboard_activity', 'dashboard', 'normal'); 			// Activity
		remove_action('welcome_panel', 'wp_welcome_panel');
	}
});

/* Convert absolute URLs in content to site relative ones
/* Inspired by http://thisismyurl.com/6166/replace-wordpress-static-urls-dynamic-urls/
/* ------------------------------------ */
add_filter( 'content_save_pre', function( $content ) {

	$sSiteURL = get_bloginfo('url');
	$sNewContent = str_replace(' src=\"'.$sSiteURL, ' src=\"', $content );
	$sFilteredContent = str_replace(' href=\"'.$sSiteURL, ' href=\"', $sNewContent );

	return $sFilteredContent;
},'99');

/* Diabled WordPress calling for s.w.org since we don't want visitors to be traced by external websites
/* ------------------------------------ */
add_filter( 'emoji_svg_url', '__return_false' );

add_action( 'init', function() {

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', function( $plugins ) {
		if( is_array($plugins) ) { return array_diff( $plugins, array('wpemoji') ); }
		else { return array(); }
	});
});
