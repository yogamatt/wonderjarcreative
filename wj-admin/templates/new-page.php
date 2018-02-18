<?php
/**
 * Wonderjar Admin Template - New Page
 * @author Matt
 * @category admin, template
 * @version 1.0
 * @since 2017-03-17
 *
 */


// check for new-page submittal
if (!empty($_POST['submit'])):

	insert_new_page();
elseif (!empty($_POST['update'])):

	update_new_page();
endif;


// see if p_id is set
if (!empty($_GET['p_id'])):

	// set var $p_id
	$p_id = $_GET['p_id'];

	// and if action is set
	if (!empty($_GET['action'])) {

		$action = $_GET['action'];

		// check what the action is
		if ($action == 'delete') {

			delete_page($p_id);
		}

	// no action
	} else {

		// @function get_page_admin($p_id)
		// returns $admin_page
		if (get_admin_page($p_id)) {

			global $admin_page;
			include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/templates/template-parts/new-page/update.php');
		}
	}

// see if options is set
elseif (!empty($_GET['options'])):

	include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/templates/template-parts/new-page/options.php');

// no p_id or options
else:

	include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/templates/template-parts/new-page/empty.php');

endif;