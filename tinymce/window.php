<?php

if ( !defined('ABSPATH') )
    die('You are not allowed to call this page directly.');
    
global $wpdb, $nggdb;

@header('Content-Type: ' . get_option('html_type') . '; charset=' . get_option('blog_charset'));
?>
<html>
	<head>
		<title><?php echo _e("Add Contact Form Link", 'contact-form-7-select-box-editor-button'); ?></title>
		<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_option('blog_charset'); ?>" />
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
		<script language="javascript" type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/jquery/jquery.js"></script>
	    <base target="_self" />
	</head>
<script type="text/javascript">
var contaktLinkPrefix = '<?php echo esc_js(get_option('contactLinkPrefix', "")); ?>';
var contaktTitlePrefix = '<?php echo esc_js(get_option('contactTitlePrefix', "")); ?>';

var rawData = <?php echo json_encode($adresses); ?>;

var AddLinkDialog = {
	local_ed : 'ed',
	
	init: function(ed) { AddLinkDialog.local_ed = ed; tinyMCEPopup.resizeToInnerSize(); this._initForm(); },

	_fillForm: function() {
		var parentNodeRaw = this.local_ed.selection.getNode();
		var parentNode = jQuery(parentNodeRaw);
		if(parentNode.attr("class") == "contact")
		{
			var href = parentNode.attr("href");
			for (var i = 0; i < rawData.length; i++)
			{
				if (href.indexOf(rawData[i].url) != -1)
					break;
			}
			if (i >= rawData.length)
			{
				alert('<?php echo esc_js(__("Contact not found, no edit mode.", 'contact-form-7-select-box-editor-button'));?>');
				return false;
			}
			jQuery('#selectEmail').val(i);
			jQuery('#inputLabel').val(parentNode.contents()[0]['nodeValue']);

			this.local_ed.selection.select(parentNodeRaw);
		}
		else if (!this.local_ed.selection.isCollapsed())
		{
			jQuery('#inputLabel').val(this.local_ed.selection.getContent());
		}
	},
	
	_initForm: function() {
		// Change defaults if edit
		this._fillForm();
		
		// Set correct email Adress
		jQuery('#selectEmail').change(updateEmail);
		updateEmail();
	},
	
	getData: function() {
		var index = jQuery('#selectEmail').val();

		if (rawData[index] === undefined)
		{
			alert("Unknown name!");
			return {};
		}
		
		return rawData[index];
	},
	
	insert: function(ed) {
		
		var url = this.getData().url;
		var labelName = this.getData()['name'];

		if (url+"" == "")       { alert("Unknown URL!"); return false; }
		if (labelName+"" == "") { alert("Unknown name!"); return false; }

		var aLabel = jQuery('#inputLabel').val();
		if (aLabel+"" == "")    { alert('<?php echo esc_js(__("Link text may not be empty!", 'contact-form-7-select-box-editor-button'));?>'); return false; }

		var toInsert = '<a href="' + contaktLinkPrefix + url + '" class="contact" title="' + contaktTitlePrefix + labelName + '">' + aLabel + '</a>';

		tinyMCEPopup.execCommand('mceInsertContent', false, toInsert);

		// Return
		tinyMCEPopup.close();
		return false;
	}
};
tinyMCEPopup.onInit.add(AddLinkDialog.init, AddLinkDialog);

function updateEmail()
{
	var value = AddLinkDialog.getData().email;
	jQuery('#inputEmailAdress').val(value);
}

</script>
<body id="link">
	<form action="#">
	
	<div class="panel_wrapper">
		<div id="gallery_panel" class="panel current">
		<table border="0" cellpadding="4" cellspacing="0">
         <tr>
            <td nowrap="nowrap"><label for="contactlink"><?php _e("Contact", 'contact-form-7-select-box-editor-button'); ?></label></td>
            <td>
				<select id="selectEmail" name="email">
<?php foreach ($adresses as $id => $adress) : ?>
					<option value="<?php echo esc_attr($id); ?>"><?php echo esc_html($adress['name']); ?></option>
<?php endforeach; ?>
				</select>
            </td>
          </tr>
         <tr>
            <td nowrap="nowrap"><label for="contactlink"><?php _e("Email Adress", 'contact-form-7-select-box-editor-button'); ?></label></td>
            <td>
            	<input id="inputEmailAdress" disabled="disabled" value="" />
            </td>
          </tr>
         <tr>
            <td nowrap="nowrap"><label for="contactlink"><?php _e("Link Text", 'contact-form-7-select-box-editor-button'); ?></label></td>
            <td>
            	<input id="inputLabel" name="label" value="<?php echo _e("E-Mail", 'contact-form-7-select-box-editor-button'); ?>" />
            </td>
          </tr>
         <tr>
            <td nowrap="nowrap"></td>
            <td>
            	<?php echo str_replace("[", '<a href="/wp-admin/admin.php?page=wpcf7" target="_top">', str_replace(']', '</a>', __('New Contacts can be added in the [contact form menu].', 'contact-form-7-select-box-editor-button'))); ?>
            </td>
          </tr>
        </table>
		</div>
	</div>

	<div class="mceActionPanel">
		<div style="float: left">
			<input type="button" id="cancel" name="cancel" value="<?php _e("Cancel", 'contact-form-7-select-box-editor-button'); ?>" onclick="tinyMCEPopup.close();" />
		</div>

		<div style="float: right">
			<input type="submit" id="insert" name="insert" value="<?php _e("Insert", 'contact-form-7-select-box-editor-button'); ?>" onclick="return AddLinkDialog.insert(AddLinkDialog.local_ed);" />
		</div>
	</div>
	</form>
</body>
</html>
