<?php
/**
 * Forms Plugin Part - Sidebar Options
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-07-18
 * @var $plugin[], $form[]
 *
 */

 ?>

<header class="form-header">
	<h3 class="form-title">Form Plugin Options</h3>
</header>
<fieldset>
	<div class="form-group">
		<p>Attach submit button?</p>
		<div class="radio-group">
			<label for="form-attach-submit-yes">Yes</label>
			<input type="radio" id="form-attach-submit-yes" name="form-attach-submit-yes" value="yes" <?php if (get_form_constants()['attach'] !== 0) echo 'checked'; ?>>
		</div>
		<div class="radio-group">
			<label for="form-attach-submit-no">No</label>
			<input type="radio" id="form-attach-submit-no" name="form-attach-submit-no" value="no" <?php if (get_form_constants()['attach'] == 0) echo 'checked'; ?>>
		</div>
	</div>
	<div class="form-group">
		<label for="form-email-notification" class="label-top">Notification Email:</label>
		<input type="email" id="form-email-notification" name="form-email-notification" value="<?php echo get_form_constants()['email-notification']; ?>">
	</div>
	<div class="form-group">
		<label for="form-inputs" class="label-top">Inputs
			<span class="sub-label">Format: 'name:input,'</span>
		</label>
		<textarea id="form-inputs" name="form-inputs" class="no-mce" rows="3" cols="15"><?php echo get_form_constants()['inputs']; ?></textarea>
	</div>
	<div class="form-group">
		<p><em>Do not use &lsaquo;form&rsaquo; tags</em></p>
		<p>&nbsp;</p>
		<p><strong>Common selectors:</strong></p>
		<p><em>.mark, .mark-group, .row, .col-6, .col-12</em></p>
	</div>
</fieldset>




