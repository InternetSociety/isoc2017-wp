<?php

class Footer {

	public function Register( $count = 3 ) {

		if ( function_exists('register_sidebar') ) {
			// +1, counting from 1
//			$count++;
			for( $i = 1; $i < ( $count + 1); $i++ ) {

				register_sidebar(array(
					'id'            => 'footer-' . $i,
					'name'          => __('Footer ' . $i, 'occhio'),
					'description'   => '',
					'class'         => '',
					'before_widget' => '<li id="%1$s" class="widget %2$s">',
					'after_widget'  => '</li>',
					'before_title'  => '<h3>',
					'after_title'   => '</h3>',
				));
			}
			define('FOOTER_WIDGET_COLUMS', $count);
		}
	}
}
