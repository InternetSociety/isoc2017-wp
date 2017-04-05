<?php get_header();

$aArgs  = array( 'post_per_page' => 8, );
$aPosts = get_posts( $aArgs );

?>

<main>
	<div class="container">
		<div class="row">
			<section class="items col-md-8 col-md-push-4">
				<header>
					<h1><?php the_title(); ?></h1>
				</header>

			<?php
				foreach( $aPosts as $oPost ) :
					setup_postdata( $oPost );
			?>

				<article id="post-<?php echo $oPost->ID; ?>">

					<h2><?php echo get_the_title( $oPost->ID ); ?></h2>

					<?php
						if ( has_post_thumbnail($oPost->ID) ) {
							echo get_the_post_thumbnail($oPost->ID, 'square');
						}
					?>

					<div class="entry">
						<?php the_excerpt(); ?>
						<a href="<?php echo get_permalink( $oPost->ID ); ?>"><?php _e('Lees meer', 'od'); ?></a>
					</div>
				</article>

				<?php endforeach; ?>
				<?php
					$postId = wp_get_post_categories($aPosts[0]->ID);
					$postCategory = get_category($postId[0])->slug;
				?>
				<div class="see-all">
					<a class="btn btn-primary btn-lg" href="<?php echo '/' . $postCategory ?>"><?php _e('Lees all ons nieuws', 'od') ?></a>
				</div>
			</section>

		<?php if( is_active_sidebar('sidebar_home') ) : ?>
			<aside role="complementary" class="col-md-4 col-md-pull-8">
				<ul class="widgets">
					<?php dynamic_sidebar( 'sidebar_home' ); ?>
				</ul>
			</aside>
		<?php endif; ?>

		</div>
	</div>
</main>

<?php get_footer(); ?>
