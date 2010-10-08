<?php

// Add stylesheets
function add_stylesheets() {
	
	$templatedir = get_bloginfo('template_directory');
	$stylesheetdir = get_bloginfo('stylesheet_directory');
	?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo $templatedir ?>/css/erudiate-child.css" />
	
	<?php
}
add_filter('wp_head', 'add_stylesheets');

?>
