// Contact Form 7 Select Box Editor Button
// @see http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/

function wpcf7_update_select()
{
  var value = decodeURIComponent(window.location.hash.substring(1).replace(/\+/g, '%20'));
  jQuery('#recipient').val(value);
}

jQuery(document).ready(function() {
  wpcf7_update_select();
  jQuery('.wpcf7-form').bind('reset', wpcf7_update_select);
});