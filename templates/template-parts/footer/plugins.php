<?php
/**
 * Wonderjar Template Part - Footer Plugins
 * @author Matt
 * @category admin, template-part
 * @version 1.0
 * @since 2017-06-06
 *
 */

 ?>

 <div class="footer-left footer-col">
 	<div class="footer-col-inner">
	 	<h3>Contact Info</h3>
	 	<address>
	 		Wonderjar Creative<br>
	 		1227 West Colfax<br>
	 		Lakewood, Colorado 80215
	 	</address>
	 	<a href="mailto:info@wonderjarcreative.com">info@wonderjarcreative.com</a>
	 	<a href="tel:7202872529" rel="tel">(720) 287-2529</a>
	 </div>
 </div>

 <div class="footer-middle footer-col">
 	<div class="footer-col-inner">
	 	<h3>Pages</h3>
	 	<?php get_menu(); ?>
	 	<h3>Services</h3>
	 	<?php get_services(); ?>
 	</div>
 </div>

 <div class="footer-right footer-col">
 	<div class="footer-col-inner">
 		<?php 
 			// integrate social media plugin later
 			get_social_media();
 		?>
 		<p><a href="/">&copy; 2017-2018 Wonderjar Creative</a></p>
 	</div>
 </div>