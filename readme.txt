=== Contact Form 7 Select Box Editor Button ===
Contributors: benjamin4
Tags: tinymce, button, contact form, 
Requires at least: 3.2
Tested up to: 3.3.1
Stable tag: 0.2.1

Add a contact form link into article text.
For contact forms where the recipient can be chosen in a select box.

== Description ==

Ever wanted to use one contact form for all your contacts? Yet be able to link to a specific contact?
And without modifying 

Links:

* Contact Form 7 (required): http://wordpress.org/extend/plugins/contact-form-7/

== Installation ==

This section describes how to install the plugin and get it working.

e.g.

1. Install Contact Form 7 first
1. Create a form containing a select tag:
   `[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]`
1. Set Mail option "To:" to `[recipient]` 
1. Add the following code into the form as well:
   `<script type="text/javascript">
function wpcf7_update_select()
{
  var value = decodeURIComponent(window.location.hash.substring(1).replace(/\+/g, '%20'));
  jQuery('#recipient').val(value);
}
jQuery(document).ready(function() {
  wpcf7_update_select();
  jQuery('.wpcf7-form').bind('reset', wpcf7_update_select);
});
</script>`
1. Test it: Add this contact form to a page or post, and call it with #Max+Mustermann at the end. Max Mustermann should be pre-selected now.
1. Install and Activate this plugin
1. Configure the paremeters: 
  * The URL where the contact form resides (e.g. '/contact/')
  * An optional prefix to the title attribute that will get created.

== Frequently Asked Questions ==

= (Your Question here) =

(My answer :-)

== Screenshots ==

1. Form in action
2. Editor Button
3. Parameters

== Changelog ==

= 0.2.1 =
* Updated lang/de
* Add Screenshots

= 0.2 =
* Add German translation
* Fix: Link to WPCF7 Config
* Add Error Message when no select box found

= 0.1 =
* First version

== TO DO ==

* Currently, only one form can be used
* Add script to the plugin, instead of adding it in the contact form? So as to be able to update it?
