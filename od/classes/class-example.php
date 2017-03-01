<?php

/**
 * Custom Post Type subclass
 */
class Example extends PostType 
{
	/**
	 * Required variables
	 */
	protected $post_type = 'example';
	protected $label_name = 'Examples';
	protected $label_name_singular = 'Example';
	protected $args = array(
		'menu_icon' => 'dashicons-hammer'
	);
}