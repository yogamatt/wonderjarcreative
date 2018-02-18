<?php
/**
 * Wonderjar Included Functions
 * @author Matt
 * @category functions, include
 * @version 1.0
 * @since 2017-3-17
 */


/*
 * WJ Connect
 * @function wj_connect()
 *
 * Notes: If need quick db connect
 * connect to database
 *
 * Used: all-over
 */

if (!function_exists('wj_connect')) {

	function wj_connect(){
		global $conn;

		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		return $conn;
	}
}


/* WJ Head
 * @function wj_head($load)
 *
 * Notes: Print styles/scripts needed in header
 *
 * Used: /wj-admin/header.php
 */

if (!function_exists('wj_head')) {

	function wj_head($load) {

		echo $load;
	}
}


/* WJ Footer
 * @function wj_footer($script)
 *
 * Notes: Print scripts needed in footer
 *
 * Used: footer.php
 */

if (!function_exists('wj_footer')) {

	function wj_footer($script) {

		echo $script;
	}
}


/*
 * WJ Body Classes
 * @function wj_body_classes()
 *
 * Notes: Get body classes
 *
 * Used: /header.php
 */

if (!function_exists('wj_body_classes')) {

	function wj_body_classes($bodyclass) {

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}


		// sql
		if ($stmt = $conn->prepare("SELECT `option_value` FROM `options` WHERE `option_type` = ?")) {
			$stmt->bind_param("s", $param_type);

			// get the body options
			$param_type = 'body';

			$stmt->execute();

			$stmt->bind_result($options);

			// start $bodyclass and $row array()
			if (!isset($bodyclass)) {
				$bodyclass = '';
			}
			$row = array();

			// using while loop for multiple database rows
			while ($stmt->fetch()) {

				// set values array() into $row array()
				$row[] = array('options' => $options);
			
				$bodyclass .= $options . ' ';
			}

			$stmt->close();

		}

		$conn->close();

		// output $bodyclass
		// echoing into <body> tag
		echo $bodyclass;
	}
}


/*
 * Get menu for header
 * @function get_menu()
 *
 * Used: /templates/menu.php:12
 */

if (!function_exists('get_menu')) {

	function get_menu() {

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// start markup
		$mark = '<nav class="menu-nav">';
		$mark .= '<ul class="menu-nav-ul">';

		$sql = "SELECT `nav_position`, `nav_id`, `nav_title`, `nav_permalink` FROM `menus` ORDER BY `nav_position`";

		if ($stmt = $conn->prepare($sql)) {
			$stmt->execute();

			$stmt->bind_result($gmr_pos, $gmr_id, $gmr_title, $gmr_permalink);

			while ($stmt->fetch()) {

				$mark .= '<li><a href="' . $gmr_permalink . '">' . $gmr_title . '</a></li>';

			}

			$stmt->close();

		}

		$conn->close();

		$mark .= '</ul></nav>';

		echo $mark;
	}
}


/*
 * @function wj_before_content($type)
 * @function wj_after_content($type)
 * Used: all over
 *
 */

// Outputs the opening HTML
if (!function_exists('wj_before_content')) {

	function wj_before_content($type) {

		// switch the $type
		switch ($type) {
			case 'home-section':
				echo '<div class="homepage-section"><div class="inner-container">';
				break;
			case 'padding-section':
				echo '<div class="padding-section"><div class="inner-container">';
				break;
			case 'box-section':
				echo '<div class="padding-section"><div class="inner-container"><div class="box">';
				break;
			default:
				echo '<div class="main-section default-section"><div class="inner-container"><div class="inner-content">';
		}
	}
}

// Outputs the closing HTML
if (!function_exists('wj_after_content')) {

	function wj_after_content($type) {

		// Switch the $type
		switch ($type) {
			case 'home-section':
				echo '</div></div>';
				break;
			case 'padding-section':
				echo '</div></div>';
				break;
			case 'box-section':
				echo '</div></div></div>';
				break;
			default:
				echo '</div></div></div>';
		}
	}
}

/*
 * Get homepage ID
 * Function: wj_homepage_id()
 * Used: unused
 *
 */

if (!function_exists('wj_homepage_id')) {

	function wj_homepage_id() {

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// grab the homepage from `pages` -> `page_special`
		// SQL
		$sql = "SELECT `page_id` FROM `pages` WHERE `page_special` = ?";

		if ($stmt = $conn->prepare($sql)){

			// bind parameters
			$stmt->bind_param("s", $special_home);

			// set variable parameters
			$special_home = 'homepage';

			// execute
			$stmt->execute();

			// bind result variables
			$stmt->bind_result($homepage_id);

			// fetch
			$stmt->fetch();

			$stmt->close();

		}

		$conn->close();

		echo $homepage_id;
	}
}


/*
 * Sidebars
 * @function wj_sidebar()
 *
 * Used: all over
 */

