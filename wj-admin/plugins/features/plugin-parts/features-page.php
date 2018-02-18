<?php
/**
 * Features Plugin Part - Page
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-06-10
 *
 * @returned @vars in use: $plugin_id, $plugin_name, $plugin_dir, $dir, $plugin_url
 *			$fc_id, $fc_order, $fc_title, $fc_image, $fc_excrept, $fc_content,
 *			$fc_option_leading
 */

?>

<div class="features-page">
	<?php

		// start count
		$c = 1;

		while ($stmt->fetch()):

			// feature image src
			$fc_image_src = $dir . '/assets/images/icons/' . $fc_image; 
			$anchor = strtolower( str_replace( ' ', '-', $fc_title ) ); ?>
			
			<div id="<?php echo $anchor; ?>" class="feature-section feature-section-<?php echo $c; ?> <?php if ($c % 2 == 0) echo 'rtl'; ?> wj-full">
				<div id="feature-id-<?php echo $fc_id; ?>" class="feature-section-inner">
					<header class="feature-section-header">
						<div class="feature-section-header-inner">
							<span class="feature-section-image"><img src="<?php echo $fc_image_src; ?>" alt="Feature Image"></span>
							<h3><?php echo $fc_title; ?></h3>
						</div>
					</header>
					<div class="feature-section-body">
						<div class="fmce-content">
							<?php echo $fc_content; ?>
						</div>
					</div>
				</div>
			</div>
	
			<?php $c++; ?>

	<?php endwhile; ?>

</div>

