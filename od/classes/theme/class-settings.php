<?php

class Theme_Settings {

	public static function Register() {

		// setup theme settings
		if( function_exists('acf_add_options_page') ) {

			acf_add_options_page(array(
				'page_title' 	=> 'General Settings',
				'menu_title'	=> 'Chapter Settings',
				'menu_slug' 	=> 'theme-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> true,
				'position'      => '59.5',
				'icon_url'      => 'dashicons-schedule',
			));

			acf_add_options_sub_page(array(
				'page_title'  => 'General Settings ISOC Chapter',
				'menu_title'  => 'Chapter Settings',
				'slug'        => 'isoc-theme-settings',
				'parent_slug' => 'theme-general-settings',
			));
		}
	}
}
