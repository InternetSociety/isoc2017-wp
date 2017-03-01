<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>" />
		<title><?php wp_title('&laquo;', true, 'right'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?php get_template_part('head', 'icons'); ?>

		<!-- Chrome, Firefox OS and Opera -->
		<meta name="theme-color" content="#40B2A4">
		<!-- Windows Phone -->
		<meta name="msapplication-navbutton-color" content="#40B2A4">
		<!-- iOS Safari -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="default">

		<!-- styles and scripts enqueued in functions.php -->
		<?php wp_head(); ?>

		<!--
			This website/webapplication is developed by:
			Occhio
			http://www.occhio.nl/
			info@occhio.nl
			+31 (0)20 320 78 70
		-->
	</head>
	<body <?php body_class( od_get_page_color(get_the_ID()) ); ?>>
		<?php Template::Render('site-header'); ?>
