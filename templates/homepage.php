<?php
/**
 * Wonderjar Template - Homepage
 * @author Matt
 * @category template
 * @version 1.0
 * @since 2017-03-29
 *
 */


// add homepage to bodyclass
$bodyclass .= 'home ';

// add extra stylesheets for plugins
extra_stylesheets();

// include header
include ($_SERVER['DOCUMENT_ROOT'] . '/header.php'); ?>


<section class="banner">
	<?php wj_before_content('home-section'); ?>
		<?php include ($_SERVER['DOCUMENT_ROOT'] . '/templates/template-parts/homepage/homepage-banner.php'); ?>
	<?php wj_after_content('home-section'); ?>
</section>

<section class="promo">
	<?php wj_before_content('home-section'); ?>
		<?php include ($_SERVER['DOCUMENT_ROOT'] . '/templates/template-parts/homepage/homepage-promo.php'); ?>
	<?php wj_after_content('home-section'); ?>
</section>

<?php if (call_shortcode('features-blurb')): ?>
	<section class="homepage-plugin-area">
		<?php wj_before_content('home-section'); ?>

			<div class="feature-plugin">
				<?php call_shortcode('features-blurb'); ?>
			</div>

		<?php wj_after_content('home-section'); ?>
	</section>
<?php endif; ?>

<section id="homepage" class="homepage">
	<?php wj_before_content('home-section'); ?>
		
		<header class="page-header">
			<?php show_homepage_title('homepage'); ?>
		</header>
		<main class="fmce-content">
			<?php show_homepage_content('homepage'); ?>
		</main>

	<?php wj_after_content('home-section'); ?>
</section>

<?php include ($_SERVER['DOCUMENT_ROOT'] . '/templates/template-parts/homepage/homepage-sections.php'); ?>



<?php

// add extra scripts for plugins
extra_scripts();

// include footer
include ($_SERVER['DOCUMENT_ROOT'] . '/footer.php');

?>