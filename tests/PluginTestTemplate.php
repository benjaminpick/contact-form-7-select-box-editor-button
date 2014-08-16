<?php

if (!defined('WP_DEBUG'))
	define('WP_DEBUG', false);
	
if (!defined('ABSPATH'))
{
	if (getenv('ABSPATH') && is_dir(getenv('ABSPATH')))
		define('ABSPATH', getenv('ABSPATH'));
	else
		define('ABSPATH', dirname(__FILE__) . '/../../../../');
}

if (!function_exists('load_plugin_textdomain')) {
	function load_plugin_textdomain() { }
}
if (!function_exists('plugin_basename')) {
	function plugin_basename() { }
}
if (!function_exists('add_action')) {
	function add_action() { }
}
if (!class_exists('AddContactForm7Link')) {
	require(dirname(__FILE__) . '/../contact-form-7-select-box-editor-button.php');
}

if (!function_exists('apply_filters')) {
	function apply_filters($name, $value) { return $value; }
}
if (!function_exists('is_email')) {
	function is_email($adress) { return strpos($adress, '@') !== false; }
}

if (!class_exists('WPCF7_ShortcodeManager'))
{
	if ( ! defined( 'WPCF7_USE_PIPE' ) )
		define( 'WPCF7_USE_PIPE', true );
	
	require_once(ABSPATH . '/wp-content/plugins/contact-form-7/includes/formatting.php');
	require_once(ABSPATH . '/wp-content/plugins/contact-form-7/includes/shortcodes.php');
	require_once(ABSPATH . '/wp-content/plugins/contact-form-7/includes/pipe.php');
}

if (!class_exists('Wpcf7_SelectBoxEditorButton_Wpcf7_Shortcode_Parser')) {
	require(dirname(__FILE__) . '/../parsers.php');	
}

abstract class PluginTestTemplate extends PHPUnit_Framework_TestCase
{
	protected $pluginObject;
	
	public function __construct($name = NULL, array $data = array(), $dataName = '')
	{
		parent::__construct($name, $data, $dataName);
	}
	
	protected function setUp()
	{
		//$this->pluginObject = new AddContactForm7Link();
	}
	
	protected static function callProtectedMethod($obj, $name, array $args) {
		$class = new \ReflectionClass($obj);
		$method = $class->getMethod($name);
		$method->setAccessible(true);
		return $method->invokeArgs($obj, $args);
	}
	
	protected static function setProtectedProperty($obj, $name, $value) {
		$class = new \ReflectionClass($obj);
		$prop = $class->getProperty($name);
		$prop->setAccessible(true);
		$prop->setValue($obj, $value);
	}
}