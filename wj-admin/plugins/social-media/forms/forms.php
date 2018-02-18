<?php
/**
 * Forms Plugin Included Functions
 * @author Matt
 * @category functions, plugin, forms
 * @version 1.0
 * @since 2017-06-10
 *
 */


/**
 * Forms Call
 * @function forms_call()
 *
 * Notes: Returns the form shortcode function.
 */

function forms_call($args) {
 	
 	// use output buffering to return value
 	ob_start();

 	// connect to database
 	global $conn;
 	wj_connect();

 	// plugin constants
 	$sql = "SELECT `id`, `plugin_dir`, `plugin_url` FROM `plugins` WHERE `plugin_name` = ?";

 	if ($stmt = $conn->prepare($sql)) {

 		$stmt->bind_param("s", $plugin_name);
 		$plugin_name = 'Forms';
 		$stmt->execute();

 		$stmt->bind_result($plugin_id, $plugin_dir, $plugin_url);

 		if ($stmt->fetch()) {

 			// set plugin array
 			$plugin = array(
 				'id' => $plugin_id,
 				'name' => $plugin_name,
 				'dir' => $plugin_dir,
 				'url' => $plugin_url
 			);

 		} else {
 			echo 'Plugin not found.';
 		}
 	} else {
 		echo 'Plugin not found, bad sql.';
 	}

 	unset($sql, $stmt);


 	// if has $args?
 	if ($args !== '') {

 		$sql = "SELECT `name`, `slug`, `description`, `markup`, `attach_submit`, `email_notification`, `inputs` FROM `forms` WHERE `id` = ?";

 		if ($stmt = $conn->prepare($sql)) {

 			$stmt->bind_param("i", $fcp_id);
 			
 			// set param
 			$fcp_id = $args;
 			$stmt->execute();

 			$stmt->bind_result($fcr_name, $fcr_slug, $fcr_description, $fcr_markup, $fcr_attach, $fcr_email_notification, $fcr_inputs);

 			if ($stmt->fetch()) {

 				$form = array(
 					'id' => $fcp_id,
 					'name' => $fcr_name,
 					'slug' => $fcr_slug,
 					'description' => $fcr_description,
 					'markup' => $fcr_markup,
 					'attach-submit' => $fcr_attach,
 					'email-notification' => $fcr_email_notification,
 					'inputs' => $fcr_inputs
 				);

 				if (!empty($_POST['forms-submit-' . $form['id']])) {

 					forms_handler($plugin, $form);

 				} else {

 					include($plugin['dir'] . '/plugin-parts/public/label-above.php');
 				}

 			} else {

 				echo 'Unable to get form via id.';
 			}

 			$stmt->close();
 		} else {
 			echo 'Bad sql.';
 		}
 	} else {

 		echo 'Sorry, no args to display from the plugin: \"' . $plugin['name'] . '\".';
 	}

 	$conn->close();
 	
 	return ob_get_clean();
}


/**
 * Forms Handler
 * @function forms_handler()
 *
 * Notes: Handle the public forms
 */

function forms_handler($plugin, $form) {

	// global db connection
	global $conn;
	wj_connect();

	// work through inputs and put into content array
	$input_array = explode(",", $form['inputs']);
	$content_array = array();

	foreach ($input_array as $inputs) {

		// get what's before the : by using 'true'
		$label = strstr($inputs, ':', true);
		$input = str_replace(':', '', strstr($inputs, ':'));

		// get post value of variable
		$content_array[] = $label . ' - ' . $_POST[$input];
	}
	
	// send to database
	$sql = "INSERT INTO `forms_submissions` (`form_id`, `form_name`, `form_content`)
				VALUES (?, ?, ?)
				ON DUPLICATE KEY UPDATE
					`form_id` = VALUES(`form_id`),
					`form_name` = VALUES(`form_name`),
					`form_content` = VALUES(`form_content`)";

	if ($stmt = $conn->prepare($sql)) {

		$stmt->bind_param("iss", $fh_id, $fh_name, $fh_content);

		// set params
		$fh_id = $form['id'];
		$fh_name = $form['name'];
		$fh_content = json_encode($content_array);

		$stmt->execute();

		$stmt->close();
	} else {
		echo 'Bad sql.';
	}

	// echo submission message
	echo 'Form submitted.';
}


