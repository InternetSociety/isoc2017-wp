<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */
?>

<?php if( is_active_sidebar('sidebar') ) : ?>
	<aside role="complementary" class="col-md-4 col-md-pull-8">
		<ul class="widgets">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</ul>
	</aside>
<?php endif; ?>
