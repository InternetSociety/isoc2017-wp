<?php

/**
 * Class for templates
 */
class Template {

	/**
	 * Include and render a (sub)template
	 */
    public static function Render($file, $args = array()){
	    // add .php if omitted
	    if(strpos($file, '.php') === false) $file .= '.php';
	    
	    // use template renderer
        $oRenderer = new Template_Renderer($file, $args);
        $oRenderer->Render();
    }
}