<?php
/**
 * Forms Plugin Part - Submissions List
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-07-18
 *
 * @var $dir, $plugin_dir, $plugin_id, $plugin_url
 * @var $fsl_id, $fsl_date, $fsl_form_id, $fsl_form_name, $fsl_form_content
 */

// some date vars
$dt = new DateTime($fsl_date);
$date = $dt->format('m/d/Y');
$time = $dt->format('h:i A');


?>

<li class="admin-item">
	<div class="admin-atts">
		<div class="admin-actions">
			<a href="<?php echo $plugin_url . '?plug_id=' . $plugin_id . '&form_id=' . $fsl_form_id . '&type=edit'; ?>">Edit Form</a>
			<a href="<?php echo $plugin_url . '?plug_id=' . $plugin_id . '&form_id=' . $fsl_form_id . '&type=submissions&sub_id=' . $fsl_id . '&sub_type=delete'; ?>">Delete Submission</a>
		</div>
	</div>
	<div class="submission">
		<div class="submission-name">
			<h4>Form Name: <span><?php echo $fsl_form_name; ?></span></h4>
		</div>
		<div class="submission-date">
			<h4>Submitted on: <span><?php echo $date . ' (' . $time . ')'; ?></span></h4>
		</div>
		<div class="submission-content">
			<h4>Content:</h4>
			<?php submission_content($fsl_form_content); ?>
		</div>
	</div>
</li>