if (!function_exists('wj_sidebar')) {

	function wj_sidebar($type) {

		switch($type) {

			case 'menus':
				include ($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/templates/template-parts/menus/menus-sidebar.php');
				break;

			case 'new-page':

				/* sidebar is inside of form
 				 * @var $admin_page
 				 */
				?>
					<aside class="sidebar">
						<header class="form-header">
							<h3 class="form-title">Single Page Options</h3>
							<?php 

							// if it has page id, use update button
							if (!empty($_GET['p_id'])): ?>
								<fieldset class="submit-group">
									<input type="submit" name="update" value="update">
								</fieldset>
							<?php 
							// if no page id, use submit button
							else: ?>
								<fieldset class="submit-group">
									<input type="submit" name="submit" value="submit">
								</fieldset>
							<?php endif; ?>
						</header>
						<fieldset>
							<div class="form-group">
								<label for="page-banner-thumb" class="label-top">Page Banner:</label>

								<?php 
								if (!empty($_GET['p_id'])):
									if (get_admin_page($_GET['p_id'])): global $admin_page;
										if ($admin_page['banner'] !== ''): ?>

											<img src="<?php echo $admin_page['banner']; ?>" alt="Page Banner" class="page-banner-thumb">
											<input type="file" id="page-banner" name="page-banner" class="input-hidden">
											<label for="page-banner" class="choose-button">Choose File</label>
										<?php else: ?>
											
											<input type="file" id="page-banner" name="page-banner" class="input-hidden">
											<label for="page-banner" class="choose-button">Choose File</label>
										<?php endif;
									endif;
								else: ?>

									<input type="file" id="page-banner" name="page-banner" class="input-hidden">
									<label for="page-banner" class="choose-button">Choose File</label>
								<?php
								endif; ?>

							</div>
						</fieldset>
						<fieldset>
							<div class="form-group">
								<p><strong>Avail. Classes</strong></p>
								<p>.row, .wj-full, .modal-action, .modal-target, .toggle-parent, .toggle-child</p>
							</div>
						</fieldset>
					</aside>
				<?php
				;
				break;
			case 'options':
				?>
					<aside class="sidebar">
							<header class="form-header">
								<h3 class="form-title">Theme Options</h3>
							</header>
							<div class="theme-options-container">
								<ul class="theme-options">
									<li class="theme-option">
										<a href="http://wonderjarcreative.com/wj-admin/index.php?page=options&theme_option=tagline">Tagline</a>
									</li>
									<li class="theme-option">
										<a href="http://wonderjarcreative.com/wj-admin/index.php?page=options&theme_option=promo">Promo</a>
									</li>
								</ul>
							</div>
							<div class="form-group">
								<p><strong>JS Functions</strong></p>
								<p>toggle(), full_width(), modal()</p>
								<p>&nbsp;</p>
								<p><strong>Avail. Classes</strong></p>
								<p>.toggle-parent, .toggle-child, .wj-full, .modal-action, .modal-target</p>
							</div>
					</aside>
				<?php
				;
				break;
				case 'form-plugin':
				?>
					<aside class="sidebar">

						<?php include($_SERVER['DOCUMENT_ROOT'] . '/wj-admin/plugins/forms/plugin-parts/admin/forms-sidebar.php'); ?>
					</aside>
				<?php
				;
				break;
			default:
				echo '';
		}
	}
}


/*
 * Get Homepage
 * @function get_homepage()
 *
 * Notes: Get the homepage page
 * 		  @returns: `page_id`, `page_time`, `page_special`, `page_title`, `page_content`
 *
 * Used: /templates/homepage.php:17
 *
 */

if (!function_exists('get_homepage')) {

	function get_homepage($section) {

		// batabase connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT * FROM `pages` WHERE `page_special` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $pspecial);

			// bind param
			$pspecial = $section;

			$stmt->execute();

			// bind result vars
			$stmt->bind_result($ghr_id, $ghr_time, $ghr_special, $ghr_title, $ghr_content, $ghr_permalink, $ghr_banner);

			// fetch
			$stmt->fetch();
			$stmt->close();

		}

		$conn->close();

		return array(
			'id' => $ghr_id,
			'time' => $ghr_time,
			'special' => $ghr_special,
			'title' => $ghr_title,
			'content' => $ghr_content,
			'permalink' => $ghr_permalink,
			'banner' => $ghr_banner
		);
	}
}


/*
 * Show Homepage Title
 * @function show_homepage_title()
 *
 * Notes: Uses @function get_homepage().
 * 		  Echos the homepage title. 
 *
 * Used: /templates/homepage.php
 */

if (!function_exists('show_homepage_title')) {

	function show_homepage_title($section) {

		$homepage = get_homepage($section);

		// start the header markup
		$title = '<h2 class="page-title">' . $homepage['title'] . '</h2>';

		echo $title;
	}
}

/*
 * Show Homepage Content
 * @function show_homepage_content()
 *
 * Notes: Uses @function get_homepage().
 * 		  Echos the homepage content
 *
 * Used: /templates/homepage.php
 */

if (!function_exists('show_homepage_content')) {

	function show_homepage_content($section) {

		$homepage = get_homepage($section);
		$homecontent = has_shortcodes($homepage['content']) ? find_shortcodes($homepage['content']) : $homepage['content'];

		// start the header markup
		$content = $homecontent;

		echo $content;
	}
}



/*
 * Get Page
 * @function get_page()
 * @category public
 *
 * Used: /templates/page.php
 */

if (!function_exists('get_page')) {

	function get_page() {

		// make sure has page id variable
		if (!empty($_GET['p_id'])) {

			// global $conn and $page
			global $conn, $page;
			wj_connect();

			$sql = "SELECT * FROM `pages` WHERE `page_id` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("i", $_GET['p_id']);
				$stmt->execute();

				$stmt->bind_result($gpr_id, $gpr_time, $gpr_special, $gpr_title, $gpr_content, $gpr_permalink, $gpr_banner);
				
				while ($stmt->fetch()) {
					$page = array(
						'id' => $gpr_id,
						'time' => $gpr_time,
						'special' => $gpr_special,
						'title' => $gpr_title,
						'content' => $gpr_content,
						'permalink' => $gpr_permalink,
						'banner' => $gpr_banner
					);
				}

				$stmt->close();
			}

			$conn->close();

			return $page;
		}
	}
}



/*
 * Insert New Page
 * @function insert_new_page()
 * @category admin
 *
 * Notes: Three statements being executed
 *
 * Used: /wj-admin/templates/new-page.php:15
 */

