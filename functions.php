<?php
//Define the Child Template Directory
define('CHILD_TEMPLATE_DIR', get_stylesheet_directory() );

//Require the Theme Options
require_once(CHILD_TEMPLATE_DIR."/library/theme-options.php");

/**
 * add_stylesheets function.
 *
 * @access public
 * @return void
 */
function add_stylesheets() {
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/erudite-child.css" />
	<?php
}

/**
 * add_my_open_id_information function.
 *
 * @access public
 * @return void
 */
function add_my_open_id_information(){
	$options = get_theme_options();

	if(isset($options['open_id_server']) && !is_null($options['open_id_server']) && isset($options['open_id_delegate']) && !is_null($options['open_id_delegate'])):
		?>
		<link rel="openid2.provider" href="<?php echo $options['open_id_server']; ?>" />
    		<link rel="openid2.local_id" href="<?php echo $options['open_id_delegate']; ?>" />
		<link rel="openid.server" href="<?php echo $options['open_id_server']; ?>" />
		<link rel="openid.delegate" href="<?php echo $options['open_id_delegate']; ?>" />
		<?php
	else:
	endif;
}

/**
 * add_favicons function.
 *
 * @access public
 * @return void
 */
function add_favicons(){
	?>
	<link href="<?php echo home_url(); ?>/favicon.ico" rel="shortcut icon" />
	<?php if(get_iphone_non_retina_icon()): ?>
		<link rel="apple-touch-icon" sizes="57x57" href="<?php echo home_url(); ?>/apple-touch-icon-57x57-precomposed.png" />
	<?php endif; ?>
	<?php if(get_iphone_retina_icon()): ?>
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo home_url(); ?>/apple-touch-icon-72x72-precomposed.png" />
	<?php endif; ?>
	<?php if(get_ipad_non_retina_icon()): ?>
		<link rel="apple-touch-icon" sizes="114x114" href="<?php echo home_url(); ?>/apple-touch-icon-114x114-precomposed.png" />
	<?php endif; ?>
	<?php if(get_ipad_retina_icon()): ?>
		<link rel="apple-touch-icon" sizes="144x144" href="<?php echo home_url(); ?>/apple-touch-icon-144x144-precomposed.png" />
	<?php endif; ?>
	<?php
}

/**
 * add_meta_tags function.
 *
 * @access public
 * @return void
 */
function add_meta_tags(){

	global $post;
	$options = get_theme_options();

	if(is_single()){
		?>
		<meta name="description" content="<?php echo $post->post_excerpt; ?>" />
		<meta name="revised" content="<?php echo $post->post_modified_gmt; ?>" />
		<meta name="author" content="<?php echo get_author_complete_name($post->post_author); ?>" />
		<meta name="keywords" content="<?php echo get_post_tags($post->ID); ?>" />
		<meta property="og:title" content="<?php echo $post->post_title; ?>" />
		<meta property="og:url" content="<?php echo get_permalink($post->ID); ?>" />
		<?php
	} else if(is_front_page()) {
		?>
		<meta name="description" content="<?php echo get_option('blogdescription', "Just another WordPress Blog."); ?>" />
		<?php
	} else if(is_page()) {

	} else {

	}
	?>
	<meta property="og:site_name" content="<?php echo get_option('blogname'); ?>" />
	<meta property="og:type" content="blog" />
	<?php
}

/**
 * get_post_tags function.
 *
 * @access public
 * @param mixed $post_ID (default: null)
 * @return void
 */
function get_post_tags($post_ID = null){
	$tags = wp_get_post_tags($post_ID);
	$tags_string = null;
	foreach($tags as $tag){
		$tags_string = $tags_string.$tag->name.", ";
	}
	$tags_string = rtrim($tags_string, ', ');
	return $tags_string;
}

/**
 * insert_short_url function.
 *
 * @access public
 * @return void
 */
function insert_short_url(){
	global $post;
	if(is_single()){
		$shortURL = return_short_url();
		?>
		<link rel="shortlink" href="<?php echo $shortURL; ?>" />
		<?php
	}
}

/**
 * get_author_complete_name function.
 *
 * @access public
 * @param mixed $author_ID (default: null)
 * @return void
 */
function get_author_complete_name($author_ID = null){
	$author_info = get_userdata($author_ID);
	$author_name = $author_info->display_name;
	return $author_name;
}

/**
 * get_iphone_non_retina_icon function.
 *
 * @access public
 * @return void
 */
function get_iphone_non_retina_icon() {
	$options = get_theme_options();
	return $options['apple_touch_icon_iphone_non_retina'];
}

/**
 * get_iphone_retina_icon function.
 *
 * @access public
 * @return void
 */
function get_iphone_retina_icon() {
	$options = get_theme_options();
	return $options['apple_touch_icon_iphone_retina'];
}

/**
 * get_ipad_non_retina_icon function.
 *
 * @access public
 * @return void
 */
