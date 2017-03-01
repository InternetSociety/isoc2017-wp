<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */

	if( trim($_SERVER['REQUEST_URI'], '/') == 'stijldocument' || trim($_SERVER['REQUEST_URI'], '/') == 'testdocument' ) {
		header('location: /?control=dev&method=' . trim($_SERVER['REQUEST_URI'], '/'));
		exit;
	}
	get_header();

	$oPost = get_post(od_get_404_page());
	setup_postdata( $oPost );
?>

	<main>
		<div class="container">
			<div class="row">

				<article <?php post_class('col-md-8 col-md-push-4 not-found'); ?> id="post-<?php echo $oPost->ID; ?>">
					<header>
						<h1><?php echo $oPost->post_title; ?></h1>
					</header>
					<div class="entry">
						<?php echo od_add_content_class( $oPost->post_content ); ?>
					</div>
				</article>

				<?php get_sidebar(); ?>
			</div>
		</div>
	</main>
<?php get_footer(); ?>