if (!function_exists('insert_new_page')) {

	function insert_new_page() {

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		
		// insert details
		$sql = "INSERT INTO `pages` (`page_title`, `page_special`,  `page_content`, `page_permalink`, `page_banner`)
					VALUES (?, ?, ?, ?, ?)";
		
		if ($stmt = $conn->prepare($sql)) {

			// bind params
			$stmt->bind_param("sssss", $page_title, $page_special, $page_content, $page_permalink, $page_banner);

			// set parameters
			$page_title = $_POST['page-title'];
			$page_content = $_POST['page-content'];
			$page_special = '';
			$page_permalink = '';
			$page_banner = !empty($_POST['page-banner']) ? 'http://wonderjarcreative.com/images/uploads/banner/' . $_POST['page-banner'] : '';

			$stmt->execute();
			$stmt->close();
		}
		
		// unset sql vars
		unset($stmt, $sql);

		
		// grab page_id from just inserted details
		$sql = "SELECT `page_id` FROM `pages` WHERE `page_title` = ?";

		if ($stmt = $conn->prepare($sql)) {

			// bind param page title, set above
			$stmt->bind_param("s", $page_title);
			$stmt->execute();

			$stmt->bind_result($page_id);
			$stmt->fetch();
			$stmt->close();
		}

		// unset sql vars
		unset($stmt, $sql);

		
		// update the permalink with the newly inserted
		// and retrieved page_id
		$sql = "UPDATE `pages` SET `page_permalink` = ? WHERE `page_id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("ss", $page_permalink, $param_id);

			$page_permalink = 'http://wonderjarcreative.com/index.php?p_id=' . $page_id;
			$param_id = $page_id;

			$stmt->execute();
			$stmt->close();
		}

		$conn->close();


		// refresh page to include new page_id
		header("Location: http://wonderjarcreative.com/wj-admin/index.php?page=new-page&p_id=" . $page_id . "");
	}
}


/*
 * Update New Page
 * @function update_new_page()
 *
 * Used: /wj-admin/templates/new-page.php
 */

if (!function_exists('update_new_page')) {

	function update_new_page() {

		// global database connection
		global $conn;
		wj_connect();

		// sql
		$sql = "UPDATE `pages` SET `page_title` = ?, `page_content` = ?, `page_banner` = ? WHERE `page_id` = ?";

		if ($stmt = $conn->prepare($sql)) {
				
			$stmt->bind_param("sssi", $unpp_title, $unpp_content, $unpp_banner, $unpp_id);

			// set params
			$unpp_id = $_GET['p_id'];
			$unpp_title = $_POST['page-title'];
			$unpp_content = $_POST['page-content'];
			$unpp_banner = !empty($_POST['page-banner']) ? 'http://wonderjarcreative.com/images/uploads/banner/' . $_POST['page-banner'] : '';

			$stmt->execute();

			$stmt->close();
		}

		$conn->close();
		
		// refresh page to include new page_id
		header("Location: http://wonderjarcreative.com/wj-admin/index.php?page=new-page&p_id=" . $unpp_id . "");
	}
}


/*
 * Delete page via the p_id
 * @function delete_page($p_id)
 *
 * Notes: Deletes page based on $p_id.
 *
 * Used: /wj-admin/templates/new-page.php:33
 */

if (!function_exists('delete_page')) {

	function delete_page($p_id) {

		// database connection
		global $conn;
		wj_connect();

		// sql
		$sql = "DELETE FROM `pages` WHERE `page_id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $p_id);
			$p_id = $p_id;

			// execute statement
			if ($stmt->execute()) {
				echo '<h1>Record id #' . $p_id . ' deleted.</h1>';
				
				// refresh page to include new page_id
				header("Location: http://wonderjarcreative.com/wj-admin/index.php?page=pages");
			}

			$stmt->close();
		}

		$conn->close();
	}
}


/*
 * Get Admin Page via the p_id
 * @function get_admin_page($p_id)
 *
 * Used: /wj-admin/templates/new-page.php:40
 */

if (!function_exists('get_admin_page')) {

	function get_admin_page($p_id) {

		// database connection and $admin_page
		global $conn, $admin_page;
		wj_connect();

		// SQL
		$sql = "SELECT * FROM `pages` WHERE `page_id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $param_id);
			
			// set params and execute
			$param_id = $p_id;
			$stmt->execute();

			$stmt->bind_result($gapr_id, $gapr_time, $gapr_special, $gapr_title, $gapr_content, $gapr_permalink, $gapr_banner);

			// if has results return details
			if ($stmt->fetch()) {

				$admin_page = array(
								'id' => $gapr_id,
								'time' => $gapr_time,
								'special' => $gapr_special,
								'title' => $gapr_title,
								'content' => $gapr_content,
								'permalink' => $gapr_permalink,
								'banner' => $gapr_banner
							);
			}

			$stmt->close();
		}

		$conn->close();

		return $admin_page;
	}
}


/*
 * Submit Tagline
 * @function submit_tagline()
 *
 * Used: /wj-admin/templates/template-parts/tagline.php
 */

if (!function_exists('submit_tagline')) {

	function submit_tagline() {

		if (!empty($_POST['tagline'])) {

			// database connection
			global $conn;
			wj_connect();

			// sql
			$sql = "INSERT INTO `options` (`option_type`,`option_name`,`option_value`) VALUES (?,?,?)
					ON DUPLICATE KEY UPDATE
						`option_type` = VALUES(`option_type`),
						`option_name` = VALUES(`option_name`),
						`option_value` = VALUES(`option_value`)";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("sss", $param_type, $param_name, $param_value);
				
				// set params
				$param_type = 'theme';
				$param_name = 'tagline';
				$param_value = $_POST['tagline-content'];

				$stmt->execute();
				$stmt->close();
			}

			$conn->close();
		}
	}
}


/*
 * Return Tagline
 * @function return_tagline()
 *
 * Used: /wj-admin/templates/template-parts/tagline.php
 */