function get_ipad_non_retina_icon() {
	$options = get_theme_options();
	return $options['apple_touch_icon_ipad_non_retina'];
}

/**
 * get_ipad_retina_icon function.
 *
 * @access public
 * @return void
 */
function get_ipad_retina_icon() {
	$options = get_theme_options();
	return $options['apple_touch_icon_ipad_retina'];
}

/**
 * create_short_url function.
 *
 * Creates a Short Url for the Post
 *
 * @access private
 * @param mixed $post_ID (default: null)
 * @return void
 */
function create_short_url($post_ID = null){
	$longURL = home_url().'?p='.$post_ID;

	$shortURL = null;
	if( is_bitly_information_set() ) {
		$options = get_theme_options();

		$login = $options['bitly_username'];
		$apikey = $options['bitly_api_key'];

		$shortURL = get_bitly_url($longURL, $login, $apikey);
	} else {
		$shortURL = $longURL;
	}

	// adding the short URL to a custom field called bitlyURL
	update_post_meta($post_ID, 'bitlyURL', $shortURL);
}

/**
 * is_bitly_information_set function.
 *
 * Return if the Bit.ly Information is set
 *
 * @access private
 * @return void
 */
function is_bitly_information_set(){
	$options = get_theme_options();

	return (
		isset($options['bitly_username']) &&
		isset($options['bitly_api_key']) &&
		!empty($options['bitly_username']) &&
		!empty($options['bitly_api_key'])
	);
}

/**
 * get_bitly_url function.
 *
 * Generate the Bitly Short URL
 *
 * @access private
 * @param mixed $longURL
 * @param mixed $login
 * @param mixed $apikey
 * @return void
 */
function get_bitly_url($longURL, $login, $apikey){

	// This is the API call to fetch the shortened URL
	$apiurl = 'http://api.bit.ly/v3/shorten?longUrl='.urlencode($longURL).'&login='.$login.'&apiKey='.$apikey.'&format=json';

	// Use cURL to return from the API
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_URL, $apiurl);
	$results = json_decode(curl_exec($curl));
	curl_close($curl);

	$shortURL =  $results->data->url;
	return $shortURL;
}

/**
 * extra_contact_info function.
 *
 * Set Extra Contact Information
 *
 * @access public
 * @param mixed $contactmethods
 * @return void
 */
function extra_contact_info($contactmethods) {
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	$contactmethods['facebook'] = 'Facebook';
	$contactmethods['twitter'] = 'Twitter';
	$contactmethods['linkedin'] = 'LinkedIn';
	return $contactmethods;
}

/**
 * return_short_url function.
 *
 * @access public
 * @return void
 */
function return_short_url() {
	global $post;
	$shortURL = get_post_meta($post->ID, 'bitlyURL', true);
	if(isset($shortURL) && !empty($shortURL)) {
		 return $shortURL;
	} else {
		return home_url().'?p='.$post->ID;
	}
}

/**
 * return_short_link function.
 *
 * @access public
 * @return void
 */
function return_short_link(){
	$shortURL = return_short_url();
	global $post;
	$shortLink = '<a rel="shortlink" title="'.$shortURL.'" href="'.$shortURL.'">'.$shortURL.'</a>';
	return $shortLink;
}

/**
 * censored_bar function.
 *
 * @access public
 * @return void
 */
function censored_bar(){
	$options = get_theme_options();

	if($options['censored_bar'] == TRUE){
		?><a style="width:50%;height:77px;vertical-align:middle;text-align:center;background-color:#000;position:absolute;z-index:5555;top:0px;left:0px;background-image:url(http://americancensorship.org/images/stop-censorship-small.png);background-position:center center;background-repeat:no-repeat;margin:0 25%;" href="http://americancensorship.org"></a><?php
	}
}

/**
 * add_to_head function.
 *
 * @access public
 * @return void
 */
function add_to_head(){
	add_stylesheets();
	add_my_open_id_information();
	insert_short_url();
	add_favicons();
	add_meta_tags();
}

/**
 * add_to_sidebar function.
 *
 * @access public
 * @return void
 */
function add_to_sidebar(){
}

/**
 * add_to_footer function.
 *
 * @access public
 * @return void
 */
function add_to_footer(){
	censored_bar();
}

/**
 * add_on_publish function.
 *
 * @access public
 * @param mixed $post_ID
 * @return void
 */
function add_on_publish($post_ID) {
	create_short_url($post_ID);
}

/**
 * get_theme_options function.
 *
 * @access public
 * @return void
 */
function get_theme_options() {
	$options = get_option('erdt_child_theme_options');
	return $options;
}

//Add Filters
add_filter('wp_head', 'add_to_head');
add_filter('wp_sidebar', 'add_to_sidebar');
add_filter('wp_footer', 'add_to_footer');
add_filter('wp_get_shortlink', 'return_short_url');
add_filter('user_contactmethods', 'extra_contact_info');

//Remove Actions
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

//Add Actions
add_action('publish_post', 'add_on_publish');

?>