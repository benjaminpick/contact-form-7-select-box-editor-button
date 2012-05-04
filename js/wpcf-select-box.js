// Contact Form 7 Select Box Editor Button
// @see http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/

function wpcf7_update_select()
{
  var hash = window.location.hash;
  var value = decodeURIComponent(hash.substring(1).replace(/\+/g, '%20'));
  jQuery('#recipient').val(value);
}

jQuery(document).ready(function() {
  var form = jQuery('.wpcf7-form');
  
  // Do it when contact form is reset (after succesful submit) (not working yet)
  form.bind('reset', wpcf7_update_select);

  // Do it when hash changes (Link from same page, doesn't trigger ready again)
  form.hashchange(wpcf7_update_select);
  
  // Do it no!
  wpcf7_update_select();
});