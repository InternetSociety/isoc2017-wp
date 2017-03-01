<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */

get_header();

get_template_part( 'content', (get_post_format()) ? get_post_format() : get_post_type()  );

// get_sidebar();

get_footer();