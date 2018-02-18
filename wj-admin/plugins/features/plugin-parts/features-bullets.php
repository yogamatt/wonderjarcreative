<?php
/**
 * Features Plugin Part - No Content
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
<section class="homepage-plugin-area homepage-section">
	<div class="inner-container">
		<div class="feature-plugin">

			<div id="plugin-<?php echo $plugin_id; ?>" class="features-container">
				<header class="page-header">
					<h2 class="page-title"><?php echo strip_tags($fc_option_leading); ?></h2>
				</header>
				<ul class="features-list">

					<?php

					// start count
					$c = 1;

					while ($stmt->fetch()):

						// feature image src
						$fc_image_src = $dir . '/assets/images/icons/' . $fc_image;
						$fc_link_page = 'http://wonderjarcreative.com/index.php?p_id=117';
						$anchor = strtolower( str_replace( ' ', '-', $fc_title ) ); ?>
								
							<li class="feature-item feature-id-<?php echo $fc_id; ?> item-<?php echo $c; ?>">

								<div class="feature-item-title">
									<a href="<?php echo $fc_link_page; ?>#<?php echo $anchor; ?>" class="feature-item-image-link"><img src="<?php echo $fc_image_src; ?>"></a>
									<h3><a href="<?php echo $fc_link_page ?>#<?php echo $anchor; ?>"><?php echo $fc_title; ?></a></h3>
								</div>

								<?php echo $fc_excrept; ?>
							</li>

						<?php $c++; ?>

					<?php endwhile; ?>

				</ul>
			</div>
		</div>
	</div>
</section>


