<?php
//Define the Child Template Directory
define('CHILD_TEMPLATE_DIR', dirname( get_bloginfo('stylesheet_url')) );

// Add stylesheets
function add_stylesheets() {
	
	$templatedir = get_bloginfo('template_directory');
	$stylesheetdir = get_bloginfo('stylesheet_directory');
	?>
	
	<link rel="stylesheet" type="text/css" href="<?php echo CHILD_TEMPLATE_DIR; ?>/css/erudiate-child.css" />
	
	<?php
}
add_filter('wp_head', 'add_stylesheets');

?>
