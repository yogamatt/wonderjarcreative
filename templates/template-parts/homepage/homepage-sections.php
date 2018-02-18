<?php
/**
 * Wonderjar Template Part - Homepage Sections
 * @author Matt
 * @category admin, template-part
 * @version 1.0
 * @since 2017-06-06
 *
 */
 ?>


<?php if (!get_homepage('homepage-section-1')['id'] == ''): ?>
	<!-- section 1 -->
	<section class="homepage-section-1 homepage-section">
		<div class="inner-container">
			<header class="page-header">
				<?php show_homepage_title('homepage-section-1'); ?>
			</header>
			<main class="fmce-content">
				<?php show_homepage_content('homepage-section-1'); ?>
			</main>
		</div>
	</section>
	<!-- end section 1 -->
<?php endif; ?>


<?php if (!get_homepage('homepage-section-2')['id'] == ''): ?>
	<!-- section 2 -->
	<section class="homepage-section-2 homepage-section">
		<div class="inner-container">
			<header class="page-header">
				<?php show_homepage_title('homepage-section-2'); ?>
			</header>
			<main class="fmce-content">
				<?php show_homepage_content('homepage-section-2'); ?>
			</main>
		</div>
	</section>
	<!-- end section 2 -->
<?php endif; ?>


<?php if (!get_homepage('homepage-section-3')['id'] == ''): ?>
	<!-- section 2 -->
	<section class="homepage-section-3 homepage-section">
		<div class="inner-container">
			<header class="page-header">
				<?php show_homepage_title('homepage-section-3'); ?>
			</header>
			<main class="fmce-content">
				<?php show_homepage_content('homepage-section-3'); ?>
			</main>
		</div>
	</section>
	<!-- end section 3 -->
<?php endif; ?>


<?php if (!get_homepage('homepage-section-4')['id'] == ''): ?>
	<!-- section 2 -->
	<section class="homepage-section-4 homepage-section">
		<div class="inner-container">
			<header class="page-header">
				<?php show_homepage_title('homepage-section-4'); ?>
			</header>
			<main class="fmce-content">
				<?php show_homepage_content('homepage-section-4'); ?>
			</main>
		</div>
	</section>
	<!-- end section 4 -->
<?php endif; ?>