if (!function_exists('return_tagline')) {

	function return_tagline() {

		global $tagline_content;

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `option_value` FROM `options` WHERE `option_name` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $param_name);

			// set param
			$param_name = 'tagline';

			$stmt->execute();

			$stmt->bind_result($tagline_content);
			$stmt->fetch();

			$stmt->close();
		}

		$conn->close();

		return $tagline_content;
	}
}


/*
 * Submit Promo
 * @function submit_promo()
 *
 * Used: /wj-admin/templates/template-parts/promo.php
 */

if (!function_exists('submit_promo')) {

	function submit_promo() {

		if (!empty($_POST['promo'])) {

			// database connection
			require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
			$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
			if ($conn->connect_error) {
		    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
			}

			// sql
			$sql = "INSERT INTO `options` (`option_type`,`option_name`,`option_value`) VALUES (?,?,?)
					ON DUPLICATE KEY UPDATE
						`option_type` = VALUES(`option_type`),
						`option_name` = VALUES(`option_name`),
						`option_value` = VALUES(`option_value`)";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("sss", $param_type, $param_name, $param_value);
				
				// set params
				$param_type = 'theme';
				$param_name = 'promo';
				$param_value = $_POST['promo-content'];

				$stmt->execute();
				$stmt->close();
			}

			$conn->close();
		}
	}
}


/*
 * Return Promo
 * @function return_promo()
 *
 * Used: /wj-admin/templates/template-parts/promo.php
 */

if (!function_exists('return_promo')) {

	function return_promo() {

		global $promo_content;

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `option_value` FROM `options` WHERE `option_name` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $param_name);

			// set param
			$param_name = 'promo';

			$stmt->execute();

			$stmt->bind_result($promo_content);
			$stmt->fetch();

			$stmt->close();
		}

		$conn->close();

		return $promo_content;
	}
}


/*
 * Submit Options
 * @function submit_options()
 *
 * Used: /wj-admin/templates/options.php:14
 */

if (!function_exists('submit_options')) {

	function submit_options() {

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		/* main options */

			// sql
			$sql = "INSERT INTO `options` (`option_type`,`option_name`,`option_value`) VALUES (?,?,?), (?,?,?)
					ON DUPLICATE KEY UPDATE 
						`option_type` = VALUES(`option_type`),
						`option_name` = VALUES(`option_name`),
						`option_value` = VALUES(`option_value`)";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("ssssss", $header_type_type, $header_type_label, $header_type, $homepage_layout_type, $homepage_layout_label, $homepage_layout);

				// set params
				$header_type_type = 'body';
				$header_type_label = 'option_header';
				$header_type = $_POST['header-type'];

				$homepage_layout_type = 'body';
				$homepage_layout_label = 'option_layout';
				$homepage_layout = $_POST['homepage-layout'];

				$stmt->execute();
				$stmt->close();
			}

		unset($stmt, $sql);

		/* unset homepage options */

			// sql
			$sql = "UPDATE `pages` SET `page_special` = ? WHERE `page_special` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("ss", $blank_value, $page_special);

				// set homepage params
				$blank_value = '';
				$page_special = 'homepage';

				$stmt->execute();


				// set homepage-section-1 params
				$blank_value = '';
				$page_special = 'homepage-section-1';

				$stmt->execute();


				// set homepage-section-2 params
				$blank_value = '';
				$page_special = 'homepage-section-2';

				$stmt->execute();


				// set homepage-section-3 params
				$blank_value = '';
				$page_special = 'homepage-section-3';

				$stmt->execute();


				// set homepage-section-4 params
				$blank_value = '';
				$page_special = 'homepage-section-4';

				$stmt->execute();
				$stmt->close();
			}


		unset($stmt, $sql);

		/* insert new homepage options */

			// sql
			$sql = "UPDATE `pages` SET `page_special` = ? WHERE `page_id` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("ss", $sop_label, $sop_id);

				// set homepage params
				$sop_label = 'homepage';
				$sop_id = $_POST['homepage'];

				$stmt->execute();

				
				// set homepage-section-1 params
				$sop_label = 'homepage-section-1';
				$sop_id = $_POST['homepage-section-1'];

				$stmt->execute();


				// set homepage-section-2 params
				$sop_label = 'homepage-section-2';
				$sop_id = $_POST['homepage-section-2'];

				$stmt->execute();


				// set homepage-section-3 params
				$sop_label = 'homepage-section-3';
				$sop_id = $_POST['homepage-section-3'];

				$stmt->execute();


				// set homepage-section-4 params
				$sop_label = 'homepage-section-4';
				$sop_id = $_POST['homepage-section-4'];

				$stmt->execute();
				$stmt->close();
			}

		$conn->close();

		// reload page
		header('Location: http://wonderjarcreative.com/wj-admin/index.php?page=options');
	}
}



/*
 * Option Generals
 * @function option_generals()
 *
 * Used: /wj-admin/templates/options:123
 */

if (!function_exists('option_generals')) {

	function option_generals() {

		// Database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
	    	die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// Global variables
		global $option_header_type, $option_layout;

		/*
		 * option_name: 'option_header'
		 * option_value: $option_header_type
		 *
		 */

		// SQL - $sql_head
		$sql_head = "SELECT `option_value` FROM `options` WHERE `option_name` = ?";

		if ($stmt_head = $conn->prepare($sql_head)) {

			// Bind paramaters
			$stmt_head->bind_param("s", $opt_header);

			// Set variable parameters
			$opt_header = 'option_header';

			// Execute
			$stmt_head->execute();

			// Bind result variables
			$stmt_head->bind_result($option_header_type);

			// Fetch
			$stmt_head->fetch();

			// Close $stmt_head
			$stmt_head->close();
		}

		/*
		 * option_name: 'option_layout'
		 * option_value: $option_layout
		 *
		 */

		// SQL - $sql_layout
		$sql_layout = "SELECT `option_value` FROM `options` WHERE `option_name` = ?";

		if ($stmt_layout = $conn->prepare($sql_layout)) {

			// Bind parameters
			$stmt_layout->bind_param("s", $opt_layout);

			// Set variable parameters
			$opt_layout = 'option_layout';

			// Execute
			$stmt_layout->execute();

			// Bind result variables
			$stmt_layout->bind_result($option_layout);

			// Fetch
			$stmt_layout->fetch();

			// Close $stmt_layout
			$stmt_layout->close();

		}

		return array ($option_header_type, $option_layout);

		$conn->close();
	}
}


