<?php

class Framework {

	/*
		Setup Occhio Framework
	*/
	public static function Register() {

		// default functions
		self::Helpers();

		// add acf social media links to theme
		// Framework_SocialMedia::Register();
		// Framework_ThemeSettings::Register();

	}

	public static function Helpers() {

		/*
			Default functions
		*/
		// extended print function
		if( !function_exists('p') ) {
			function p( $value = array() ) {
				$backtrace = debug_backtrace();
				unset( $backtrace[0]['args'] );

				echo '<div style="padding: 20px;"><pre>';
				print_r($value);
				echo '<br><div class="alert alert-warning" role="alert">';
				foreach( $backtrace[0] as $key => $backtrace_value ) {
					echo $key . ': ' . $backtrace_value . '<br>';
				}
				echo '</div>';
				echo '</pre></div>';
			}
		}

		// extended var_dump function
		if( !function_exists('vd') ) {
			function vd( $value ) {
				echo '<pre>';
				var_dump($value);
				echo '</pre>';
			}
		}

		// extended echo function
		if( !function_exists('e') ) {
			function e( $value, $text = null, $element = 'hr' ) {
			    $element = strtolower($element);
			    echo "<{$element}>\n";
			    if ( $text ) {
					echo $text . ': ';
			    }
			    echo $value;
			    if ( $element == 'hr' || $element == 'br' ) {
					echo "\n<{$element}>\n";
			    } else {
					echo "\n</{$element}>";
			    }
			}
		}

		// check if $needle is in string
		if ( !function_exists('in_string') ) {
			function in_string( $needle, $str ) {
				return strpos( $str, $needle ) !== false;
			}
		}

		/**
		* Get a value from $_POST / $_GET
		* if unavailable, take a default value
		*
		* @param string $key Value key
		* @param mixed $default_value (optional)
		* @return mixed Value
		*/
		if ( !function_exists('getValue') ) {
			function getValue($key, $default_value = false) {
				if (!isset($key) || empty($key) || !is_string($key))
					return false;

				$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $default_value));

				if (is_string($ret))
					return stripslashes(urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret))));

				return $ret;
			}
		}


		if ( !function_exists('getLastCssModified') ) {
			function getLastCssModified() {
				$path = get_stylesheet_directory() . '/dist/css/app.css';
				if( file_exists($path) ) {
					$time = filemtime($path);
					return $time;
				} else {
					echo <<<EOHTML
<style>
body:before {
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	padding: 10px;
	color: #fff;
	font-family: arial, verdana;
	content: 'Er bestaat geen app.css. Compileer Sass om een mooie layout te krijgen.';
	text-align: center;
	background: red;
}
</style>
EOHTML;
				}
			}
		}

		if ( !function_exists('getLastJsModified') ) {
			function getLastJsModified() {
				$path = get_stylesheet_directory() . '/dist/js/app.js';
				if( file_exists($path) ) {
					$time = filemtime($path);
					return $time;
				}
			}
		}
	}
}