/**
 * Forms Submission List
 * @function forms_submission_list()
 *
 * Notes: Returns the forms already inserted.
 */

function forms_submission_list($dir, $plugin_dir, $plugin_id, $plugin_url) {
	
	// start vars
	global $conn;

	// open list
	echo '<ul class="admin-list">';

	wj_connect();

	$sql = "SELECT `id`, `date`, `form_id`, `form_name`, `form_content` FROM `forms_submissions` ORDER BY `id` DESC";

	if ($stmt = $conn->prepare($sql)) {

		$stmt->execute();

		$stmt->bind_result($fsl_id, $fsl_date, $fsl_form_id, $fsl_form_name, $fsl_form_content);

		while ($stmt->fetch()) {

			include ($plugin_dir . '/plugin-parts/admin/forms-submission-list.php');
		}

		$stmt->close();
	}

	$conn->close();

	// close list
	echo '</ul>';
}


/**
 * Submission Content
 * @function submission_content()
 *
 * Notes: Returns the submission content within the submisison list
 */

function submission_content($fsl_form_content) {
	$contents = json_decode($fsl_form_content);

	if (!empty($contents)) {
		$mark = '';
		$c = 1;

		foreach ($contents as $content) {
			$label = strstr($content, ' - ', true);
			$output = strstr($content, ' - ');

			$mark .= '<div class="sub-content submission-content-' . $c . '">';
			$mark .= '<h5>' . $label . '<span>' . $output . '</span></h5>';
			$mark .= '</div>';

			$c++;
		}

		echo $mark;
	}
}

/**
 * Delete Submissions
 * @function delete submissions()
 *
 * Notes: Delete the submission
 */

function delete_submission() {

	// db connection
	global $conn;
	wj_connect();

	$sub_id = $_GET['sub_id'];
	$sub_type = $_GET['sub_type'];

	if (!empty($sub_id)) {

		$sql = "DELETE FROM `forms_submissions` WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $dsp_id);
			$dsp_id = $sub_id;

			$stmt->execute();
		} else {
			echo 'Cannot delete submission. Bad sql.';
		}
	}
}


/**
 * Forms list
 * @function forms_list()
 *
 * Notes: Returns the forms already inserted.
 */

function forms_list($dir, $plugin_id, $plugin_url) {
	
	// start vars
	global $conn;
	$mark = '<ul class="forms">';

	wj_connect();

	$sql = "SELECT `id`, `name`, `slug`, `description`, `markup` FROM `forms` ORDER BY `id`";

	if ($stmt = $conn->prepare($sql)) {

		$stmt->execute();

		$stmt->bind_result($nfr_id, $nfr_name, $nfr_slug, $nfr_description, $nfr_markup);

		while ($stmt->fetch()) {

			$actions = '<a href="' . $plugin_url . '?plug_id=' . $plugin_id . '&form_id=' . $nfr_id . '&type=delete">Delete</a>';
			$actions .= '<a href="' . $plugin_url . '?plug_id=' . $plugin_id . '&form_id=' . $nfr_id . '&type=edit">Edit</a>';

			$mark .= '<li class="form-item">';
			$mark .= '<div class="form-name">';
			$mark .= '<h3><a href="' . $dir . '/forms-admin.php?plug_id=' . $plugin_id . '&form_id=' . $nfr_id . '&type=edit">';
			$mark .= $nfr_name;
			$mark .= '</a></h3>';
			$mark .= '<div class="form-description">' . $nfr_description . '</div>';
			$mark .= '</div>';
			$mark .= '<div class="form-atts">';
			$mark .= '<div class="form-actions">' . $actions . '</div>';
			$mark .= '</div>';
			$mark .= '</li>';

		}

		$stmt->close();
	}

	$conn->close();

	$mark .= '</ul>';

	echo $mark;
}


/**
 * New Form
 * @function new_form()
 *
 * Notes: Insert new form.
 */

