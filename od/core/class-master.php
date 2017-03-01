<?php
	
/**
 * Extend this class for useful methods
 */
abstract class Master {
	
	private static $aInstances = null;
	
	/**
	 * AutoCall all Register funtions (register post type, etc)
	 */
	public static function Register()
	{
		// use get instance
		self::GetInstance()->AutoCall('Register_');
	}
	
	/**
	 * Automatically calls all methods with a certain prefix
	 *
	 * @param $prefix The prefix of the methods
	 */
	public function AutoCall($prefix)
	{
		// loop all class methods
		foreach(get_class_methods($this) as $method) {
			// test method name for keyword
			if(substr($method, 0, strlen($prefix)) == $prefix) {
				$this->$method();
			}
		}
	}
	
	/**
	 * Get Object Instance
	 */
	public static function GetInstance()
	{
		// init
		$className = get_called_class();
		
		// get instance
		if(is_null(self::$aInstances[$className])) {
			self::$aInstances[$className] = new $className();
		}
		
		// return instance
		return self::$aInstances[$className];
	}
}