<?php
// Adapted from http://planetozh.com/blog/2009/05/handling-plugins-options-in-wordpress-28-with-register_setting/

add_action( 'admin_init', 'theme_options_init' );
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * Init plugin options to white list our options
 */
function theme_options_init(){
	register_setting( 'erdt_child_options', 'erdt_child_theme_options', 'theme_options_validate' );
}

/**
 * Load up the menu page
 */
function theme_options_add_page() {
	add_theme_page( __( 'Erudite Child Theme Options', 'erudite_child' ), __( 'Erudite Child Theme Options', 'erudite_child' ), 'edit_theme_options', 'theme_options', 'theme_options_do_page' );
}

/**
 * Create the options page
 */
function theme_options_do_page() {
	global $select_options, $radio_options;

	if ( ! isset( $_REQUEST['updated'] ) )
		$_REQUEST['updated'] = false;

	?>
	<div class="wrap">
		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'erudite_child' ) . "</h2>"; ?>

		<?php if ( false !== $_REQUEST['updated'] ) : ?>
		<div class="updated fade"><p><strong><?php _e( 'Options saved', 'erudite_child' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'erdt_child_options' ); ?>
			<?php $options = get_option( 'erdt_child_theme_options' ); ?>
			<h2>Social Media Links</h2>
			<table class="form-table">
				<tr valign="top"><th scope="row"><?php _e( 'Bit.ly Username', 'erudite_child' ); ?></th>
					<td>
						<input id="erdt_child_theme_options[bitly_username]" class="regular-text" type="text" name="erdt_child_theme_options[bitly_username]" value="<?php esc_attr_e( $options['bitly_username'] ); ?>" />
						<label class="description" for="erdt_child_theme_options[bitly_username]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly Username">Bit.ly Username</a>', 'erudite_child' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Bit.ly API Key', 'erudite_child' ); ?></th>
					<td>
						<input id="erdt_child_theme_options[bitly_api_key]" class="regular-text" type="text" name="erdt_child_theme_options[bitly_api_key]" value="<?php esc_attr_e( $options['bitly_api_key'] ); ?>" />
						<label class="description" for="erdt_child_theme_options[bitly_api_key]"><?php _e( 'Enter your <a href="http://bit.ly/a/your_api_key" target="_blank" title="Get your Bit.ly API Key">Bit.ly API Key</a>', 'erudite_child' ); ?></label>
					</td>
				</tr>

				<tr valign="top"><th scope="row"><?php _e( 'Open ID Server URL', 'erudite_child' ); ?></th>
					<td>
						<input id="erdt_child_theme_options[open_id_server]" class="regular-text" type="text" name="erdt_child_theme_options[open_id_server]" value="<?php esc_attr_e( $options['open_id_server'] ); ?>" />
						<label class="description" for="erdt_child_theme_options[open_id_server]"><?php _e( 'Enter in your OpenID Server URL, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://www.myopenid.com/server/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', 'erudite_child' ); ?></label>
					</td>
				</tr>
				<tr valign="top"><th scope="row"><?php _e( 'OpenID Delegate URL', 'erudite_child' ); ?></th>
					<td>
						<input id="erdt_child_theme_options[open_id_delegate]" class="regular-text" type="text" name="erdt_child_theme_options[open_id_delegate]" value="<?php esc_attr_e( $options['open_id_delegate'] ); ?>" />
						<label class="description" for="erdt_child_theme_options[open_id_delegate]"><?php _e( 'Enter in your OpenID Delegate Url, to use your site\'s url as a delegate server. For example if using MyOpenId, enter in http://{username}.myopenid.com/. More info here: <a href="http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication" target="_blank" title="OpenID Delegate Server">http://openid.net/specs/openid-authentication-1_1.html#delegating_authentication</a>', 'erudite_child' ); ?></label>
					</td>
				</tr>

			</table>

			<h2>Meta Settings</h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 57x57', 'erudite_child' ); ?></th>
						<td>
							<input id="erdt_child_theme_options[apple_touch_icon_iphone_non_retina]" class="regular-checkbox" type="checkbox" name="erdt_child_theme_options[apple_touch_icon_iphone_non_retina]" value="1" <?php if($options['apple_touch_icon_iphone_non_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="erdt_child_theme_options[apple_touch_icon_iphone_non_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 57x57 pixels, in the webroot directory and named apple-touch-icon-57x57-precomposed.png). Sized for the iPhone Non-Retina Screen.', 'erudite_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 114x114', 'erudite_child' ); ?></th>
						<td>
							<input id="erdt_child_theme_options[apple_touch_icon_iphone_retina]" class="regular-checkbox" type="checkbox" name="erdt_child_theme_options[apple_touch_icon_iphone_retina]" value="1" <?php if($options['apple_touch_icon_iphone_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="erdt_child_theme_options[apple_touch_icon_iphone_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 114x114 pixels, in the webroot directory and named apple-touch-icon-114x114-precomposed.png). Sized for the iPhone Retina Screen.', 'erudite_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 72x72', 'erudite_child' ); ?></th>
						<td>
							<input id="erdt_child_theme_options[apple_touch_icon_ipad_non_retina]" class="regular-checkbox" type="checkbox" name="erdt_child_theme_options[apple_touch_icon_ipad_non_retina]" value="1" <?php if($options['apple_touch_icon_ipad_non_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="erdt_child_theme_options[apple_touch_icon_ipad_non_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 72x72 pixels, in the webroot directory and named apple-touch-icon-72x72-precomposed.png). Sized for the iPad Non-Retina Screen.', 'erudite_child' ); ?></label>
						</td>
					</tr>
					<tr valign="top"><th scope="row"><?php _e( 'Apple Touch Icon - 144x144', 'erudite_child' ); ?></th>
						<td>
							<input id="erdt_child_theme_options[apple_touch_icon_ipad_retina]" class="regular-checkbox" type="checkbox" name="erdt_child_theme_options[apple_touch_icon_ipad_retina]" value="1" <?php if($options['apple_touch_icon_ipad_retina'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="erdt_child_theme_options[apple_touch_icon_ipad_retina]"><?php _e( 'Turn on the Apple Touch icon (Should be 144x144 pixels, in the webroot directory and named apple-touch-icon-144x144-precomposed.png). Sized for the iPad Retina Screen.', 'erudite_child' ); ?></label>
						</td>
					</tr>
				</table>

			<h2>Other Settings</h2>
				<table class="form-table">
					<tr valign="top"><th scope="row"><?php _e( 'Censored Website Bar', 'erudite_child' ); ?></th>
						<td>
							<input id="erdt_child_theme_options[censored_bar]" class="regular-checkbox" type="checkbox" name="erdt_child_theme_options[censored_bar]" value="1" <?php if($options['censored_bar'] == TRUE): ?> checked <?php endif; ?> />
							<label class="description" for="erdt_child_theme_options[censored_bar]"><?php _e( 'Turn on the <a href="http://americancensorship.org/" title="American Censorship Day">Censored Website Bar</a>', 'erudite_child' ); ?></label>
						</td>
					</tr>
				</table>


			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'erudite_child' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

/**
 * Sanitize and validate input. Accepts an array, return a sanitized array.
 */
function theme_options_validate( $input ) {

	//Sanitize Input Text
	$input['bitly_username'] = wp_filter_nohtml_kses( $input['bitly_username'] );
	$input['bitly_api_key'] = wp_filter_nohtml_kses( $input['bitly_api_key'] );
	$input['open_id_server'] = wp_filter_nohtml_kses( $input['open_id_server'] );
	$input['open_id_delegate'] = wp_filter_nohtml_kses( $input['open_id_delegate'] );

	if ( ! isset( $input['censored_bar'] ) )
		$input['censored_bar'] = null;
	$input['censored_bar'] = ( $input['censored_bar'] == 1 ? 1 : 0 );

	/*
	// Our checkbox value is either 0 or 1
	if ( ! isset( $input['option1'] ) )
		$input['option1'] = null;
	$input['option1'] = ( $input['option1'] == 1 ? 1 : 0 );

	// Say our text option must be safe text with no HTML tags
	$input['sometext'] = wp_filter_nohtml_kses( $input['sometext'] );

	// Our select option must actually be in our array of select options
	if ( ! array_key_exists( $input['selectinput'], $select_options ) )
		$input['selectinput'] = null;

	// Our radio option must actually be in our array of radio options
	if ( ! isset( $input['radioinput'] ) )
		$input['radioinput'] = null;
	if ( ! array_key_exists( $input['radioinput'], $radio_options ) )
		$input['radioinput'] = null;

	// Say our textarea option must be safe text with the allowed tags for posts
	$input['sometextarea'] = wp_filter_post_kses( $input['sometextarea'] );
	*/

	return $input;
}