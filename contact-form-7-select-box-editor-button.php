<?php
/*
Plugin Name: Contact Form 7 Select Box Editor Button
Plugin URI: https://github.com/benjaminpick/wp-contact-form-7-select-box-editor-button
Description: Add a contact form link into article text. For contact forms where the recipient can be chosen in a select box.
Version: 0.6
Author: Benjamin Pick
Author URI: https://github.com/benjaminpick
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: contact-form-7-select-box-editor-button
Domain Path: /lang
*/
/***************************************************************************

Copyright: Benjamin Pick, 2012-2013

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
The license is also available at http://www.gnu.org/copyleft/gpl.html

**************************************************************************/

define('CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION', '0.6');
define('CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_REQUIRE_WPCF7_VERSION', '3.3');

/**
 * By default, use the parser of Contact Form 7 itself. Set this variable to true
 * to use the old (deprecated) regex parser.
 * @var boolean
 */
define('WPCF7_SELECT_BOX_EDITOR_BUTTON_USE_ALTERNATIVE_PARSER', false);

load_plugin_textdomain('contact-form-7-select-box-editor-button', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/');

if(!function_exists('_log')){
	// DEBUG FUNCTION, will only be doing something in Dev Environments
  function _log( $message ) {
    if( WP_DEBUG === true ){
      if( is_array( $message ) || is_object( $message ) ){
        error_log( "LOG: " . print_r( $message, true ) );
      } else {
        error_log( "LOG: " . $message );
      }
    }
    return $message;
  }
}

class AddContactForm7Link
{
	/**
	 * @var Wpcf7_SelectBoxEditorButton_Parser Parse the select tag of wpcf7 form
	 */
	protected $parser;
	
	public function __construct($parser = null)
	{
		if (is_null($parser) || !($parser instanceof Wpcf7_SelectBoxEditorButton_Parser))
		{
			if ((class_exists('WPCF7_FormTagsManager') ||class_exists('WPCF7_ShortcodeManager')) && !WPCF7_SELECT_BOX_EDITOR_BUTTON_USE_ALTERNATIVE_PARSER)
				$parser = new Wpcf7_SelectBoxEditorButton_Wpcf7_Shortcode_Parser();
			else
				$parser = new Wpcf7_SelectBoxEditorButton_SimpleRegexParser();
		}
		$this->parser = $parser;
	}
	
	/**
	 * Get email Adresses from a select recipient box
	 * with form id $id.
	 *
	 * @param int $id	Id of Form
	 * @return array(url-hash => label)
	 */
	public function get_available_adresses($id)
	{
		if ($id == 0)
			$id = $this->getFirstContactFormId();

		if ($id <= 0)
			return _log(__('No Contact Form found.', 'contact-form-7-select-box-editor-button')); // How to throw an error/warning?

		$contact_form = $this->get_wpcf7_form($id);
		if (!is_object($contact_form))
			return $contact_form;
			
		if (method_exists($contact_form, 'prop'))
			$form = $contact_form->prop('form');
		else
			$form = $contact_form->form; // backwards compat: ~3.7
		
		return $this->parser->getAdressesFromFormText($form);
	}
	
	public function get_wpcf7_form($id) {
		if (!function_exists('wpcf7_contact_form'))
			return _log('Contact Form 7 installed and activated?');
			
		return wpcf7_contact_form( $id );
	}
	
	public function getAllForms()
	{
		$contact_forms = get_posts( array(
				'numberposts' => -1,
				'orderby' => 'ID',
				'order' => 'ASC',
				'post_type' => 'wpcf7_contact_form' ) );
		_log($contact_forms);
		return $contact_forms;
	}

	/**
	 * @deprecated Use getAllForms()
	 * @return int Id of first form
	 */
	public function getFirstContactFormId()
	{
		$arr = $this->getAllForms();
		$first = reset($arr);
		
		if ($first)
			return $first->ID;
		else
			return false;
	}
	
	
	public function check_error($formId = 0)
	{
		$ret = $this->get_available_adresses($formId);
		if (is_string($ret))
			return __($ret, 'contact-form-7-select-box-editor-button');

		return true;
	}

}

// ------------- TinyMCE Kontakt Plugin ---------------
add_action('wp_ajax_addContactForm7Link_tinymce', 'contact_form_7_link_ajax');
/**
 * Call TinyMCE window content via admin-ajax
 *
 * @since 1.7.0
 * @return html content
 */
function contact_form_7_link_ajax() {
    // check for rights
    if ( !current_user_can('edit_pages') && !current_user_can('edit_posts') )
    	die(__("You are not allowed to be here"));

    $plugin = new AddContactForm7Link();
    $id = get_option('contactLinkFormSelectedId', 0);
	$adresses = $plugin->get_available_adresses($id);
   	
   	include_once( dirname(__FILE__) . '/tinymce/window.php');
 
    exit();
}


// --------------------- Backend: Edit Post or Page ----------------

add_action('admin_init', 'contact_form_7_link_addbuttons');
function contact_form_7_link_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "add_contact_form_7_link_tinymce_plugin");
     add_filter('mce_buttons', 'register_contact_form_7_link_button');
   }
}

