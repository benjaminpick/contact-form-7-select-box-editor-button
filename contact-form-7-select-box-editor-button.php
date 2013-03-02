<?php
/*
Plugin Name: Contact Form 7 Select Box Editor Button
Plugin URI: https://github.com/benjaminpick/wp-contact-form-7-select-box-editor-button
Description: Add a contact form link into article text. For contact forms where the recipient can be chosen in a select box.
Version: 0.3.3
Author: Benjamin Pick
Author URI: https://github.com/benjaminpick
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
/***************************************************************************

Copyright: Benjamin Pick, 2012

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

define('CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION', '0.3.3');

load_plugin_textdomain('contact-form-7-select-box-editor-button', false, dirname( plugin_basename( __FILE__ ) ) . '/lang/');
if(!function_exists('_log')){
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
	 * Get email Adresses from a select recipient box
	 * with form id $id.
	 *
	 * @param int $id	Id of Form
	 * @return array(url-hash => label)
	 */
	public function get_available_adresses($id)
	{
		if ($id <= 0)
			return _log('Invalid form!'); // How to throw an error/warning?
		if (!function_exists('wpcf7_contact_form'))
			return _log('Contact Form 7 installed and activated?');
			
		$contact_form = wpcf7_contact_form( $id );
		if (!is_object($contact_form))
			return $contact_form;
		
		return $this->getAdressesFromFormText($contact_form->form);
	}
	
	public function getAdressesFromFormText($text)
	{
		$res = preg_match('/\[select\*? .* id:([a-z]+)[^"]* (".*")[^"]*\]/i', $text, $matches);
		if ($res == 0)
			return _log('No select box found.');
		
		$id = $matches[1]; // Currently hardcoded to #recipient : TODO Show error if not present or different id
		$adresses = $matches[2];
		
		preg_match_all('/"([^"|]+)\|([^"|]+@[^"|]+)"/', $adresses, $matches, PREG_SET_ORDER);
		
		$ret = array();
		foreach($matches as $match)
		{
			$name = $match[1];
			$email = $match[2];
				
			$url = '#' . str_replace("%20", "+", urlencode($name));
			$label = $name . " <" . $email . ">";
				
			$ret[] = array('url' => $url, 'email' => $email, 'name' => $name, 'label' => $label);
		}
		
		_log($ret);
		
		return $ret;
	}
	
	public function getFirstContactFormId()
	{
		$contact_forms = get_posts( array(
			'numberposts' => -1,
			'orderby' => 'ID',
			'order' => 'ASC',
			'post_type' => 'wpcf7_contact_form' ) ); // TODO -> select box for options?
		
		$first = reset($contact_forms);
		
		if ($first)
			return $first->ID;
		else
			return false;
	}
	
	
	public function check_error()
	{
		$id = $this->getFirstContactFormId();
		if ($id < 1)
			return __('No Contact Form found.', 'contact-form-7-select-box-editor-button');
		
		$ret = $this->get_available_adresses($id);
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
    $id = $plugin->getFirstContactFormId(); // TODO get from option
	$adresses = $plugin->get_available_adresses($id);
    	
	// TODO: pre-select select adress (js or GET) from current selection; get Link-Text
   	include_once( dirname(__FILE__) . '/tinymce/window.php');
    
    exit();
}


function contact_form_7_link_addbuttons() {
   // Don't bother doing this stuff if the current user lacks permissions
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
   	_log('Add Button!');
     add_filter("mce_external_plugins", "add_contact_form_7_link_tinymce_plugin");
     add_filter('mce_buttons', 'register_contact_form_7_link_button');
   }
}
 
function register_contact_form_7_link_button($buttons) {
   array_push($buttons, "separator", "addContactForm7Link");
   return $buttons;
}
 
// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function add_contact_form_7_link_tinymce_plugin($plugin_array) {
   $plugin_array['addContactForm7Link'] = WP_PLUGIN_URL.'/contact-form-7-select-box-editor-button/tinymce/editor_plugin' . (WP_DEBUG ? '_src' : '') .  '.js';
   return $plugin_array;
}
 
function contact_form_7_select_box_editor_button_admin_menu($not_used){
    // place the info in the plugin settings page
		add_options_page(__('Contact Form 7 Select Box Editor Button', 'contact-form-7-select-box-editor-button'), __('Contact Form Editor Button', 'contact-form-7-select-box-editor-button'), 'manage_options', basename(__FILE__), 'contact_form_7_select_box_editor_button_option_page');
}
add_action('admin_menu', 'contact_form_7_select_box_editor_button_admin_menu');

function contact_form_7_select_box_editor_button_option_page()
{
	$submitted = false;
	if (isset($_POST['submit']))
	{
		update_option('contactLinkPrefix', $_POST['contactLinkPrefix']);
		update_option('contactTitlePrefix', $_POST['contactTitlePrefix']);
		$submitted = true;
	}
		
	$class = new AddContactForm7Link();
	$error_msg = $class->check_error();
	
	$contactLinkPrefix = get_option('contactLinkPrefix', '');
	if (empty($contactLinkPrefix))
	{
		if ($error_msg !== true)
			$error_msg .= "<br />";
		else
			$error_msg = '';

		$error_msg .= __('URL of contact form is required!', 'contact-form-7-select-box-editor-button');
	}
	include('admin_options.php');
}

// init process for button control
add_action('admin_init', 'contact_form_7_link_addbuttons');

function contact_form_7_select_box_editor_button_init_frontend() {
  // TODO: Only do if a contact form is shown?
  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery.ba-hashchange', plugins_url('/js/jquery.ba-hashchange.min.js',__FILE__), array('jquery'), CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION);
  wp_enqueue_script('contact_form_7_select_box_editor_button_init', plugins_url('/js/wpcf-select-box.js',__FILE__), array('jquery', 'jquery.ba-hashchange'), CONTACT_FORM_7_SELECT_BOX_EDITOR_BUTTON_VERSION);
}
add_action('init','contact_form_7_select_box_editor_button_init_frontend');

