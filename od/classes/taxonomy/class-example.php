<?php
/**
 * Example class
 */
class Taxonomy_Example extends Taxonomy {
	/**
	 * Required variables
	 */
	protected $taxonomy = 'taxonomy-example';
	protected $label_name = 'Examples';
	protected $label_name_singular = 'Example';
	protected $aPostTypes = array('post', 'page');
	protected $args = array();
}
