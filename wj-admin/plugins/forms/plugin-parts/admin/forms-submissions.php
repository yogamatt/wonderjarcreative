<?php
/**
 * Forms Plugin Part - Submissions
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-07-18
 *
 */


if (!empty($_GET['sub_type'])):
	if ($_GET['sub_type'] == 'delete'):
		delete_submission();
	endif;
endif;


$bodyclass = 'wj-admin plugin-forms forms-submissions ';

// include header
include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/header.php'); ?>


<?php wj_before_content($type = 'padding-section'); ?>

		
	<div class="forms-container">
		<header class="admin-header">
			<div class="forms-nav">
				<a href="<?php echo $plugin_url; ?>">Back to forms</a>
			</div>
			<h2><?php echo $plugin_name; ?> Submissions</h2>
		</header>

		<div class="forms-buttons">
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=new'; ?>">New Form</a></button>
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=options'; ?>">Options</a></button>
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=submissions'; ?>">Submissions</a></button>
		</div>

		<div class="forms-content">

			<?php forms_submission_list($dir, $plugin_dir, $plugin_id, $plugin_url); ?>

		</div>

	</div>


<?php wj_after_content($type = 'padding-section'); ?>



<?php

// include footer
include ($_SERVER['DOCUMENT_ROOT'] . '/footer.php'); ?>