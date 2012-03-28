=== Contact Form 7 Select Box Editor Button ===
Contributors: benjamin4
Tags: tinymce, button, contact form, 
Requires at least: 3.2
Tested up to: 3.3.1
Stable tag: 0.1

Add a contact form link into article text.
For contact forms where the recipient can be chosen in a select box.

== Description ==

Ever wanted to use one contact form for all your contacts? Yet be able to link to a specific contact?
And without modifying 

Links:

* Contact Form 7 (required): http://wordpress.org/extend/plugins/contact-form-7/

This is the long description.  No limit, and you can use Markdown (as well as in the following sections).

For backwards compatibility, if this section is missing, the full length of the short description will be used, and
Markdown parsed.

A few notes about the sections above:

*   "Contributors" is a comma separated list of wp.org/wp-plugins.org usernames
*   "Tags" is a comma separated list of tags that apply to the plugin
*   "Requires at least" is the lowest version that the plugin will work on
*   "Tested up to" is the highest version that you've *successfully used to test the plugin*. Note that it might work on
higher versions... this is just the highest one you've verified.
*   Stable tag should indicate the Subversion "tag" of the latest stable version, or "trunk," if you use `/trunk/` for
stable.

    Note that the `readme.txt` of the stable tag is the one that is considered the defining one for the plugin, so
if the `/trunk/readme.txt` file says that the stable tag is `4.3`, then it is `/tags/4.3/readme.txt` that'll be used
for displaying information about the plugin.  In this situation, the only thing considered from the trunk `readme.txt`
is the stable tag pointer.  Thus, if you develop in trunk, you can update the trunk `readme.txt` to reflect changes in
your in-development version, without having that information incorrectly disclosed about the current stable version
that lacks those changes -- as long as the trunk's `readme.txt` points to the correct stable tag.

    If no stable tag is provided, it is assumed that trunk is stable, but you should specify "trunk" if that's where
you put the stable version, in order to eliminate any doubt.

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

= 0.2 =
* Add German translation

= 0.1 =
* First version

== TO DO ==

* Currently, only one form can be used
* Add script to the plugin, instead of adding it in the contact form? So as to be able to update it?