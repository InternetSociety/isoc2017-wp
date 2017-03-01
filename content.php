<main>
	<div class="container">
		<div class="row">
			<?php if( have_posts() ) :
				while( have_posts() ) :
					the_post(); ?>

				<article <?php post_class('col-md-8 col-md-push-4'); ?> id="post-<?php the_ID(); ?>">
					<header>
						<h1><?php the_title(); ?></h1>
					</header>

					<div class="entry">
						<?php the_content(); ?>
					</div>

					<?php edit_post_link( __('Edit', 'od'), '', ' | '); ?>

					<?php if( comments_open() ) { comments_template(); } ?>

				</article>

			<?php endwhile; ?>

			<?php get_template_part( 'snippet', 'prev-next' ); ?>

			<?php else : get_template_part( 'snippet', 'not-found' ); endif; ?>

			<?php get_sidebar(); ?>
		</div>
	</div>
</main>
