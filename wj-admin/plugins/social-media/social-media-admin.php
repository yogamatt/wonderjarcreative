<?php
/**
 * Wonderjar Plugin - Features
 * @author Matt
 * @category plugin
 * @version 1.0
 * @since 2017-09-02
 *
 */


// include functions files
include($_SERVER['DOCUMENT_ROOT'] . '/functions.php');
include($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/plugins/social-media/social-media.php');

// make sure user is logged in
check_session();

// get plugin constants
// returns: $plugin_id, $plugin_name, $plugin_dir, $plugin_url, $plugin_description
plugin_constants();

// define directory
$location = 'http://wonderjarcreative.com';
$dir = $location . strstr($plugin_dir, "/wj-admin");

// load stylesheets using the plugin directory
plugin_stylesheets($dir);

// shortcode vars using plugin directory
$name = 'social-media';
$call = 'social_media_call';
$include = $plugin_dir . '/social-media.php';

// add shortcode
add_shortcode($name, $call, $include);



if (!empty($_GET['type'])) {

	$type = $_GET['type'];

	switch ($type) {
		case 'edit':
			include ($plugin_dir . '/plugin-parts/admin/edit.php');
		break;

		default:
			include ($plugin_dir . '/plugin-parts/admin/layout.php');
		break;
	}



} else {

	// main layout
	include ($plugin_dir . '/plugin-parts/admin/layout.php');

}



