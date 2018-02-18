<?php
/**
 * Wonderjar Admin Template-Part - Update
 * @author Matt
 * @category admin, template-part
 * @version 1.0
 * @since 2017-06-3
 *
 */

// output opening html
wj_before_content($type = 'padding-section');

?>

	<div class="form-contain">
		<header class="admin-header">
			<h2>Page Review</h2>
		</header>
		<div class="new-page">
			<form id="update-page-form" method="post">
				<div class="inner-form">
					<div class="inner-left">	
						<fieldset>
							<div class="form-group">
								<label class="label-top" for="page-title">Page Title:</label>
								<input type="text" name="page-title" id="page-title" value="<?php echo $admin_page['title']; ?>">
							</div>
							<div class="form-group permagroup">
								<label class="label-top" for="page-permalink">Perma:</label>
								<input type="text" name="page-permalink" id="page-permalink" value="<?php echo $admin_page['permalink']; ?>" disabled>
							</div>
							<div class="form-group">
								<label class-"label-top" for="page-content">Page Content:</label>
								<textarea rows="20" cols="100" name="page-content" id="page-content"><?php echo $admin_page['content']; ?>
								</textarea>
							</div>
						</fieldset>
					</div>
					<?php wj_sidebar($type = 'new-page'); ?>
				</div>
			</form>
		</div>
	</div>

<?php

// output closing html
wj_after_content($type = 'padding-section');