/*
 * Option Pages
 * @function option_pages()
 *
 * Notes: Function used for the Homepage Option only.
 * 		  Returns the pages as inputs.
 * 
 * Used:
 * /wj-admin/templates/template-parts/options/layout.php:55
 */

if (!function_exists('option_pages')) {
	
	function option_pages() {

		// connect to database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		if ($stmt = $conn->prepare("SELECT `page_id`, `page_title`, `page_special` FROM `pages` ORDER BY `page_id` ASC")) {
						
			$stmt->execute();

			// get result and bind it
			$stmt->bind_result($pid, $ptitle, $pspecial);

			$pages = '';
										
			// while loop
			while ($stmt->fetch()) {
				
				$pages .= '<option value="' . $pid . '"';

				// add 'selected' if homepage
				if ($pspecial === 'homepage') {
					$pages .= 'selected';
				}

				$pages .= ' >' . $ptitle . '</option>';
			}

			$stmt->close();

		} else {
			echo 'SQL Failed';
		}

		$conn->close();
			
		echo $pages;
	}
}


/*
 * Option Section
 * @function option_section($section)
 *
 * Notes: Function used for the Homepage Section options in options.php.
 *		  Returns the pages as inputs.
 *
 * Used: /wj-admin/templates/template-parts/options/sections.php
 */

if (!function_exists('option_sections')) {

	function option_sections($section) {

		// connect to database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `page_id`, `page_title`, `page_special` FROM `pages`";

		if ($stmt = $conn->prepare($sql)) {

			// no params
			$stmt->execute();

			$stmt->bind_result($spr_id, $spr_title, $spr_special);

			// start $pages
			$pages = '';

			while ($stmt->fetch()) {

				$pages .= '<option value="' . $spr_id . '"';

				if ($spr_special === $section) {

					$pages .= 'selected';
				}

				$pages .= '>' . $spr_title . '</option>';
			}

			$stmt->close();
		}

		$conn->close();

		// echo the pages
		echo $pages;
	}
}


/*
 * Set inputs for setting menus
 * @function set_menu_inputs()
 *
 * Used: /wj-admin/templates/menu.php:25
 */

if (!function_exists('set_menu_inputs')) {

	function set_menu_inputs() {

		/* 
		 * Grab `page_id`, `page_title`
		 * for form inputs
		 */

		global $result;

		// Connect to database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');

		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);

		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// SQL
		$sql = "SELECT `page_id`, `page_title` FROM `pages`";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->execute();

			$stmt->bind_result($page_id, $page_title);

			$c = 0;
			$result = '';

			while ($stmt->fetch()) {

				$result .= '<div class="form-group checkbox">';
				$result .= '<input type="checkbox" id="input_' . $page_id . '" name="set_menu_[]" value="' . $page_id . '">';
				$result .= '<label for="input_' . $page_id . '">' . $page_title . '</label>';
				$result .= '</div>';

				$c++;
			}

			$stmt->close();
		}

		$conn->close();

		echo $result;
	}
}


/*
 * Insert pages and ids into menus
 * @function current_menu()
 *
 * Used: /wj-admin/templates/menu.php:14
 */

if (!function_exists('current_menu')) {

	function current_menu() {

		/*
		 * Existing Menu Pages
		 * @example Get the existing menu pages
		 * 			from `menus`.
		 */

		// Connect to the database
		// Keep open for multiple instances
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// Start variable markup and result_array
		$mark = '<div class="set-menus"><ul>';
		$result_array = array();

		// Grab existing pages from menus table
		$sql = "SELECT `nav_id` FROM `menus` ORDER BY `id` ASC";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->execute();
			$stmt->bind_result($results);

			while ($stmt->fetch()) {

				// Make result_array of ids
				$result_array[] .= $results;
			}
		}

		$stmt->close();

		unset($sql, $stmt);

		foreach ($result_array as $result) {

			$sql = "SELECT `page_id`, `page_title`, `page_permalink` FROM `pages` WHERE `page_id` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("s", $param_id);
				$param_id = $result;

				$stmt->execute();

				$stmt->bind_result($result_id, $result_title, $result_plink);
				$stmt->fetch();

				$stmt->close();
			}
			
			// Unset prepared vars
			unset($sql, $stmt);

			// Add to markup
			$mark .= '<li class="current-menu-item">';

			$mark .= '<div class="item-title-cont"><h3>';
			$mark .= $result_title;
			$mark .= '</h3></div>';

			$mark .= '<div class="item-option-cont">';
			$mark .= '<span><a href="http://wonderjarcreative.com/wj-admin/index.php?page=menus&p_id=' . $result_id . '&action=delete">delete</a></span>';
			$mark .= '</div>';

			$mark .= '<input type="hidden" name="menu-id[]" value="' . $result_id . '">';
			$mark .= '<input type="hidden" name="menu-title[]" value="' . $result_title . '">';
			$mark .= '<input type="hidden" name="menu-permalinks[]" value="' . $result_plink . '">';
			$mark .= '</li>';
		}

		/*
		 * New Menu Pages
		 * @example The inputs set_menu_[] return an array
		 *          in the post variable $_POST['set_menu_'].
		 *          You don't need the [] for the $_POST variable
		 */

		// Is this coming from the set-menu form?
		if (isset($_POST['set-menu-submit'])) {

			// Set the prepared statement
			$sql = "SELECT `page_id`, `page_title`, `page_permalink` FROM `pages` WHERE `page_id` = ?";
			
			if ($stmt = $conn->prepare($sql)) {
				$stmt->bind_param("s", $page_id);

				// $_POST['set_menu_'] is an array from the set-menu form
				$set_array = $_POST['set_menu_'];

				foreach ($set_array as $page_id) {

					$stmt->execute();

					$stmt->bind_result($page_id, $page_title, $page_permalink);

					$stmt->fetch();

					// Continue markup
					$mark .= '<li class="current-menu-item">';

					$mark .= '<div class="item-title-cont"><h3>';
					$mark .= $page_title;
					$mark .= '</h3></div>';

					$mark .= '<div class="item-option-cont">';
					$mark .= '<span><a href="http://wonderjarcreative.com/wj-admin/index.php?page=menus&p_id=' . $page_id . '&action=delete">delete</a></span>';
					$mark .= '</div>';

					$mark .= '<input type="hidden" name="menu-id[]" value="' . $page_id . '">';
					$mark .= '<input type="hidden" name="menu-title[]" value="' . $page_title . '">';
					$mark .= '<input type="hidden" name="menu-permalinks[]" value="' . $page_permalink . '">';
					$mark .= '</li>';
				}

				$stmt->close();
			}

			// Unset prepared vars
			unset($sql, $stmt);
		}
		
		$conn->close();

		// Finish markup and echo it
		$mark .= '</ul></div>';

		echo $mark;
	}
}