function new_form() {
	global $conn;

	wj_connect();

	$sql = "INSERT INTO `forms` (`name`, `slug`, `description`, `markup`, `attach_submit`, `email_notification`, `inputs`)
			VALUES (?, ?, ?, ?, ?, ?, ?)
				ON DUPLICATE KEY UPDATE
					`name` = VALUES(`name`),
					`slug` = VALUES(`slug`),
					`description` = VALUES(`description`),
					`markup` = VALUES(`markup`),
					`attach_submit` = VALUES(`attach_submit`),
					`email_notification` = VALUES(`email_notification`),
					`inputs` = VALUES(`inputs`)";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("ssssiss", $nfp_name, $nfp_slug, $nfp_description, $nfp_markup, $nfp_attach, $nfp_email_notification, $nfp_inputs);

		$nfp_name = $_POST['form-name'];
		$nfp_slug = $_POST['form-slug'];
		$nfp_description = $_POST['form-description'];
		$nfp_markup = $_POST['form-markup'];
			
			if (isset($_POST['form-attach-submit-yes'])) {
				$nfp_attach = 1;
			} else {
				$nfp_attach = 0;
			}

		$nfp_email_notification = $_POST['form-email-notification'];
		$nfp_inputs = $_POST['form-inputs'];

		if (!$stmt->execute()) {
			echo '<h4>New Form Not Submitted.</h4>';
		}

		$stmt->close();
	}

	$conn->close();
}


/**
 * Edit Form
 * @function edit_form()
 *
 * Notes: Insert edited form.
 */

function edit_form() {
	global $conn;

	wj_connect();

	$sql = "UPDATE `forms`
			SET `name` = ?,
				`slug` = ?,
				`description` = ?,
				`markup` = ?,
				`attach_submit` = ?,
				`email_notification` = ?,
				`inputs` = ?
			WHERE `id` = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("sssssssi", $efp_name, $efp_slug, $efp_description, $efp_markup, $efp_attach, $efp_email_notification, $efp_inputs, $efp_id);

		$efp_name = $_POST['form-name'];
		$efp_slug = $_POST['form-slug'];
		$efp_description = $_POST['form-description'];
		$efp_markup = $_POST['form-markup'];
			if (isset($_POST['form-attach-submit-yes'])) {
				$efp_attach = 1;
			} else {
				$efp_attach = 0;
			}
		$efp_email_notification = $_POST['form-email-notification'];
		$efp_inputs = $_POST['form-inputs'];
		$efp_id = $_GET['form_id'];

		if (!$stmt->execute()) {
			echo '<h4>Form not edited.</h4>';
		}

		$stmt->close();
	}

	$conn->close();
}


/**
 * Delete Form
 * @function delete_form()
 *
 * Notes: Delete form.
 */

function delete_form() {
	global $conn;

	if (!empty($_GET['form_id'])) {

		wj_connect();

		$sql = "DELETE FROM `forms` WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $dfp_id);
			
			$dfp_id = $_GET['form_id'];

			if ($stmt->execute()) {
				echo '<h4>Form deleted.</h4>';
			}

			$stmt->close();
		}
	
		$conn->close();

	} else {
		echo '<h4>Cannot delete via id.</h4>';
	}
}


/**
 * Get Form Constants
 * @function get_form_constants()
 *
 * Notes: Returns the single form constants via the id
 */

function get_form_constants() {
	global $conn;

	if (!empty($_GET['form_id'])) {

		wj_connect();

		$sql = "SELECT `id`, `name`, `slug`, `description`, `markup`, `attach_submit`, `email_notification`, `inputs` FROM `forms` WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $gfcp_id);
			$gfcp_id = $_GET['form_id'];

			$stmt->execute();

			$stmt->bind_result($gfcr_id, $gfcr_name, $gfcr_slug, $gfcr_description, $gfcr_markup, $gfcr_attach, $gfcr_email_notification, $gfcr_inputs);

			$stmt->fetch();
			$stmt->close();

			// return the constants
			return array(
				'id' => $gfcr_id,
				'name' => $gfcr_name,
				'slug' => $gfcr_slug,
				'description' => $gfcr_description,
				'markup' => $gfcr_markup,
				'attach' => $gfcr_attach,
				'email-notification' => $gfcr_email_notification,
				'inputs' => $gfcr_inputs
			);
		}

		$conn->close();

	} else {

		echo 'Cannot access form via id.';

	}
}


/*
 * Plugin Stylesheets
 * @function plugin_stylesheets()
 *
 * Notes: Starts the load variable. To use, add more loads
 *
 * Used: Admin
 */

if (!function_exists('plugin_stylesheets')) {

	function plugin_stylesheets($dir) {

		// define stylesheets with starting $load variable
		global $load;

		$load = '<link rel="stylesheet" href="' . $dir . '/includes/css/admin.css">';

		return $load;

	}

}


