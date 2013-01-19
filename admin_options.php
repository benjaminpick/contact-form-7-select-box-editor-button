<?php
/* Option page */
?>
<div class="wrap">
	<?php if ($error_msg !== true) : ?>
	<div class="error">
		<p><?php echo $error_msg; ?></p>
	</div>
	<?php endif; ?>
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
	<ol>
		<li><strike><?php _e('Install Contact Form 7 and this plugin.', 'contact-form-7-select-box-editor-button'); ?></strike><?php _e('(You\'ve done that already, I suppose.)', 'contact-form-7-select-box-editor-button'); ?></li>
		<li><?php _e('In <a href="admin.php?page=wpcf7">Contact Form 7</a>, create a form containing a select tag, like this:', 'contact-form-7-select-box-editor-button'); ?>
			<pre>
			<code>[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]</code>
			</pre>
		</li>
		<li>
			<?php _e('Set Mail option "To:" to <code>[recipient]</code>.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
		<li>
			<?php _e('Now, if you call a page containing this contact form with <code>#Max+Mustermann</code> at the end, it should pre-select him as default.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
		<li>
			<?php _e('Insert the post\'s URL above, and then you can edit a page and insert a Link to the contact form of Max Mustermann by clicking the envelope button of the editor.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
		<li>
			<?php _e('That\'s it! You can give feedback in the <a href="http://wordpress.org/support/plugin/contact-form-7-select-box-editor-button" target="_blank">Wordpress Forum</a> or file a bug report at <a href="https://github.com/benjaminpick/wp-contact-form-7-select-box-editor-button" target="_blank">github</a>', 'contact-form-7-select-box-editor-button'); ?>
		</li>
	</ol>
</div>