function contact_form_7_load_lib()
{
	// This needs to be loaded after Contact Form 7 !
	require_once(dirname(__FILE__) . '/parsers.php');
}
add_action('plugins_loaded', 'contact_form_7_load_lib');

function register_contact_form_7_link_button($buttons) {
   array_push($buttons, "separator", "addContactForm7Link");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_contact_form_7_link_tinymce_plugin($plugin_array) {
   $plugin_array['addContactForm7Link'] = WP_PLUGIN_URL.'/contact-form-7-select-box-editor-button/tinymce/editor_plugin' . (WP_DEBUG ? '_src' : '') .  '.js';
   return $plugin_array;
}



// ------------- Backend: Edit options -------------------------

add_action('admin_menu', 'contact_form_7_select_box_editor_button_admin_menu');
function contact_form_7_select_box_editor_button_admin_menu($not_used){
    // place the info in the plugin settings page
	add_options_page(__('Contact Form 7 Select Box Editor Button', 'contact-form-7-select-box-editor-button'), __('Contact Form Editor Button', 'contact-form-7-select-box-editor-button'), 'manage_options', basename(__FILE__), 'contact_form_7_select_box_editor_button_option_page');
}

function contact_form_7_select_box_editor_button_option_page()
{// TODO: https://codex.wordpress.org/Settings_API
	$errors = array();
	$submitted = false;
	if (isset($_POST['submit']))
	{
		$old = get_option('contactLinkPrefix', '');
		$new = $_POST['contactLinkPrefix'];
		update_option('contactLinkPrefix', $new);
		if ($old && $new && $old != $new)
			$errors[] = __('Warning: You modified the Contact Form URL. You need to edit all existing links in order to update them, too.', 'contact-form-7-select-box-editor-button');
		
		update_option('contactTitlePrefix', $_POST['contactTitlePrefix']);
		update_option('contactLinkFormSelectedId', (int) @$_POST['form']);
		$submitted = true;
	}
		
	$class = new AddContactForm7Link();
	$forms = $class->getAllForms();
	
	// Get current options
	$form_selected_id = get_option('contactLinkFormSelectedId', 0);
	$contactLinkPrefix = get_option('contactLinkPrefix', '');
	$contactTitlePrefix = get_option('contactTitlePrefix', "");
	
	// Check for errors
	$hasError= $class->check_error($form_selected_id);
	if (is_string($hasError) && $hasError)
		$errors[] = $hasError;
		
	$checks = array();
	$checks['wpcf7-installed'] = defined('WPCF7_VERSION') && version_compare(WPCF7_VERSION, CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_REQUIRE_WPCF7_VERSION, '>=');
	$checks['wpcf7-form-select-tag'] = is_array($class->get_available_adresses($form_selected_id));
	
	$form_options = $class->get_wpcf7_form($form_selected_id);
	if (is_object($form_options))
		$form_options = $form_options->get_properties();
	$checks['wpcf7-form-mail-option'] = is_array($form_options) 
		&& ( strpos($form_options['mail']['recipient'], '[recipient]') !== false || 
			 ($form_options['mail_2']['active'] && strpos($form_options['mail_2']['recipient'], '[recipient]') !== false) 
	);

	if (empty($contactLinkPrefix))
	{
		$errors[] = __('URL of contact form is required!', 'contact-form-7-select-box-editor-button');
		$checks['wpcf7-form-url'] = false;
	} else {
		$checks['wpcf7-form-url'] = true;	
	}
	
	if ($errors)
		$error_msg = implode('<br /><br />', $errors);
		
	include('admin_options.php');
}



// --------- Frontend: Add Javascript -----------------

add_action('wpcf7_contact_form','contact_form_7_select_box_editor_button_init_frontend');
function contact_form_7_select_box_editor_button_init_frontend($contactForm) {
  // Only enqueues once, even if called multiple times
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery.ba-hashchange', plugins_url('/js/jquery.ba-hashchange.min.js',__FILE__), array('jquery'), CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION);
  wp_enqueue_script('contact_form_7_select_box_editor_button_init', plugins_url('/js/wpcf-select-box.js',__FILE__), array('jquery', 'jquery.ba-hashchange'), CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION);
}

