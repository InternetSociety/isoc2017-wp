<?php
/**
 * @package WordPress
 * @subpackage ISOC theme created by Occhio Web Development
 */
?>

	<?php Template::Render('site-footer'); ?>
	<?php wp_footer(); ?>

	<?php if(OD_ENV == 'local') : ?>
		<!-- browser sync -->
		<script id="__bs_script__">//<![CDATA[
	document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.2.12.10.js'><\/script>".replace("HOST", location.hostname));
//]]>	</script>
	<?php endif; ?>
	</body>
</html>
