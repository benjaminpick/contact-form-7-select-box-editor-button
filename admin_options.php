<?php
/* Option page */

function show_check($checks, $index = null) {
	static $img_url;
	if (is_null($img_url))
		$img_url = plugin_dir_url( __FILE__) . '/img/';

	if ($checks === true || (isset($checks[$index]) && $checks[$index])) {
		echo '<img src="' . $img_url . 'check.png" class="check" title="' . __('Done.', 'contact-form-7-select-box-editor-button') . '" />';
	} else {
		echo '<img src="' . $img_url . 'button_cancel.png" class="check" title="' . __('To do.', 'contact-form-7-select-box-editor-button') . '" />';
	}
}
?>
<div class="wrap">
	<?php if (!empty($error_msg)) : ?>
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
				<label for="selectform"><?php _e('Which form to use:', 'contact-form-7-select-box-editor-button'); ?></label>
			</td>
			<td>
		<?php if (!is_array($forms) || empty($forms)) : ?>
			<?php _e('Error: There are no forms to choose from.', 'contact-form-7-select-box-editor-button')?>
		<?php else: ?>
			<select id="selectform" name="form" class="regular-text">
			<?php foreach ($forms as $id => $form) : ?>
			<option value="<?php echo esc_attr($form->ID); ?>" <?php if ($form_selected_id == $form->ID) echo 'selected="selected"'; ?>><?php echo esc_html($form->post_title); ?></option>
			<?php endforeach; ?>
			</select>
		<?php endif; ?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="contactLinkPrefix"><?php _e('URL to contact form:', 'contact-form-7-select-box-editor-button'); ?></label>
			</td>
			<td>
				<input type="text" name="contactLinkPrefix" id="contactLinkPrefix" value="<?php echo esc_attr($contactLinkPrefix);?>" class="regular-text" />
			</td>
		</tr>
		<tr>
			<td>
				<label for="contactTitlePrefix"><?php _e('Prefix to title attribute', 'contact-form-7-select-box-editor-button'); ?></label>
			</td>
			<td>
				<input type="text" name="contactTitlePrefix" id="contactTitlePrefix" value="<?php echo esc_attr($contactTitlePrefix);?>" class="regular-text" />
			</td>
		</tr>
	</table>
	<p><input type="submit" class="button button-primary" value="<?php _e('Save Parameters', 'contact-form-7-select-box-editor-button'); ?>" /></p>
	</form>




	<p><br /></p>
	<h4><?php _e('First steps', 'contact-form-7-select-box-editor-button'); ?></h4>
	<ol class="js-wpcf7-button-firststeps">
		<li><?php printf(__('Install Contact Form 7 (at least Version %s)', 'contact-form-7-select-box-editor-button'), CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_REQUIRE_WPCF7_VERSION); ?><?php show_check($checks, 'wpcf7-installed'); ?></li>
		<li><?php _e('Install this plugin.', 'contact-form-7-select-box-editor-button'); ?><?php show_check(true); ?></li>
		<li><?php _e('In <a href="admin.php?page=wpcf7">Contact Form 7</a>, create a form containing a select tag, like this:', 'contact-form-7-select-box-editor-button'); ?><?php show_check($checks, 'wpcf7-form-select-tag'); ?>
<pre>
<code>[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]</code>
</pre>
		</li>
		<li>
			<?php _e('Set Mail option "To:" to <code>[recipient]</code>.', 'contact-form-7-select-box-editor-button'); ?><?php show_check($checks, 'wpcf7-form-mail-option'); ?>
		</li>
		<li>
			<?php _e('Now, if you call a page containing this contact form with <code>#Max+Mustermann</code> at the end, it should pre-select him as default.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
		<li>
			<?php _e('Insert the post\'s URL above.'); ?><?php show_check($checks, 'wpcf7-form-url'); ?>
		</li>
		<li>
			<?php _e('You can now edit a page and insert a Link to the contact form of Max Mustermann by clicking the envelope button of the editor.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
		<li>
			<?php _e('That\'s it! You can give feedback in the <a href="http://wordpress.org/support/plugin/contact-form-7-select-box-editor-button" target="_blank">Wordpress Forum</a> or file a bug report at <a href="https://github.com/benjaminpick/wp-contact-form-7-select-box-editor-button" target="_blank">github</a>.', 'contact-form-7-select-box-editor-button'); ?>
		</li>
	</ol>
</div>
<style>
	.check { vertical-align: bottom; padding: 2px 2px 2px 5px; }
</style>
