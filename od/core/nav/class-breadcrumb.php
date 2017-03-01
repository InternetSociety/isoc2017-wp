<?php

class Nav_Breadcrumb {

	public function show() {
		global $post;

		echo '<ol class="breadcrumb">';
		if( !is_front_page() ) {
			echo '<li><a class="home" href="';
			echo get_option('home');
			echo '">' . __('Home', 'od') . '</a></li>';

			if( is_404() ) {
				echo '<li>' . __('404', 'od') . '</li>';

			} elseif( is_search() ) {
				echo '<li>' . __('Searchresults', 'od') . '</li>';

			} elseif( is_single() ) {
				$post_type = get_post_type_object( get_post_type() );

				echo '<li><a href="' . get_post_type_archive_link( $post_type->name ) . '">';
				echo $post_type->labels->name;
				echo '</a></li>';

				if( is_category() ) {
					echo '<li>';
					the_category(', ');
					echo '</li>';
				}

				echo '<li>';
				the_title();
				echo '</li>';

			} elseif( is_page() && $post->post_parent ) {
				$home = get_page(get_option('page_on_front'));

				for( $i = count($post->ancestors)-1; $i >= 0; $i-- ) {
					if( ($home->ID) != ($post->ancestors[$i]) ) {
						echo '<li><a href="';
						echo get_permalink($post->ancestors[$i]);
						echo '">';
						echo get_the_title($post->ancestors[$i]);
						echo '</a></li>';
					}
				}
				echo '<li>';
				the_title();
				echo '</li>';

			} elseif( is_page() ) {
				echo '<li>';
				the_title();
				echo '</li>';

			} elseif( is_archive() || !is_single() ) {
				$post_type = get_post_type_object( get_post_type() );
				
				echo '<li>';
				echo $post_type->labels->name;
				echo '</li>';

			}

		} else {
			echo '<li>' . get_bloginfo('name') . '</li>';
		}
		echo '</ol>';
	}
}