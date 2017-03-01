<?php
/**
 * @package WordPress
 * @subpackage codart theme created by Occhio Web Development
 */
get_header();

	$errorCount = 0;

// =================================================================================
// 	GOOGLE ANALYTICS CODE
// =================================================================================

	$yst_ga = get_option('yst_ga');
	if( empty( $yst_ga['ga_general']['manual_ua_code_field'] )) {
		$errorCount++;
		$gaContentCssClass = 'warning';
	    $gaErrorText = '<span class="badge">1</span>';
	    $gaContent = <<<EOHTML
<br/><div class="alert alert-danger">
De Google Analytics code is leeg, installeer de Yoast Google Analytics plugin en voer de code in.
</div>

EOHTML;
	} else {
		$gaContentCssClass = 'primary';
	    $gaContent = <<<EOHTML
<br/><div class="alert alert-success">
De Google Analytics code is <strong>{$yst_ga['ga_general']['manual_ua_code_field']}</strong>
</div>

EOHTML;

}

// =================================================================================
// 	INSTALLED PLUGINS
// =================================================================================

	if( !function_exists('occhio_register_required_plugins') ) {

		$pluginContentCssClass = 'warning';
		$pluginContent = <<<EOHTML

		<div class="alert alert-danger" role="alert">
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
Installeer Occhio Jetpack voordat je uberhaupt verder gaat. <a style="float:right;" href="/wp-admin/plugins.php">installeer of activeer deze plugin</a>
		</div>

EOHTML;

	} else {

		$aRequiredPlugins = occhio_register_required_plugins();
		$aActivePlugins   = get_option( 'active_plugins' );
		$aPlugins         = array();
		$pluginContentCssClass = 'primary';
		$pluginErrors = 0;
		foreach( (array) $aActivePlugins as $plugin ) {
			$aNames = explode('/', $plugin);
			$aPlugins[] = $aNames[0];
		}
		foreach( $aRequiredPlugins as $aPlugin ) {

			$cssClass    = '';
			$icon        = '';
			$installText = '<a class="badge" target="_blank" style="float:right;" href="/wp-admin/themes.php?page=tgmpa-install-plugins">installeer of activeer deze plugin</a>';
			if( $aPlugin['required'] ) {
				if( in_array($aPlugin['slug'], $aPlugins) ) {
					$cssClass = 'success';
					$icon     = '<span class="glyphicon glyphicon-ok"></span>';
					$installText = '';
				} else {
					$errorCount++;
					$pluginErrors++;
					$pluginContentCssClass = 'warning';
					$cssClass    = 'danger';
					$icon        = '<span class="glyphicon glyphicon-remove"></span>';
				}
			}

			$pluginContent .= <<<EOHTML
				<div class="alert alert-{$cssClass}" role="alert">
						{$icon}
						{$aPlugin['name']}
						{$installText}
				</div>
EOHTML;
		}

		if( $pluginErrors ) {
			$pluginErrorsText = '<span class="badge">' . $pluginErrors . '</span>';
		}
	}

// =================================================================================
// 	SITE URL
// =================================================================================

	$siteContentCssClass = 'primary';
	$siteErrors = 0;
	if( defined('WP_HOME') ) {
		$siteUrl = WP_HOME;
		$urlDefined = 'in wp-config.php';
	} else {
		$siteUrl = get_option('home');
		$urlDefined = 'in database';
	}

	$aUrl = parse_url( $siteUrl );
	if( $aUrl['host'] != $_SERVER['HTTP_HOST'] ) {
		$errorCount++;
		$siteErrors++;
		$urlErrorText = '<span class="badge">' . $siteErrors . '</span>';
		$siteContentCssClass = 'warning';
		$siteUrl = '<span class="label label-danger">' . $siteUrl . '</span>';
	}

// =================================================================================
// 	SITE PERMALINKS
// =================================================================================

	if( get_option('permalink_structure') ) {
		$permaIcon     = get_option('permalink_structure') . ' <span class="glyphicon glyphicon-ok"></span>';		
	} else {
		$siteContentCssClass = 'warning';
		$siteErrors++;
		$errorCount++;		
		$urlErrorText = '<span class="badge">' . $siteErrors . '</span>';		
		$permaIcon     = <<<EOHTML
<span class="glyphicon glyphicon-remove"></span> <a href="/wp-admin/options-permalink.php">Stel deze in</a> (/%category%/%postname%/)

EOHTML;

	}


?>
<meta name="robots" content="noindex,nofollow">


<p>
	<a href="/?control=dev&method=stijldocument" class="btn btn-primary">bekijk het stijldocument</a>
	<a href="/?control=dev&method=testdocument" class="btn btn-default">bekijk het testdocument</a>
