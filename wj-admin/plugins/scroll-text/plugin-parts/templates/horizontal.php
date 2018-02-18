<?php
/**
 * Scroll Text Plugin Part - Horizontal Template
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-06-10
 *
 * Notes: Main Scroll Text Template File
 *
 * @returned @vars in use: $stcr_plugin_id, $stcr_plugin_name, $stcr_plugin_dir, $dir,
 *						   $stcr_scroll_slides, $stcr_scroll_title, $stcr_scroll_slug, $stcr_scroll_content
 */


// decode the content arrays
$content_array = json_decode($stcr_scroll_content);

// start markup
$mark = '<div class="scroll-slider scroll-horizontal">';
$mark .= '<ul class="scroll-list">';

foreach ($content_array as $key => $content):

	include ($stcr_plugin_dir . '/plugin-parts/templates/template-parts/horiz-slide.php');

endforeach;

$mark .= '</ul>';
$mark .= '</div>';


echo $mark;