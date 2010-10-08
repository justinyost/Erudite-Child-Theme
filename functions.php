<?php
//Define the Child Template Directory
define('CHILD_TEMPLATE_DIR', dirname( get_bloginfo('stylesheet_url')) );

// Add stylesheets
function _add_stylesheets() {
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo CHILD_TEMPLATE_DIR; ?>/css/erudiate-child.css" />
	<?php
}

//Adds MyOpen ID Information to act as a delegate server
function _add_my_open_id_information(){
	?>
	<link rel="openid.server" href="http://www.myopenid.com/server">
	<link rel="openid.delegate" href="http://jtyost2.myopenid.com/">
	<?php
}

//Add Generic stuff to the head
function add_to_head(){
	_add_stylesheets();
	_add_my_open_id_information();
}

//Add Generic stuff to the sidebar
function add_to_sidebar(){
}

//Add Generic stuff to the footer
function add_to_footer(){
}

//Add Filters
add_filter('wp_head', 'add_to_head');
add_filter('wp_sidebar', 'add_to_sidebar');
add_filter('wp_footer', 'add_to_footer');
?>
