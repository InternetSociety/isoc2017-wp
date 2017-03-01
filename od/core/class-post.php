<?php

/**
 * A post model
 */
class Post extends Master {
	
	// init
	protected $post = null;
	protected $id = 0;
	protected $aFieldKeys;
	protected $aMeta = null;
	
	/**
	 * Class constructor
	 */
	public function __construct($idOrPost = null)
	{
		// load object by given id or post object
		if(!is_null($idOrPost)) {
			$this->Load($idOrPost);
		}
		// load object by the loop
		else {
			global $post;
			$this->Load($post);
		}
	}
	
	/**
	 * Load by id or post object
	 */
	public function Load($idOrPost)
	{
		// post object
		if(is_object($idOrPost)) {
			$this->post = $idOrPost;
			$this->id = $this->post->ID;
		}
		// id
		else if(is_numeric($idOrPost)) {
			$this->id = $idOrPost;
			$this->post = get_post($this->id);
		}
	}
	
	/**
	 * Save a variable to db
	 *
	 * @param $key the key of the var (duh)
	 * @param $value the new value
	 * @param $id if you don't want to save it to this object's instance, but to another post object
	 *
	 * @todo also Set native post vars, like post_title, post_content, etc
	 */
	public function Set($key, $value, $id = null)
	{
		// init
		if(is_null($id)) $id = $this->id;
		
		// set with acf
		if(isset($this->aFieldKeys[$key])) {
			update_field($this->aFieldKeys[$key], $value, $id);
		}
		// no known acf field key? use post meta
		else if (!update_post_meta ($id, $key, $value)) {
			add_post_meta($id, $key, $value, true);	
		}
		
		// set internal meta key
		$this->aMeta[$key] = array($value);
	}

	/**
	 * Get an object variable
	 *
	 * @param $key the key of the var (duh)
	 */
	public function Get( $key )
	{
		// load meta data
		$this->GetAll();

		// check if field is in meta data
		$metaValue = $this->aMeta[$key][0];
		
		// not in meta data? try post main data
		if(is_null($metaValue)) {
			$metaValue = $this->post->$key;
		}
	
		// try to unserialize
		if( ($metaValue == serialize(false) || @unserialize($metaValue) !== false)) {
			$metaValue = unserialize($metaValue);
		}
		
		// return meta value
		return $metaValue;
	}

	/**
	 * Get all variables of this object
	 */
	public function GetAll()
	{
		// only load if it isn't loaded yet
		if(is_null($this->aMeta)) {
			$this->aMeta = get_post_meta( $this->id );			
		}

		return $this->aMeta;
	}

	/**
	 * Get permalink
	 */
	public function GetPermalink() {
		return get_permalink($this->id);
	}
}