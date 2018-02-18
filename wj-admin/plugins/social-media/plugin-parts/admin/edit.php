<?php
/**
 * Social Media Plugin Part - Edit Social Item
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-09-02
 *
 * @returned @vars in use: $plugin_id, $plugin_name, $plugin_url, $plugin_dir, $dir
 */


// start bodyclass
global $bodyclass;
$bodyclass = 'wj-admin plugin scroll-text-plugin scroll-text-plugin-edit ';

// get header
include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/header.php'); ?>

	
<?php wj_before_content($type = 'main-section'); ?>

	<div class="social-container">
			<header class="page-header">
				<div class="social-nav">
					<a href="<?php echo $plugin_url; ?>">Back to Social Media Plugin</a>
				</div>
				<h2 class="page-title">Edit Social Media</h2>
			</header>

			<div class="form-contain">
				<form id="edit-scroll-form" method="post">

						
				</form>
			</div>
		</div>

<?php wj_after_content($type = 'main-section'); ?>

<?php

// get footer
include ($_SERVER['DOCUMENT_ROOT'] . '/footer.php'); ?>

