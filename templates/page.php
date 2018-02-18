<?php
/**
 * Wonderjar Template - Page
 * @author Matt
 * @category template
 * @version 1.0
 * @since 2017-03-29
 *
 */
?>

<?php 

if (get_page()): global $page;

	// $bodyclass
	$p_id = $_GET['p_id'] ? $_GET['p_id'] : '';
	$bodyclass .= 'page-' . $p_id . ' page ';

	// add extra stylesheets for plugins
	extra_stylesheets();

	// include header
	include ($_SERVER['DOCUMENT_ROOT'].'/header.php'); ?>

	<?php if ($page['banner'] !== ''): ?>
		<header class="page-banner" style="background: url(<?php echo $page['banner']; ?>) center center no-repeat / cover">
			<div class="inner-container">
				<h1 class="page-banner-title"><?php echo $page['title']; ?></h1>
			</div>
		</header>
	<?php endif; ?>

	<?php wj_before_content($type = 'padding-section');

		/* if page banner is empty
		 * use regular banner */
		if (empty($page['banner'])):
			?>
			<header class="page-header">
				<h1 class="page-title"><?php echo $page['title']; ?></h1>
			</header>
			<?php
		endif;

		// does the page content have shortcodes?
		if (has_shortcodes($page['content'])): ?>

			<div class="fmce-content">
				<?php find_shortcodes($page['content']); ?>
			</div>

		<?php 

		// if not, that's cool too
		else: ?>

			<div class="fmce-content">
				<?php echo $page['content']; ?>
			</div>

		<?php endif;

	wj_after_content($type = 'padding-section');

	// add extra scripts for plugins
	extra_scripts();

	// include footer
	include ($_SERVER['DOCUMENT_ROOT'].'/footer.php');

endif;
