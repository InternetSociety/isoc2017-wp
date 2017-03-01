<?php
if( function_exists('get_field') ) :
	$sHeaderTitle = get_field('title');
	$bShowButton  = get_field('button');
?>
	<div class="ankeiler">
	<?php if( get_field('title') ) : ?>
		<h2><?php the_field('title'); ?></h2>
	<?php endif; ?>

	<?php if(get_field('button_page')) :  ?>
		<?php if( get_field('button') ) : ?>
			<a class="btn btn-primary btn-lg" href="<?php echo get_field('url'); ?>"><?php the_field('button')?></a>
		<?php endif; ?>
	<?php endif; ?>
	</div>
<?php endif; ?>