/*
 * Submitted current_menu_submit
 * @function current_menu_submit()
 * @version .02
 *
 * Used: /wj-admin/templates/menu.php:12
 */


if (!function_exists('current_menu_submit')) {

	function current_menu_submit() {

		global $conn;
		wj_connect();

		$sql = "INSERT INTO `menus` (`nav_position`, `nav_id`, `nav_title`, `nav_permalink`)
				VALUES (?,?,?,?)";

		$stmt = $conn->prepare($sql);

		$stmt->bind_param("iiss", $cmsp_pos, $cmsp_id, $cmsp_title, $cmsp_permalink);

		$num = 0;
		$current_ids = $_POST['menu-id']; // array
		$current_titles = $_POST['menu-title']; // array
		$current_permalinks = $_POST['menu-permalinks']; // array

		foreach ($current_ids as $key => $current_id) {
			
			$cmsp_pos = $num;
			$cmsp_id = $current_id;
			$cmsp_title = $current_titles[$key];
			$cmsp_permalink = $current_permalinks[$key];

			$stmt->execute();
			$num++;
		}

		$stmt->close();
		$conn->close();
	}
}

/*
 * Delete selected menu item
 * @function delete_memu_item()
 *
 * Used: /wj-admin/templates/menu.php:14
 */

if (!function_exists('delete_menu_item')) {

	function delete_menu_item() {

		if ($_GET['action'] === 'delete') {
			
			// no page id?
			if (!isset($_GET['p_id'])) {

				return;

			} else {

				// connect to the database
				require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
				$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
				if ($conn->connect_error) {
					die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
				}

				// delete menu item with get variable
				$sql = "DELETE FROM `menus` WHERE `nav_id` = ?";

				if ($stmt = $conn->prepare($sql)) {

					$stmt->bind_param("s", $param_id);
					$param_id = $_GET['p_id'];

					$stmt->execute();
					$stmt->close();
				}

				$conn->close();
			}

			echo 'deleted';
		}
	}
}


/*
 * Submit New Plugin
 * @function submit_plugin()
 *
 * Used: /wj-admin/templates/template-parts/plugins/plugin-new.php
 */


if (!function_exists('submit_plugin')) {

	function submit_plugin() {

		if (!empty($_POST['submit'])) {

			// connect to the database
			require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
			$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
			if ($conn->connect_error) {
				die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
			}

			$sql = "INSERT INTO `plugins` (`plugin_name`, `plugin_dir`, `plugin_url`, `plugin_description`)
						VALUES (?,?,?,?)
						ON DUPLICATE KEY UPDATE
							`plugin_name` = VALUES(`plugin_name`),
							`plugin_dir` = VALUES(`plugin_dir`),
							`plugin_url` = VALUES(`plugin_url`),
							`plugin_description` = VALUES(`plugin_description`)";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("ssss", $param_name, $param_dir, $param_url, $param_description);

				// set params
				$param_name = $_POST['plugin-name'];
				
					// format vars
					$folder = str_replace("-admin.php", "", $_POST['plugin-url']);
					$directory = $_SERVER['DOCUMENT_ROOT'] . '/wj-admin/plugins/' . $folder;

				$param_dir = $directory;
				$param_url = 'http://wonderjarcreative.com/wj-admin/plugins/' . $folder . '/' . $_POST['plugin-url'];

				$param_description = $_POST['plugin-description'];

				$stmt->execute();
				$stmt->close();
			}

			unset ($sql, $stmt, $param_name, $param_dir, $param_url, $param_description);

			/* return id */
			
			// sql
			$sql = "SELECT `id`, `plugin_url` FROM `plugins` WHERE `plugin_name` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("s", $param_name);

				// set param
				$param_name = $_POST['plugin-name'];
				$stmt->execute();

				$stmt->bind_result($result_id, $result_url);
				$stmt->fetch();
				$stmt->close();
			}

			unset ($sql, $stmt, $param_name);
			
			/* add id to permalink using the results from previous query */

			// sql
			$sql = "UPDATE `plugins` SET `plugin_url` = ? WHERE `id` = ?";

			if ($stmt = $conn->prepare($sql)) {

				$stmt->bind_param("si", $param_url, $param_id);

				// set params
				$param_url = $result_url . '?plug_id=' . $result_id;
				$param_id = $result_id;

				$stmt->execute();
				$stmt->close();
			}

			$conn->close();
		}
	}
}

