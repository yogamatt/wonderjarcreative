<?php
/**
 * Forms Plugin Part - Options
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-07-18
 *
 */

// check for form submittal
if (!empty($_POST['submit'])) {

	set_forms_options();
} 

// get_forms_options()[]
// loop through values and put into $capt array
get_forms_options();

$vals = json_decode(get_forms_options()['opt_value']);
$capt = array();

foreach ($vals as $key => $val) {
	$capt[$key] = $val;
}



$bodyclass = 'wj-admin plugin-forms ';

// include header
include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/header.php'); ?>


<?php wj_before_content($type = 'padding-section'); ?>

		
	<div class="forms-container">
		<header class="admin-header">
			<div class="forms-nav">
				<a href="<?php echo $plugin_url; ?>">Back to forms</a>
			</div>
			<h2><?php echo $plugin_name; ?> Options</h2>
		</header>

		<div class="forms-buttons">
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=new'; ?>">New Form</a></button>
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=options'; ?>">Options</a></button>
			<button class="wj-admin"><a href="<?php echo $plugin_url . '&type=submissions'; ?>">Submissions</a></button>
		</div>

		<div class="forms-content">

			<form method="post">
				<div class="inner-form">
					<fieldset>
						<h3>Recaptcha</h3>
						<div class="form-group">
							<label for="forms-site-key" class="label-left">Site Key:</label>
							<input type="text" name="forms-site-key" id="forms-site-key" value="<?php echo $capt['site-key']; ?>">
						</div>
						<div class="form-group">
							<label for="forms-sec-key" class="label-left">Secret Key:</label>
							<input type="text" name="forms-sec-key" id="forms-sec-key" value="<?php echo $capt['sec-key']; ?>">
						</div>
					</fieldset>
					<fieldset class="submit-group">
						<input type="submit" name="submit" value="Submit">
					</fieldset>
				</div>
			</form>

		</div>

	</div>


<?php wj_after_content($type = 'padding-section'); ?>

<?php

// include footer
include ($_SERVER['DOCUMENT_ROOT'] . '/footer.php'); ?>