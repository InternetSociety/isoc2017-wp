<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */

get_header();

global $wp_query;
$total_results = $wp_query->found_posts;
$search	= strtolower(get_search_query());

?>

<main>
	<div class="container">
		<div class="row">

			<article class="col-md-8 col-md-push-4">
			<?php if( have_posts() ) : ?>

				<h2 class="pagetitle"><?php echo $total_results.__(' Search Results for ', 'od')."'".$search."'"; ?></h2>

				<?php while( have_posts() ) :
					the_post(); ?>

				<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
					<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
					<div class="entry">
						<?php the_excerpt(); ?>
					</div>
				</div>

				<?php endwhile; ?>

				<div class="row">
					<nav class="navigation col-sm-12" role="navigation">
						<div class="alignleft"><?php previous_posts_link( '&laquo; '.__('Back', 'od') ) ?></div>
						<div class="alignright"><?php next_posts_link( __('More results', 'od').' &raquo;' ) ?></div>
					</nav>
				</div>

			<?php else : ?>

				<h2 class="center"><?php _e('No posts found. Try a different search?', 'od'); ?></h2>
				<div class="entry">
					<?php get_search_form(); ?>
				</div>

			<?php endif; ?>
			</article>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>

<?php get_footer(); ?>
