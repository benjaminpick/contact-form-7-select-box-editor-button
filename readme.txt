=== Contact Form 7 Select Box Editor Button ===
Contributors: benjamin4
Tags: tinymce, button, contact form, 
Requires at least: 3.2
Tested up to: 3.4
Stable tag: 0.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add a contact form link into article text.
For contact forms where the recipient can be chosen in a select box.

== Description ==

Ever wanted to use one contact form for all your contacts? Yet be able to link to a specific contact?
And without modifying the *Contact Form 7* extension?

This little extension guides you to set up *Contact Form 7*, enter the contacts there, and then adds an editor button by which you can link a specific contact form.

**Features:**

* Email adresses are invisible to website visitors (no spam)
* Adds Editor Button to add or modify links to a contact form
* Contact form links can by styled by CSS

**Links:**

* Contact Form 7 (required): http://wordpress.org/extend/plugins/contact-form-7/

== Installation ==

1. Install *Contact Form 7* first
1. Create a form containing a select tag:

   `[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]`

1. Set Mail option "To:" to `[recipient]` 
1. Test it: Add this contact form to a page or post, and call it with `#Max+Mustermann` at the end. "Max Mustermann" should be pre-selected now.
1. Install and Activate this plugin
1. Configure the parameters: 
  * The URL where the contact form resides (e.g. `/contact/`)
  * An optional prefix to the title attribute that will get created.

== Frequently Asked Questions ==

= Can I contribute bugfixes or new features to this extension? =

Of course, be welcome! Send me a pull request at [Github](https://github.com/benjaminpick/wp-contact-form-7-select-box-editor-button).

== Screenshots ==

1. Form in action
2. Editor Button
3. Parameters

== Upgrade Notice ==

= 0.2.3 =
The Frontend Javascript code was added to the plugin itself,
so you should remove it from your contact form itself.
(For this version, the JS code wasn't modified, so it should continue to work if you don't.)

== Changelog ==

= 0.3 =
* Feature: Also handle links that are on the same page as the contact form
* Fix: Correctly reset select box after succesful submit

= 0.2.3 =
* Performance: Compressed JS files
* Frontend JS Code is added by plugin
* Add Install Instruction to admin page

= 0.2.2 =
* De: Fix button title

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

* Currently, only one form can be used (let me know if this isn't enough!)
* The URL could be detected (find all articles containing a contact form, and propose them in a select box)
* When change URL Prefix, at least show a warning that the links need to be updated (load, insert).
* When clicking on a link that has the form on the same page, should it scroll to the form?