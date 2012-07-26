// Contact Form 7 Select Box Editor Button
// @see http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/

function wpcf7_update_select()
{
  var hash = window.location.hash;
  var value = decodeURIComponent(hash.substring(1).replace(/\+/g, '%20'));
  jQuery('#recipient').val(value);
  
  jQuery('.wpcf7-form select').each(function() {
	 if (this.selectedIndex == -1)
		 this.selectedIndex = 0;
  });
}

jQuery(document).ready(function($) {
  var form = $('.wpcf7-form');
  
  // Do it when contact form is reset (after succesful submit)
  form.bind('reset',  /* wpcf7_update_select */ function() {
	  // Workaround until this is fixed: http://wordpress.org/support/topic/plugin-contact-form-7-trigger-jquery-event
	  setTimeout(function() {
		  wpcf7_update_select();
	  }, 50);
  });

  // Do it when hash changes (Link from same page, doesn't trigger ready again)
  $(window).hashchange(wpcf7_update_select);
  
  // Do it no!
  wpcf7_update_select();
});