<?php

/**
 * Extendable Taxonomy class
 */
class Taxonomy extends Master {

	/**
	 * Required variables
	 */
	protected $taxonomy;
	protected $label_name = 'Categorie&euml;n';
	protected $label_name_singular = 'Categorie';
	protected $aPostTypes = array();
	protected $args = array();
	
	/**
	 * Class constructor
	 */
	public function __construct($idOrTerm = null)
	{
		// term object
		if(is_object($idOrTerm)) {
			$this->term = $idOrTerm;
			$this->id = $this->term->term_id;
		}
		// id
		else if(is_numeric($idOrTerm)) {
			$this->id = $idOrTerm;
			$this->term = get_term($this->id);
		}
	}

	/**
	 * Get a variable from the term object
	 */
	public function Get($value) {
		return $this->term->$value;
	}

	/**
	 * Required method to register the custom post type
	 */
	protected function Register_Taxonomy()
	{
		
		// set labels
		$label_name          =	$this->label_name;
		$label_name_singular =  $this->label_name_singular;
		$taxonomy           = 	$this->taxonomy;

		// default
		$label_name_lc          = mb_strtolower( $label_name );
		$label_name_singular_lc = mb_strtolower( $label_name_singular );
		
		$args = array(
			'labels'                     => array(
				'name'                       => _x( $label_name, 'Taxonomy General Name', 'od' ),
				'singular_name'              => _x( $label_name_singular, 'Taxonomy Singular Name', 'od' ),
				'menu_name'                  => __( $label_name, 'od' ),
				'all_items'                  => __( 'Alle ' . $label_name_lc, 'od' ),
				'parent_item'                => __( 'Bovenliggende ' . $label_name_singular_lc, 'od' ),
				'parent_item_colon'          => __( 'Bovenliggende ' . $label_name_singular_lc, 'od' ),
				'new_item_name'              => __( 'Nieuwe ' . $label_name_singular_lc, 'od' ),
				'add_new_item'               => __( 'Nieuwe ' . $label_name_singular_lc, 'od' ),
				'edit_item'                  => __( 'Bewerk ' . $label_name_singular_lc, 'od' ),
				'update_item'                => __( 'Update ' . $label_name_singular_lc, 'od' ),
				'separate_items_with_commas' => __( 'Scheid items met een komma', 'od' ),
				'search_items'               => __( 'Zoek ' . $label_name_lc, 'od' ),
				'add_or_remove_items'        => __( 'Voeg items toe of verwijder ze', 'od' ),
				'choose_from_most_used'      => __( 'Kies uit de meest gebruikte items', 'od' ),
				'not_found'                  => __( 'Niet gevonden', 'od' ),
			),
			'hierarchical'               => true,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
			'rewrite'                    => array(
				'slug'                       => $taxonomy,
				'with_front'                 => true,
				'hierarchical'               => true,
			),
		);

		// combine arrays
		if(!is_array($this->args)) $this->args = array();
		$args = array_replace_recursive($args, $this->args);
		
		// register already!
		register_taxonomy( $taxonomy, $this->aPostTypes, $args );
	}
}