</p>
<br/>
<div class="panel panel-<?php echo $siteContentCssClass; ?>">
	<div class="panel-heading">
		<h3 class="panel-title">Website <?php echo $urlErrorText; ?></h3>
	</div>
	<div class="panel-body">
		<table class="table table-condensed">
			<tbody>
				<tr>
					<th>Naam</th>
					<td>
						<?php bloginfo('name'); ?>
					</td>
				</tr>
				<tr>
					<th>Omschrijving</th>
					<td>
						<?php bloginfo('description'); ?>
					</td>
				</tr>
				<tr>
					<th>URL <?php echo $urlDefined; ?></th>
					<td>
						<?php echo $siteUrl; ?>
					</td>
				</tr>
				<tr>
					<th>Permalinks</th>
					<td>
						<?php echo $permaIcon; ?>
					</td>
				</tr>
			</tbody>
		</table>	
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Thema</h3>
	</div>
	<div class="panel-body">
		<?php
			$aTheme = wp_get_theme();
		?>
		<table class="table table-condensed">
			<tbody>
				<tr>
					<th>Naam</th>
					<td>
						<?php echo $aTheme->Get('Name'); ?>
					</td>
				</tr>
				<tr>
					<th>Omschrijving</th>
					<td>
						<?php echo $aTheme->Get('Description'); ?>
					</td>
				</tr>
				<tr>
					<th>Versie</th>
					<td>
						<?php echo $aTheme->Get('Version'); ?>
					</td>
				</tr>
				<tr>
					<th>Maker</th>
					<td>
						<?php echo $aTheme->Get('Author'); ?>
					</td>
				</tr>
				<tr>
					<th>Website van maker</th>
					<td>
						<?php echo $aTheme->Get('AuthorURI'); ?>
					</td>
				</tr>
				<tr>
					<th>Screenshot</th>
					<td>
						<img width="440" class="thumbnail" src="<?php echo get_stylesheet_directory_uri(); ?>/screenshot.png" alt="Thema screenshot">
					</td>
				</tr>
			</tbody>
		</table>	
	</div>
</div>


<div class="panel panel-<?php echo $gaContentCssClass; ?>">
	<div class="panel-heading">
		<h3 class="panel-title">Google Analytics code <?php echo $gaErrorText; ?></h3>
	</div>
	<div class="panel-body">
		<?php echo $gaContent; ?>
	</div>
</div>

<div class="panel panel-<?php echo $pluginContentCssClass; ?>">
	<div class="panel-heading">
		<h3 class="panel-title">Plugins (geselecteerd door Occhio) <?php echo $pluginErrorsText; ?></h3>
	</div>
	<div class="panel-body">
		<?php echo $pluginContent; ?>
	</div>
</div>

<!--

		<div class="panel-body">
			<div class="list-group">
				<div class="list-group-item active"><strong>Site title (generated by Yoast SEO):</strong></div>
				<div class="list-group-item"><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></div>
			</div>	
		</div>

		<div class="panel-body">	
			<div class="list-group">
				<div class="list-group-item active"><strong>Meta description (generated by Yoast SEO):</strong></div>
				<div class="list-group-item"><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></div>	
			</div>
		</div>
-->

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Favicons and several site icons - <a style="float:right;" class="badge" target="_blank" href="http://www.favicomatic.com/">ga naar de generator website</a></h3>
	</div>
	<div class="panel-body">
		<table class="table table-condensed">
			<tbody>
				<tr>
					<th>Favicon</th>
					<td><img src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon.ico" alt="Favicon" /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 57 x 57</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-57x57.png" alt="Apple Touch Icon 57 x 57" /></td>			
				</tr>
				<tr>
					<th>Apple Touch Icon 60 x 60</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-60x60.png" alt="Apple Touch Icon 60 x 60"  /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 72 x 72</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-72x72.png" alt="Apple Touch Icon 72 x 72" /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 76 x 76</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-76x76.png"  alt="Apple Touch Icon 76 x 76" /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 114 x 114</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-114x114.png" alt="Apple Touch Icon 114 x 114" /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 120 x 120</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-120x120.png" alt="Apple Touch Icon 120 x 120" /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 144 x 144</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-144x144.png" alt="Apple Touch Icon 144 x 144"  /></td>
				</tr>
				<tr>
					<th>Apple Touch Icon 152 x 152</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/apple-touch-icon-152x152.png" alt="Apple Touch Icon 152 x 152" /></td>
				</tr>
				<tr>
					<th>Site Icon 16 x 16</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon-16x16.png" alt="Site Icon 16 x 16" /></td>
				</tr>
				<tr>
					<th>Site Icon 32 x 32</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon-32x32.png" alt="Site Icon 32 x 32" /></td>
				</tr>
				<tr>
					<th>Site Icon 96 x 96</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon-96x96.png" alt="Site Icon 96 x 96" /></td>
				</tr>
				<tr>
					<th>Site Icon 128</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon-128.png" alt="Site Icon 128" /></td>
				</tr>
				<tr>
					<th>Site Icon 196 x 196</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/favicon-196x196.png" alt="Site Icon 196 x 196" /></td>
				</tr>
				<tr>
					<th>Micosoft Tile 70 x 70</th>
					<td><img src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/mstile-70x70.png" alt="Micosoft Tile 70 x 70" /></td>
				</tr>
				<tr>
					<th>Micosoft Tile 144 x 144</th>
					<td><img class="site-icon" src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/mstile-144x144.png" alt="Micosoft Tile 144 x 144" /></td>
				</tr>
				<tr>
					<th>Micosoft Tile 150 x 150</th>
					<td><img src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/mstile-150x150.png" alt="Micosoft Tile 150 x 150" /></td>
				</tr>
				<tr>
					<th>Micosoft Tile 310 x 150</th>
					<td><img src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/mstile-310x150.png" alt="Micosoft Tile 310 x 150" /></td>
				</tr>
				<tr>
					<th>Micosoft Tile 310 x 310</th>
					<td><img src="<?php echo get_stylesheet_directory_uri(); ?>/site-icon/mstile-310x310.png" alt="Micosoft Tile 310 x 310" /></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>	

<?php if( $errorCount > 0 ) : ?>

<br/><div class="alert alert-danger">
	Er zijn <?php echo $errorCount; ?> aandachtspunten die opgelost moeten worden.
</div>

<?php endif; ?>

		<br/>
		<p>
			<a href="/?control=dev&method=stijldocument" class="btn btn-primary">bekijk het stijldocument</a>
			<a href="/?control=dev&method=testdocument" class="btn btn-default">bekijk het testdocument</a>
		</p>
		<br/>

</main>


<?php get_footer(); ?>