<p class="post-attributes-label-wrapper">
	<label class="post-attributes-label" for="isoc_pagecolor"><?php _e('Page Color', 'od'); ?></label>
</p>
<select name="isoc_pagecolor">
<?php
	foreach( $this->aOptions as $sOption ) {
		$sSelectText = ( $sOption == $this->sSelected ) ? ' selected' : NULL;
		echo '<option value="'.$sOption.'"'.$sSelectText.'>'.ucfirst($sOption).'</option>';
	}
?>
</select>
<p><?php _e('Select a color for the body of this page.', 'od'); ?></p>