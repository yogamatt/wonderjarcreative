<?php
/**
 * Scroll Text Plugin Part - Horiz Slide
 * @author Matt
 * @category admin, plugin, plugin-part
 * @version 1.0
 * @since 2017-06-10
 *
 * Notes: Individual slide used in scroll text templates
 *		  Have to store in a variable for short-code call function
 *
 * @returned @vars in use: $stcr_plugin_id, $stcr_plugin_name, $stcr_plugin_dir, $dir,
 *						   $stcr_scroll_slides, $stcr_scroll_title, $stcr_scroll_slug, $stcr_scroll_content
 *						   $key, $content
 */


$mark .= '<li class="scroll-field scroll-item-' . $key . '">';
$mark .= '<div class="scroll-content">' . $content . '</div>';
$mark .= '</li>';
