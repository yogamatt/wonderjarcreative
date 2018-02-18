<?php
/**
 * Forms Plugin Part - Label Above
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-07-18
 * @var $plugin[], $form[]
 *
 */
?>

<div id="form-<?php echo $form['id']; ?>" class="forms-form">
	<div class="form-wrapper">
		<h3 class="form-title"><?php echo $form['name']; ?></h3>
		<h4 class="form-description"><?php echo $form['description']; ?></h4>
		<form method="post">
			<div class="form-content">
				<?php echo strip_tags($form['markup'], '<label><input><textarea><button><div><h1><h2><h3><h4><h5><h6><span><fieldset><legend>'); ?>
			</div>

			<?php if ($form['attach-submit'] !== 0): ?>
				
				<div class="g-recaptcha" data-sitekey="6LeKXTcUAAAAAO8CJSlnRn1OceI02LPrr9mqhdhj"></div>
				<div class="form-submit">
					<input type="submit" id="forms-submit-<?php echo $form['id']; ?>" name="forms-submit-<?php echo $form['id']; ?>" value="Submit">
				</div>

			<?php endif; ?>
		</form>
	</div>
</div>