/*
 * Update Plugin
 * @function update_plugin()
 *
 * Used: /wj-admin/templates/template-parts/plugins/plugin-edit.php
 */

if (!function_exists('update_plugin')) {

	function update_plugin() {

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		// not updating the dir or url
		$sql = "UPDATE `plugins` 
					SET `plugin_name` = ?,
						`plugin_description` = ?
					WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("sss", $param_name, $param_description, $param_id);

			// set params
			$param_name = $_POST['plugin-name'];
			$param_description = $_POST['plugin-description'];
			$param_id = $_GET['plug_id'];

			$stmt->execute();
			$stmt->close();
		}
		$conn->close();

		header("Location: http://wonderjarcreative.com/wj-admin/index.php?page=plugins");
	}
}

/*
 * Delete Plugin
 * @function delete_plugin()
 *
 * Used: /wj-admin/templates/template-parts/plugins.php
 */

if (!function_exists('delete_plugin')) {

	function delete_plugin() {

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "DELETE FROM `plugins` WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $param_id);

			// set param
			$param_id = $_GET['plug_id'];

			$stmt->execute();
			$stmt->close();
		}

		$conn->close();

		header("Location: http://wonderjarcreative.com/wj-admin/index.php?page=plugins");
	}
}


/*
 * Return Plugin
 * @function return_plugin()
 *
 * Used: /wj-admin/templates/template-parts/plugins/plugin-edit.php
 */


if (!function_exists('return_plugin')) {

	function return_plugin() {

		// start global vars
		global $plugin_id, $plugin_name, $plugin_dir, $plugin_url, $plugin_description;

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `id`, `plugin_name`, `plugin_dir`, `plugin_url`, `plugin_description` FROM `plugins` WHERE `id` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("i", $param_id);

			// set param
			$param_id = $_GET['plug_id'];
			$stmt->execute();

			$stmt->bind_result($plugin_id, $plugin_name, $plugin_dir, $plugin_url, $plugin_description);
			$stmt->fetch();

			return array($plugin_id, $plugin_name, $plugin_dir, $plugin_url, $plugin_description);

			$stmt->close();
		}

		$conn->close();
	}
}


/*
 * Get Plugin List
 * @function get_plugin_list())
 *
 * Used: /wj-admin/templates/template-parts/plugins/plugin-list.php
 */

if (!function_exists('get_plugin_list')) {

	function get_plugin_list() {

		// start mark
		$mark = '<ul class="plugins">';

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `id`, `plugin_name`, `plugin_dir`, `plugin_url`, `plugin_description` FROM `plugins` ORDER BY `id` ASC";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->execute();

			$stmt->bind_result($result_id, $result_name, $result_dir, $result_url, $result_description);

			while ($stmt->fetch()) {

				$actions = '<a href="http://wonderjarcreative.com/wj-admin/index.php?page=plugins&plug_id=' . $result_id . '&action=edit">Edit</a>';
				$actions .= '<a href="http://wonderjarcreative.com/wj-admin/index.php?page=plugins&plug_id=' . $result_id . '&action=delete">Delete</a>';

				$mark .= '<li class="plugin-item">';
				$mark .= '<div class="plugin-name">';
				$mark .= '<h3><a href="' . $result_url . '">' . $result_name . '</a></h3>';
				$mark .= '<div class="plugin-description">' . $result_description . '</div>';
				$mark .= '</div>';
				$mark .= '<div class="plugin-atts">';
				$mark .= '<div class="plugin-actions">' . $actions . '</div>';
				$mark .= '</div>';
				$mark .= '</li>';
			}

			$stmt->close();
		}

		$conn->close();

		$mark .= '</ul></div>';

		echo $mark;
	}
}


/*
 * Extra Stylesheets
 * @function extra_stylesheets()
 *
 * Notes: Load stylesheets for plugins
 *
 * Used: homepage.php
 */

if (!function_exists('extra_stylesheets')) {

	function extra_stylesheets() {

		global $load;
		$load = '';

		$location = 'http://wonderjarcreative.com';

		// database connection
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// get dirs
		$sql = "SELECT `plugin_dir` FROM `plugins` WHERE `plugin_name` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $fc_name);

			
			/* param: 'Features' */
			$fc_name = 'Features';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			
			while ($stmt->fetch()) {

				// features dir
				$dir = $location . strstr($fc_dir, "/wj-admin");

				// stylesheet
				$load .= '<link rel="stylesheet" href="' . $dir . '/includes/css/features.css">';
			}


			/* param: 'Scroll Text' */
			$fc_name = 'Scroll Text';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			while ($stmt->fetch()) {

				// scroll text dir
				$dir = $location . strstr($fc_dir, "/wj-admin");

				// stylesheet
				$load .= '<link rel="stylesheet" href="' . $dir . '/includes/css/public-horiz.css">';
			}


			/* param: 'Forms' */
			$fc_name = 'Forms';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			
			while ($stmt->fetch()) {

				// features dir
				$dir = $location . strstr($fc_dir, "/wj-admin");

				// stylesheet
				$load .= '<link rel="stylesheet" href="' . $dir . '/includes/css/public.css">';
			}

			
			$stmt->close();
		}

		return $load;
	}
}


/*
 * Extra Scripts
 * @function extra_scripts()
 *
 * Notes: Load scripts for plugins
 *
 * Used: homepage.php
 */

