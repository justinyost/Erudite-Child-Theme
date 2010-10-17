<?php
//Define the Child Template Directory
define('CHILD_TEMPLATE_DIR', get_stylesheet_directory() );

require_once(CHILD_TEMPLATE_DIR."/library/theme-options.php");

// Add stylesheets
function _add_stylesheets() {
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo CHILD_TEMPLATE_DIR; ?>/css/erudite-child.css" />
	<?php
}

//Adds MyOpen ID Information to act as a delegate server
function _add_my_open_id_information(){
	$options = get_theme_options();
	
	if(isset($options['my_open_id_url']) && !is_null($options['my_open_id_url'])):
		?>
		<link rel="openid.server" href="http://www.myopenid.com/server">
		<link rel="openid.delegate" href="<?php echo $options['my_open_id_url']; ?>">
		<?php
	else:
	endif;
}

function _add_favicons(){
	?>
	<link href="<?php echo get_bloginfo('url'); ?>/favicon.ico" rel="shortcut icon">
	<?php
}

//Add the Bit.ly Short URL or fallback to using the generic Wordpress Short URL
function _insert_short_url(){
	global $post;
	if(is_single()){
		$shortURL = return_short_url();
		?>
		<link rel="shortlink" href="<?php echo $shortURL; ?>" />
		<?php
	}
}

//Create a Short URL
function _create_short_url($post_ID = null){	
	$longURL = get_bloginfo('url').'?p='.$post_ID;
	
	$options = get_theme_options();
	
	if(isset($options['bitly_username']) && isset($options['bitly_api_key']) && !is_null($options['bitly_username']) && !is_null($options['bitly_api_key'])){
		$login = $options['bitly_username'];
		$apikey = $options['bitly_api_key'];
		$shortURL = _get_bitly_url($longURL, $login, $apikey);
	} else {
		$shortURL = $longURL;
	}
	
	// adding the short URL to a custom field called bitlyURL
	update_post_meta($post_ID, 'bitlyURL', $shortURL);
}

//Generate the Bitly Short URL
function _get_bitly_url($longURL, $login, $apikey){
	
	// This is the API call to fetch the shortened URL
	$apiurl = 'http://api.bit.ly/v3/shorten?longUrl='.urlencode($longURL).'&login='.$login.'&apiKey='.$apikey.'&format=json';
 
	// Use cURL to return from the API
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_URL, $apiurl);
	$results = json_decode(curl_exec($curl));
	curl_close($curl);
 
	$shortURL =  $results->data->url; // the short URL
}

//Return the Short URL
function return_short_url() {
	global $post;
	$shortURL = get_post_meta($post->ID, 'bitlyURL', true);
	if(isset($shortURL) && !empty($shortURL)) {
		 return $shortURL;
	} else {
		return get_bloginfo('url').'?p='.$post->ID;
	}
}

//Return the Short Link
function return_short_link(){
	$shortURL = return_short_url();
	global $post;
	$shortLink = '<a rel="shortlink" title="'.$shortURL.'" href="'.$shortURL.'">'.$shortURL.'</a>';
	return $shortLink;
}

//Add Generic stuff to the head
function add_to_head(){
	_add_stylesheets();
	_add_my_open_id_information();
	_insert_short_url();
	_add_favicons();
}

//Add Generic stuff to the sidebar
function add_to_sidebar(){
	_display_short_url();
}

//Add Generic stuff to the footer
function add_to_footer(){
}

function add_on_publish($post_ID){
	_create_short_url($post_ID);
}

function get_theme_options(){
	$options = get_option('erdt_child_theme_options');
	return $options;
}

//Add Filters
add_filter('wp_head', 'add_to_head');
add_filter('wp_sidebar', 'add_to_sidebar');
add_filter('wp_footer', 'add_to_footer');
add_filter('wp_get_shortlink', 'return_short_url');

//Remove Actions
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0 );

//Add Actions
add_action('publish_post', 'add_on_publish');

?>
