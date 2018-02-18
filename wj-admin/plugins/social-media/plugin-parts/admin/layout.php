<?php
/**
 * Social Media Plugin Part - Social Media Admin Layout
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-09-02
 *
 * @returned @vars in use: $plugin_id, $plugin_name, $plugin_dir, $dir
 */

// start bodyclass
global $bodyclass;
$bodyclass = 'wj-admin plugin social-media-plugin ';

// get header
include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/header.php');

?>

<?php wj_before_content($type = 'plain-section'); ?>

		
	<div class="layout-container">
		<header class="admin-header">
			<h2><?php echo $plugin_name; ?></h2>
		</header>

		<div class="layout-buttons">
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=edit'; ?>">New Social Item</a></button>
		</div>

		<div class="layout-content">

			<?php //get_scroll_list(); ?>

		</div>

	</div>


<?php wj_after_content($type = 'plain-section'); ?>

<?php

// get footer
include ($_SERVER['DOCUMENT_ROOT'] . '/footer.php');
