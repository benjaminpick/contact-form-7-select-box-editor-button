=== Contact Form 7 Select Box Editor Button ===
Contributors: benjamin4
Tags: tinymce, button, contact form, german
Requires at least: 3.3
Tested up to: 4.7
Stable tag: trunk
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
* Adds Editor Button to the admin area where links to a contact form can be added or modified
* Contact form links can by styled by CSS
* Translation to German

**Requirements:**

* Contact Form 7 (v3.3 or later): http://wordpress.org/extend/plugins/contact-form-7/

== Installation ==

1. Install *Contact Form 7* first
1. Create a form containing a select tag:

   `[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]`

1. Set Mail option "To:" to `[recipient]` 
1. Install and Activate this plugin
1. Test it: Add this contact form to a page or post, and call it with `#Max+Mustermann` at the end. "Max Mustermann" should be pre-selected now.
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
4. Popup Window to choose Contact
5. The Email-Adresses are in the Contact Form 7 Tag

== Upgrade Notice ==

= 0.4 =
* The Parser has been rewritten to use Contact Form 7 parsing.
If this happens to break this plugin at your site, please send me your form code so that I can add it to my use cases. 

= 0.3.2 =
If upgrading this plugin, you should also upgrade Contact Form 7 to at least v3.3.

= 0.2.3 =
The Frontend Javascript code was added to the plugin itself,
so you should remove it from your contact form itself.
(For this version, the JS code wasn't modified, so it should continue to work if you don't.)

== Changelog ==

= 0.6 =
* Fix compatibility with WPCF7 4.6

= 0.5 =
* Nicer GUI for Wordpress 3.9
* First Steps: Automatic checks the items that are done
* Compat with WPCF7 3.9

= 0.4.3 =
* Compat with TinyMCE4 (upcoming Wordpress) was verified
* Fix: Compat with WPCF7 3.7

= 0.4.2 =
* Fix: Admin GUI window for Wordpress 3.8

= 0.4.1 =
* Fix: When a Link is edited, but the current recipient is not in the contact list anymore, the old recipient is now removed anyway.
* NEW: When changing the URL Prefix Option, show a warning that the links need to be updated (open the window and click insert).

= 0.4 =
* NEW: The contact form to use can now be chosen via a select box at the settings page
* Fix: select box can now have all syntax that wpcf7 supports.
* De: Translation updated.

= 0.3.3 =

* Fix: Select box can now have more options (see http://contactform7.com/checkboxes-radio-buttons-and-menus/)
* Show error message if no id/invalid id is given
* NEW: Load js files only if a contactform is shown
* Add unit tests

= 0.3.2 =
* Fix: Recipient is now the same as before submit.

= 0.3.1 =
* Fix: Avoid empty select boxes (when contact form is called with empty or invalid hashtag, and form was submitted)

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

* Currently, only one form can be used (selectable at the settings page)
* The URL could be detected (find all articles containing a contact form, and propose them in a select box)
* When clicking on a link that has the form on the same page, should it scroll to the form? Currently, it only changes the selected value.

These are limitations that I may (one day, if/when I come to it) adress in future.
So if you're a developer and want to adress them yourself,
go ahead and I will be happy to support you!
