<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */

get_header();
global $wp_query;
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main class="articles archive" role="main">
	<div class="container">
		<div class="row">
		<?php if( have_posts() ) : ?>
		<section class="items col-md-8 col-md-push-4">
			<header>
				<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
				<?php /* If this is a category archive */ if (is_category()) { ?>
				<h2 class="pagetitle">Archive for the &#8216;<?php single_cat_title(); ?>&#8217; Category</h2>
				<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
				<h2 class="pagetitle">Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h2>
				<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('F jS, Y'); ?></h2>
				<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('F, Y'); ?></h2>
				<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
				<h2 class="pagetitle">Archive for <?php the_time('Y'); ?></h2>
				<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
				<h2 class="pagetitle">Blog Archives</h2>
				<?php } ?>
			</header>

		<?php while( have_posts() ) : the_post(); ?>
			<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
				<h2><?php the_title(); ?></h2>

				<?php if( has_post_thumbnail() ) { the_post_thumbnail('square'); } ?>

				<div class="entry">
					<?php the_excerpt(); ?>
					<a href="<?php echo get_permalink(); ?>"><?php _e('Lees meer', 'od'); ?></a>
				</div>
			</article>
		<?php endwhile; ?>

			<nav class="navigation col-sm-12" role="navigation">
				<div class="alignleft"><?php previous_posts_link( '&laquo; '.OLDERENTRIESTEXT, $wp_query->max_num_pages ); ?></div>
				<div class="alignright"><?php next_posts_link( NEWERENTRIESTEXT.' &raquo;', $wp_query->max_num_pages ) ?></div>
			</nav>

		</section>
	<?php else :

		if ( is_category() ) { // If this is a category archive
			printf("<h2 class='center'>Sorry, but there aren't any posts in the %s category yet.</h2>", single_cat_title('',false));
		} else if ( is_date() ) { // If this is a date archive
			echo("<h2>Sorry, but there aren't any posts with this date.</h2>");
		} else if ( is_author() ) { // If this is a category archive
			$userdata = get_userdatabylogin(get_query_var('author_name'));
			printf("<h2 class='center'>Sorry, but there aren't any posts by %s yet.</h2>", $userdata->display_name);
		} else {
			echo("<h2 class='center'>No posts found.</h2>");
		}
		get_search_form();

	endif;
?>
			<?php get_sidebar(); ?>
		</div>
	</div>
</main>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
