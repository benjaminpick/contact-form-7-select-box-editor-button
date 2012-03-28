<?php
/* Option page */
?>
<div class="wrap">
	<?php if ($submitted) : ?>
	<div class="updated">
		<p><?php _e('Parameters saved.', 'contact-form-7-select-box-editor-button')?></p>
	</div>
	<?php endif; ?>
	<h2><?php _e('Contact Form 7 Select Box Editor Button', 'contact-form-7-select-box-editor-button'); ?></h2>
	<p></p>
	<p></p>
	<h4><?php _e('Parameters:', 'contact-form-7-select-box-editor-button'); ?></h4>
	<form action="" method="post">
		<input type="hidden" name="submit" value="1" />
	<table>
		<tr>
			<td>
				<label for="contactLinkPrefix"><?php _e('URL to contact form:', 'contact-form-7-select-box-editor-button'); ?></label>
			</td>
			<td>
				<input name="contactLinkPrefix" id="contactLinkPrefix" value="<?php echo esc_attr(get_option('contactLinkPrefix', ""));?>" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="contactTitlePrefix"><?php _e('Prefix to title attribute', 'contact-form-7-select-box-editor-button'); ?></label>
			</td>
			<td>
				<input name="contactTitlePrefix" id="contactTitlePrefix" value="<?php echo esc_attr(get_option('contactTitlePrefix', ""));?>" />
			</td>
		</tr>
	</table>
	<input type="submit" value="<?php _e('Save Parameters', 'contact-form-7-select-box-editor-button'); ?>" />
	</form>
	
	<p><br /></p>
	<h4><?php _e('First steps', 'contact-form-7-select-box-editor-button'); ?></h4>
	<?php _e('SELECT_BOX_EXPLANATION', 'contact-form-7-select-box-editor-button'); ?>
</div>