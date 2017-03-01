<?php
// hooks based on ACF fields

if( !function_exists('is_plugin_active') ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

function has_acf( $type ) {
	if( !in_array($type, array('pro', 'free')) ) return false;

	if( $type == 'pro' && is_plugin_active('advanced-custom-fields-pro/acf.php') && !is_plugin_active('advanced-custom-fields/acf.php') ) {
		return true;
	};
	if( $type == 'free' && is_plugin_active('advanced-custom-fields/acf.php') && !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
		return true;
	};
	return false;
}

// code for when ACF Pro is installed
if( function_exists('acf_add_local_field_group') && has_acf('pro') ) {

	/* Safe all ACF Pro in project repo
	/* ------------------------------------ */
	add_filter('acf/settings/save_json', function( $path ) {
		return get_stylesheet_directory() . '/od/acf-json';
	});

	/* Load all ACF Pro from project repo
	/* ------------------------------------ */
	add_filter('acf/settings/load_json', function( $paths ) {
		unset($paths[0]); // remove original path (optional)
		$paths[] = get_stylesheet_directory() . '/od/acf-json';
		return $paths;
	});

	/* Exclude current post/page & unpublished ones from relationship field results
	/* ------------------------------------ */
	add_filter('acf/fields/relationship/query', function( $args, $field, $post ) {
		$args['post__not_in'] = array( $post );
		$args['post_status']  = 'publish';
		return $args;
	}, 10, 3);
}

// code for when ACF (Free) is installed
if( function_exists('register_field_group') && has_acf('free') ) {

	define( 'ACF_LITE', true );

	$aAcfCondition = array (
		'status'    => 1,
		'rules'     => array (
			array (
				'field'    => 'field_5880d4437eac9',
				'operator' => '==',
				'value'    => '1',
			),
		),
		'allorany'  => 'all',
	);

	register_field_group( array (
		'id'     => 'acf_header',
		'title'  => 'Header',
		'fields' => array (
			array (
				'key'           => 'field_58808027dd3f8',
				'label'         => __('Header Title (optional)', 'od'),
				'name'          => 'title',
				'type'          => 'text',
				'formatting'    => 'html',
			),
			array (
				'key'           => 'field_5880d4437eac9',
				'label'         => '',
				'name'          => 'button_page',
				'type'          => 'true_false',
				'message'       => __("Check if you'd like to add an action button to the header.", 'od'),
				'default_value' => 0,
			),
			array (
				'key'           => 'field_5880815984530',
				'label'         => __('Button Text', 'od'),
				'name'          => 'button',
				'type'          => 'text',
				'required'      => 1,
				'conditional_logic' => $aAcfCondition,
				'formatting'    => 'html',
			),
			array (
				'key'           => 'field_5880d4857eaca',
				'label'         => __('Button Link', 'od'),
				'name'          => 'url',
				'type'          => 'page_link',
				'required'      => 1,
				'conditional_logic' => $aAcfCondition,
				'post_type'     => array (
					0 => 'post',
					1 => 'page',
					2 => 'event',
				),
				'allow_null'    => 0,
				'multiple'      => 0,
			),
			array (
				'key'           => 'field_58aaad2c67126',
				'label'         => __('Main Content', 'od'),
				'name'          => '',
				'type'          => 'message',
				'message'       => '<strong>'.__('Main Content', 'od').'</strong><style>#acf_acf_header { padding-top: 1em; margin-bottom: 0; } #acf_acf_header .inside div.field { padding: 0.7em 0 0; } #acf_acf_header p.label { margin-bottom: 0.5em; }</style>',
			),
		),
		'location' => array (
			array (
				array (
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'post',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'page',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
			array (
				array (
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'event',
					'order_no' => 0,
					'group_no' => 2,
				),
			),
		),
		'options'            => array (
			'position'       => 'acf_after_title',
			'layout'         => 'no_box',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

