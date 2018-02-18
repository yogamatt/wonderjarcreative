<?php
/**
 * Wonderjar Plugin - Features
 * @author Matt
 * @category plugin
 * @version 1.0
 * @since 2017-06-11
 *
 */


// include functions files
include ($_SERVER['DOCUMENT_ROOT'] . '/functions.php');
include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/plugins/features/features.php');

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

// shortcode vars for blurbs
$name = 'features-blurb';
$call = 'features_blurb_call';
$include = $plugin_dir . '/features.php';

// shortcode vars for full page features
$page_name = 'features-page';
$page_call = 'features_page_call';
$page_include = $plugin_dir . '/features.php';

// add shortcode
add_shortcode($name, $call, $include);
add_shortcode($page_name, $page_call, $page_include);


if (!empty($_GET['type'])) {

	$type = $_GET['type'];

	switch ($type) {
		case 'new':

			if (!empty($_POST['new-feature'])) {
				submit_feature();
			} else {
				include ($plugin_dir . '/plugin-parts/features-new.php');
			}
		break;

		case 'options':
			if (!empty($_POST['options'])) {
				submit_feature_options();
			} else {
				include ($plugin_dir . '/plugin-parts/features-options.php');
			}
		break;

		case 'edit':

			if (!empty($_POST['edit-feature'])) {
				edit_feature();
			} else {
				include ($plugin_dir . '/plugin-parts/features-single.php');
			}
		break;

		case 'delete':

			delete_feature($plugin_url);
		break;

		default:

			echo 'default';
		break;
	}

} else {

	// main layout
	include ($plugin_dir . '/plugin-parts/features-layout.php');
}


