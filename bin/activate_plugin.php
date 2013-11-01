<?php
$abs = getenv('WP_TESTS_DIR');
if (!is_dir($abs))
	die('$WP_TESTS_DIR is not a directory.');
define('ABSPATH', $abs);

require_once ABSPATH.'wp-admin/includes/plugin.php';
require_once ABSPATH.'wp-admin/includes/plugin-install.php';

if ($_SERVER['argc'] < 2)
	die('Usage: php activate_plugin.php basename filename.php');

$basename = $_SERVER['argv'][0];
$filename = $_SERVER['argv'][1];


if (is_plugin_active( $basename ) || is_plugin_active_for_network( $basename ))
	die('Plugin already active.');
	
activate_plugin( $file );

if (!is_plugin_active( $basename ) && !is_plugin_active_for_network( $basename ))
	echo 'Plugin activation failed';