if (!function_exists('extra_scripts')) {

	function extra_scripts() {

		// global db connection
		global $conn, $script;
		wj_connect();
		
		$script = '';
		$location = 'http://wonderjarcreative.com';

		// get dirs
		$sql = "SELECT `plugin_dir` FROM `plugins` WHERE `plugin_name` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $fc_name);

			/* ------------------
			 * param: 'Features'
			 * ---------------
			$fc_name = 'Features';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			while ($stmt->fetch()) {

				$dir = $location . strstr($fc_dir, "/wj-admin");

				// define stylesheets with starting $script variable
				$script .= '<script src="' . $dir . '/includes/js/features.js"></script>';
			}
			*/


			/* ------------------
			 * param: 'Scroll Text'
			 * --------------- */
			$fc_name = 'Scroll Text';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			while ($stmt->fetch()) {

				$dir = $location . strstr($fc_dir, "/wj-admin");

				// define stylesheets with starting $load variable
				$script .= '<script src="' . $dir . '/includes/js/horiz.js"></script>';
			}


			/* ------------------
			 * param: 'Forms'
			 * --------------- */
			$fc_name = 'Forms';
			$stmt->execute();

			$stmt->bind_result($fc_dir);
			while ($stmt->fetch()) {

				$dir = $location . strstr($fc_dir, "/wj-admin");

				// define stylesheets with starting $load variable
				$script .= '<script src="' . $dir . '/includes/js/forms.js"></script>';
				$script .= '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
			}


			$stmt->close();
		}

		$conn->close();

		return $script;
	}
}


/*
 * Add shortcode
 * @function add_shortcode()
 *
 * Notes: use this to add a new shortcode to the database
 *
 * Used: all over
 */

if (!function_exists('add_shortcode')) {

	function add_shortcode($name, $call, $include) {

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "INSERT INTO `shortcodes` (`short_name`, `short_call`, `short_include`)
					VALUES (?, ?, ?)
					ON DUPLICATE KEY UPDATE
						`short_name` = VALUES(`short_name`),
						`short_call` = VALUES(`short_call`),
						`short_include` = VALUES(`short_include`)";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("sss", $name, $call, $include);

			$stmt->execute();
			$stmt->close();
		}

		$conn->close();
	}

}



/*
 * Call shortcode
 * @function call_shortcode()
 *
 * Notes: use this to call a shortcode by its short_name
 *
 * Used: all over
 */

if (!function_exists('call_shortcode')) {

	function call_shortcode($short_name, $args = '') {

		// connect to the database
		require ($_SERVER['DOCUMENT_ROOT'].'/wj-admin/assets/wj-connect.php');
		$conn = new mysqli('localhost', $wj_username, $wj_password, $wj_dbname);
		if ($conn->connect_error) {
			die('Connect Error (' . $conn->connect_errno . ') ' . $conn->connect_error);
		}

		// sql
		$sql = "SELECT `short_call`, `short_include` FROM `shortcodes` WHERE `short_name` = ?";

		if ($stmt = $conn->prepare($sql)) {

			$stmt->bind_param("s", $csp_name);

			// set param
			$csp_name = $short_name;
			
			if ($stmt->execute()) {

				$stmt->bind_result($csr_call, $csr_include);

				$stmt->fetch();
			}

			$stmt->close();
		}

		$conn->close();

		// require file containing function
		// call function
		// 0.1.1 added return to the call_user_func
		require ($csr_include);
		return call_user_func($csr_call, $args);
	}
}


/*
 * Find shortcodes
 * @function find_shortcodes())
 *
 * Notes: Find a shortcodes in the mce. Starts with [ and ends with ]
 *		  Can use id=%
 *
 * Used: mce
 */

if (!function_exists('find_shortcodes')) {

	function find_shortcodes($page_content) {
		// global $page_content;

		// first positions of '[' and ']'
		$first_bracket = strpos($page_content, '[');
		$last_bracket = strpos($page_content, ']');
		
		// distance between characters.. not sure why need one extra
		$length = $last_bracket - $first_bracket + 1;

		// return part of the string from the first bracket to end of length
		$shrt_with_brackets = substr($page_content, $first_bracket, $length);

		// remove brackets
		$brackets = array('[', ']');
		$shrt_no_brackets = str_replace($brackets, '', $shrt_with_brackets);

		// does it have an id?
		$id = strstr($shrt_no_brackets, 'id=');
		$func = str_replace($id, '', $shrt_no_brackets);
		$arg_id = str_replace('id=', '', $id);

		if ($id) {

			// call shortcode with args paramater
			$replace = call_shortcode($func, $arg_id);
		} else {

			// call shortcode with no args paramater
			$replace = call_shortcode($shrt_no_brackets);
		}

		// replace with the output of the shortcode
		$page_content = substr_replace($page_content, $replace, $first_bracket, $length);

		echo $page_content;
	}
}


/*
 * Has shortcodes
 * @function has_shortcodes()
 *
 * Notes: See if post has shortcodes
 *
 * Used: mce
 */

if (!function_exists('has_shortcodes')) {

	function has_shortcodes($page_content) {

		$code = strpos($page_content, '[');

		return $code;
	}
}


/*
 * Get Social Media
 * @function get_social_media()
 *
 * Notes: display social media links. Will replace
 *		  with social media plugin
 *
 * Used: footer
 */

if (!function_exists('get_social_media')) {

	function get_social_media() {

		$fb = 'https://www.facebook.com/wonderjarcreative';
		$linked = 'https://www.linkedin.com/in/matthew-ediger/';
		$github = 'https://github.com/yogamatt/';

		$mark = '<div class="social-media-container">';
		$mark .= '<a href="' . $fb . '" class="social-link"><i class="fa fa-facebook-official"></i></a>';
		$mark .= '<a href="' . $linked . '" class="social-link"><i class="fa fa-linkedin-square"></i></a>';
		$mark .= '<a href="' . $github . '" class="social-link"><i class="fa fa-github-square"></i></a>';
		$mark .= '</div>';

		echo $mark;
	}
}

?>