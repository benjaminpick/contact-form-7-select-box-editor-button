// Contact Form 7 Select Box Editor Button
// @see http://wordpress.org/extend/plugins/contact-form-7-select-box-editor-button/



jQuery(document).ready(function($) {
  var form = $('.wpcf7-form');
  
  var form_current_recipient = '';
  
  function wpcf7_update_select()
  {
    var hash = window.location.hash;
    var value;
    
    if (form_current_recipient != '')
    	value = form_current_recipient;
    else
    	value = decodeURIComponent(hash.substring(1).replace(/\+/g, '%20'));
    
    jQuery('#recipient').val(value);
    
    jQuery('.wpcf7-form select').each(function() {
  	 if (this.selectedIndex == -1)
  		 this.selectedIndex = 0;
    });
  }
  
  // Do it when contact form is reset (after succesful submit)
  form.bind('reset', function() {
	  // Workaround until this is fixed: http://wordpress.org/support/topic/plugin-contact-form-7-trigger-jquery-event
	  setTimeout(wpcf7_update_select, 50);
  });
  
  // Get current name from form before reset (needs Contact Form >= 3.3)
  $('.wpcf7').bind('submit.wpcf7', function () {
	  form_current_recipient = $('#recipient').val();
  });

  // Do it when hash changes (Link from same page, doesn't trigger ready again)
  $(window).hashchange(wpcf7_update_select);
  
  // Do it no!
  wpcf7_update_select();
});