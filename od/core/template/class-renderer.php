<?php
/* 
 * Smk Theme View
 *
 * Do not replace your theme functions.php file! Copy the code from this file in your 
 * theme functions.php on top of other files that are included.
 *
 * -------------------------------------------------------------------------------------
 * @Author: Smartik
 * @Author URI: http://smartik.ws/
 * @Copyright: (c) 2014 Smartik. All rights reserved
 * -------------------------------------------------------------------------------------
 *
 * @Date:   2014-06-20 03:40:47
 * @Last Modified by:   Smartik
 * @Last Modified time: 2014-06-23 22:46:40
 *
 */

################################################################################

/**
 * Template Renderer (based on Theme View)
 *
 * Include a file and(optionally) pass arguments to it.
 *
 * @param string $file The file path, relative to theme root
 * @param array $args The arguments to pass to this file. Optional.
 * Default empty array.
 *
 * @return object Use render() method to display the content.
 */

class Template_Renderer{
	private $args;
	private $file;

	public function __get($name) {
		return $this->args[$name];
	}

	public function __construct($file, $args = array()) {
		$this->file = $file;
		$this->args = $args;
	}

	public function __isset($name){
		return isset( $this->args[$name] );
	}

	public function Render() {
		if( locate_template($this->file) ){
			include( locate_template($this->file) );//Theme Check free. Child themes support.
		}
	}
}


################################################################################