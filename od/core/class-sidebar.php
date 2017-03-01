<?php

/**
 * Extend Custom Post Type models to this class
 */
abstract class Sidebar extends Master {

	/**
	 * Required variables
	 */
	protected $columnAmount;
	protected $className;
	protected $name;
	protected $template; // name of template file
	protected $args;
	
	/**
	 * Required method to register the custom post type
	 */
	public function Register_Sidebar( ) {
		$count = $this->columnAmount;
		if ( function_exists('register_sidebar') ) {
			// +1, counting from 1
			for( $i = 1; $i < ( $count + 1); $i++ ) {
				$args = array(
					'id'            => $this->GetId($i),
					'name'          => __($this->name . ' ' . $i, 'occhio'),
					'description'   => '',
					'class'         => '',       
					'before_widget' => '<li id="%1$s" class="widget %2$s ' . $this->className . '">',
					'after_widget'  => '</li>',
					'before_title'  => '<h3>',
					'after_title'   => '</h3>',
				);
				
				// combine arrays
				if(!is_array($this->args)) $this->args = array();
				$args = array_replace_recursive($args, $this->args);

				register_sidebar($args);
			}
		}
	}
	
	public function GetId($i)
	{
		return sanitize_title($this->name) . '-' . $i;
	}
	
	public static function GetOutput()
	{
		// get sidebar instance
		if(isset($this)) {
			$oSidebar = $this;
		} else {
			$oSidebar = self::GetInstance();			
		}

		// loop columns
		for($i = 1; $i <= $oSidebar->GetColumnAmount(); $i++) {
			Template::Render($oSidebar->template, array('sidebar' => $oSidebar->GetId($i), 'count' => $i));	 
		}
	}
	
	public function GetColumnAmount()
	{
		return $this->columnAmount;
	}
}