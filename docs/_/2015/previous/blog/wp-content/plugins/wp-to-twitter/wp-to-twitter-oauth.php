<?php
// WPT PRO: Apply contextual usage so that all functions can be used by independent users. //

// function to test credentials
function wtt_oauth_test( $auth=false, $context='' ) {
	if ( !$auth ) {
		return ( wtt_oauth_credentials_to_hash() == get_option('wtt_oauth_hash') );
	} else {
		$return = ( wtt_oauth_credentials_to_hash( $auth ) == get_user_meta( $auth,'wtt_oauth_hash',true ) );
		if ( !$return && $context != 'verify' ) {
			return ( wtt_oauth_credentials_to_hash() == get_option('wtt_oauth_hash') );
		} else {
			return $return;
		}
	}
}
// function to make connection
function wtt_oauth_connection( $auth=false ) {
if ( !$auth ) {
	$ack = get_option('app_consumer_key');
	$acs = get_option('app_consumer_secret');
	$ot = get_option('oauth_token');
	$ots = get_option('oauth_token_secret');
} else {
	$ack = get_user_meta( $auth,'app_consumer_key',true);
	$acs = get_user_meta( $auth,'app_consumer_secret',true);
	$ot = get_user_meta( $auth,'oauth_token',true);
	$ots = get_user_meta( $auth,'oauth_token_secret',true);
}
	if ( !empty( $ack ) && !empty( $acs ) && !empty( $ot ) && !empty( $ots ) ) {	
		require_once( WP_PLUGIN_DIR . '/wp-to-twitter/jd_twitterOAuth.php' );
		$connection = new jd_TwitterOAuth( $ack,$acs,$ot,$ots );
		$connection->useragent = 'WP to Twitter http://www.joedolson.com/articles/wp-to-twitter';
		return $connection;
	} else {
		return false;
	}
}

// convert credentials to md5 hash
function wtt_oauth_credentials_to_hash( $auth=false ) {
	if ( !$auth ) {
		$hash = md5(get_option('app_consumer_key').get_option('app_consumer_secret').get_option('oauth_token').get_option('oauth_token_secret'));
	} else {
		$hash = md5( get_user_meta( $auth,'app_consumer_key',true ). get_user_meta( $auth,'app_consumer_secret',true ). get_user_meta( $auth,'oauth_token',true ). get_user_meta( $auth,'oauth_token_secret',true ) );
	}
	return $hash;		
}
// response to settings updates
function jd_update_oauth_settings( $auth=false, $post=false ) {
switch ( $post['oauth_settings'] ) {
	case 'wtt_oauth_test':
			if ( !wp_verify_nonce( $post['_wpnonce'], 'wp-to-twitter-nonce' ) && !$auth ) {
				wp_die('Oops, please try again.');
			}
			$auth_test = false;
			if ( !empty($post['wtt_app_consumer_key'])
				&& !empty($post['wtt_app_consumer_secret'])
				&& !empty($post['wtt_oauth_token'])
				&& !empty($post['wtt_oauth_token_secret'])
			) {
				$ack = trim($post['wtt_app_consumer_key']);
				$acs = trim($post['wtt_app_consumer_secret']);
				$ot = trim($post['wtt_oauth_token']);
				$ots =trim($post['wtt_oauth_token_secret']);
				if ( !$auth ) {
					update_option('app_consumer_key',$ack);
					update_option('app_consumer_secret',$acs);
					update_option('oauth_token',$ot);
					update_option('oauth_token_secret',$ots);
				} else {
					update_user_meta( $auth,'app_consumer_key',$ack);
					update_user_meta( $auth,'app_consumer_secret',$acs);
					update_user_meta( $auth,'oauth_token',$ot);
					update_user_meta( $auth,'oauth_token_secret',$ots);				
				}
				$message = 'failed';
				if ( $connection = wtt_oauth_connection( $auth ) ) {
					$protocol = ( get_option( 'wpt_http' ) == '1' )?'http:':'https:';
					$data = $connection->get($protocol.'//api.twitter.com/1/account/verify_credentials.json');
					if ($connection->http_code == '200') {
						$error_information = '';
						$decode = json_decode($data);
						if ( !$auth ) { 
							update_option( 'wtt_twitter_username', stripslashes( $decode->screen_name ) );
						} else {
							update_user_meta( $auth,'wtt_twitter_username', stripslashes( $decode->screen_name ) );
						}
						$oauth_hash = wtt_oauth_credentials_to_hash( $auth );
						if ( !$auth ) {
							update_option( 'wtt_oauth_hash', $oauth_hash );
						} else {
							update_user_meta( $auth,'wtt_oauth_hash',$oauth_hash );
						}
						$message = 'success';
						delete_option( 'wpt_curl_error' );
					} else if ( $connection->http_code == 0 ) {
						$error_information = __("WP to Twitter was unable to establish a connection to Twitter.",'wp-to-twitter'); 
						update_option( 'wpt_curl_error',$error_information );
					} else {
						$error_information = array("http_code"=>$connection->http_code,"status"=>$connection->http_header['status']);
						$error_code = __("Twitter response: http_code $error_information[http_code] - $error_information[status]",'wp-to-twitter');
						update_option( 'wpt_curl_error',$error_code );
					}
					if ( get_option('wp_debug_oauth') == '1' ) {
						echo "<pre><strong>Summary Connection Response:</strong><br />";
							print_r($error_information);
						echo "<br /><strong>Account Verification Data:</strong><br />";
							print_r($data);
						echo "<br /><strong>Full Connection Response:</strong><br />";
							print_r($connection);
						echo "</pre>";
					}
				}
			} else {
				$message = "nodata";
			}
			if ( $message == 'failed' && ( time() < strtotime( $connection->http_header['date'] )-300 || time() > strtotime( $connection->http_header['date'] )+300 ) ) {
				$message = 'nosync';
			}
			return $message;
		break;
		case 'wtt_twitter_disconnect':
			if ( !wp_verify_nonce($post['_wpnonce'], 'wp-to-twitter-nonce') && !$auth ) {
				wp_die('Oops, please try again.');
			}
			if ( !$auth ) {
				update_option('app_consumer_key', '');
				update_option('app_consumer_secret', '');
				update_option('oauth_token', '');
				update_option('oauth_token_secret', '');
			} else {
				delete_user_meta( $auth, 'app_consumer_key' );
				delete_user_meta( $auth, 'app_consumer_secret' );
				delete_user_meta( $auth, 'oauth_token' );
				delete_user_meta( $auth, 'oauth_token_secret' );
			}
			$message = "cleared";
			return $message;
		break;
	}
	return "Nothing";
}

// connect or disconnect form
function wtt_connect_oauth( $auth=false ) {
if ( !$auth ) {
	echo '<div class="ui-sortable meta-box-sortables">';
	echo '<div class="postbox">';
}
$server_time = date( DATE_COOKIE );
$protocol = ( get_option( 'wpt_http' ) == '1' )?'http:':'https:';
$response = wp_remote_get( "$protocol//api.twitter.com/1/" );
if ( is_wp_error( $response ) ) {
	$warning = '';
	$error = $response->errors;
	if ( is_array( $error ) ) {
		$warning = "<ul>";
		foreach ( $error as $k=>$e ) {
			foreach ( $e as $v ) {
				$warning .= "<li>".$v."</li>";
			}
		}
		$warning .= "</ul>";
	}
	if ( strpos( $warning, 'SSL' ) !== false ) { $ssl = __("SSL Problems? Try <a href='#wpt_http'>switching to <code>http</code> queries</a>.<br />",'wp-to-twitter'); } else { $ssl = __('Error Message:','wp-to-twitter'); }
	$date = __("There was an error querying Twitter's servers",'wp-to-twitter');
	$errors = "<p>".$ssl.$warning."</p>";
} else {
	$date = date( DATE_COOKIE, strtotime($response['headers']['date']) );
	$errors = '';
}
$class = ( $auth )?'wpt-profile':'wpt-settings';
$form = ( !$auth )?'<form action="" method="post">':'';
$nonce = ( !$auth )?wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false).'</form>':'';

	if ( !wtt_oauth_test( $auth,'verify' ) ) {
		$ack = ( !$auth )?esc_attr( get_option('app_consumer_key') ):esc_attr( get_user_meta( $auth,'app_consumer_key', true ) );
		$acs = ( !$auth )?esc_attr( get_option('app_consumer_secret') ):esc_attr( get_user_meta( $auth,'app_consumer_secret', true ) );
		$ot = ( !$auth )?esc_attr( get_option('oauth_token') ):esc_attr( get_user_meta( $auth,'oauth_token', true ) );
		$ots = ( !$auth )?esc_attr( get_option('oauth_token_secret') ):esc_attr( get_user_meta( $auth,'oauth_token_secret', true ) );
	
		$submit = ( !$auth )?'<p class="submit"><input type="submit" name="submit" class="button-primary" value="'.__('Connect to Twitter', 'wp-to-twitter').'" /></p>':'';
		print('	
			<h3>'.__('Connect to Twitter','wp-to-twitter').'</h3>
			<div class="inside '.$class.'">
			<div class="notes">
			<h4>'.__('WP to Twitter Set-up','wp-to-twitter').'</h4>
			<p>'.__('Your server time:','wp-to-twitter').' <code>'.$server_time.'</code> '.__("Twitter's time:").' <code>'.$date.'</code>.'.__( 'If these timestamps are not within 5 minutes of each other, your server will not connect to Twitter.','wp-to-twitter').'</p>
			'.$errors.'
			<p>'.__('<em>Note</em>: you will not add your Twitter user information to WP to Twitter; it is not used in this authentication method.', 'wp-to-twitter').'</p> 
			</div>
			'.$form.'
				<fieldset class="options">
					<h4>'.__('1. Register this site as an application on ', 'wp-to-twitter') . '<a href="http://dev.twitter.com/apps/new" target="_blank">'.__('Twitter\'s application registration page','wp-to-twitter').'</a></h4>
						<ul>
						<li>'.__('If you\'re not currently logged in to Twitter, log-in to the account you want associated with this site' , 'wp-to-twitter').'</li>
						<li>'.__('Your Application\'s Name will show up after "via" in your twitter stream. Your application name cannot include the word "Twitter."' , 'wp-to-twitter').'</li>
						<li>'.__('Your Application Description can be anything.','wp-to-twitter').'</li>
						<li>'.__('The WebSite and Callback URL should be ' , 'wp-to-twitter').'<strong>'.  get_bloginfo( 'url' ) .'</strong></li>					
						</ul>
					<p><em>'.__('Agree to the Developer Rules of the Road and continue.','wp-to-twitter').'</em></p>
					<h4>'.__('2. Switch to the "Settings" tab in Twitter apps','wp-to-twitter').'</h4>
						<ul>
						<li>'.__('Select "Read and Write" for the Application Type' , 'wp-to-twitter').'</li>
						<li>'.__('Update the application settings' , 'wp-to-twitter').'</li>
						<li>'.__('Return to the Details tab and create your access token. Refresh page to view your access tokens.','wp-to-twitter').'</li>		
						</ul>	
					<p><em>'.__('Once you have registered your site as an application, you will be provided with four keys.' , 'wp-to-twitter').'</em></p>
					<h4>'.__('3. Copy and paste your consumer key and consumer secret into the fields below' , 'wp-to-twitter').'</h4>
					<div class="tokens">
					<p>
						<label for="wtt_app_consumer_key">'.__('Twitter Consumer Key', 'wp-to-twitter').'</label>
						<input type="text" size="45" name="wtt_app_consumer_key" id="wtt_app_consumer_key" value="'.$ack.'" />
					</p>
					<p>
						<label for="wtt_app_consumer_secret">'.__('Twitter Consumer Secret', 'wp-to-twitter').'</label>
						<input type="text" size="45" name="wtt_app_consumer_secret" id="wtt_app_consumer_secret" value="'.$acs.'" />
					</p>
					</div>
					<h4>'.__('4. Copy and paste your Access Token and Access Token Secret into the fields below','wp-to-twitter').'</h4>
					<p>'.__('If the Access level for your Access Token is not "<em>Read and write</em>", you must return to step 2 and generate a new Access Token.','wp-to-twitter').'</p>
					<div class="tokens">
					<p>
						<label for="wtt_oauth_token">'.__('Access Token', 'wp-to-twitter').'</label>
						<input type="text" size="45" name="wtt_oauth_token" id="wtt_oauth_token" value="'.$ot.'" />
					</p>
					<p>
						<label for="wtt_oauth_token_secret">'.__('Access Token Secret', 'wp-to-twitter').'</label>
						<input type="text" size="45" name="wtt_oauth_token_secret" id="wtt_oauth_token_secret" value="'.$ots.'" />
					</p>
					</div>
				</fieldset>
				'.$submit.'
				<input type="hidden" name="oauth_settings" value="wtt_oauth_test" class="hidden" style="display: none;" />
				'.$nonce.'
			</div>	
				');
	} else if ( wtt_oauth_test( $auth ) ) {
		$ack = ( !$auth )?esc_attr( get_option('app_consumer_key') ):esc_attr( get_user_meta( $auth,'app_consumer_key', true ) );
		$acs = ( !$auth )?esc_attr( get_option('app_consumer_secret') ):esc_attr( get_user_meta( $auth,'app_consumer_secret', true ) );
		$ot = ( !$auth )?esc_attr( get_option('oauth_token') ):esc_attr( get_user_meta( $auth,'oauth_token', true ) );
		$ots = ( !$auth )?esc_attr( get_option('oauth_token_secret') ):esc_attr( get_user_meta( $auth,'oauth_token_secret', true ) );
		$uname = ( !$auth )?esc_attr( get_option('wtt_twitter_username') ):esc_attr( get_user_meta( $auth,'wtt_twitter_username', true ) );
		$nonce = ( !$auth )?wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false).'</form>':'';
		if ( !$auth ) {
			$submit = '
					<input type="submit" name="submit" class="button-primary" value="'.__('Disconnect Your WordPress and Twitter Account', 'wp-to-twitter').'" />
					<input type="hidden" name="oauth_settings" value="wtt_twitter_disconnect" class="hidden" />
				';					
		} else {
			$submit = '<input type="checkbox" name="oauth_settings" value="wtt_twitter_disconnect" id="disconnect" /> <label for="disconnect">'.__('Disconnect your WordPress and Twitter Account','wp-to-twitter').'</label>';
		}
		$warning =  ( get_option('wpt_authentication_missing') == 'true' )?'<p>'.__('<strong>Troubleshooting tip:</strong> Connected, but getting a notice that your Authentication credentials are missing or incorrect? Check whether your Access token has read and write permission. If not, you\'ll need to create a new token.','wp-to-twitter').'</p>':'';
		$diff = ( abs( time() - strtotime($response['headers']['date']) ) > 300 )?'<p> '.__( 'Your time stamps are more than 5 minutes apart. Your server could lose its connection with Twitter.','wp-to-twitter').'</p>':'';

		print('	
			<h3>'.__('Disconnect from Twitter','wp-to-twitter').'</h3>
			<div class="inside '.$class.'">
			'.$form.'
				<div id="wtt_authentication_display">
					<fieldset class="options">
					<ul>
						<li><strong class="auth_label">'.__('Twitter Username ', 'wp-to-twitter').'</strong> <code class="auth_code">'.$uname.'</code></li>
						<li><strong class="auth_label">'.__('Consumer Key ', 'wp-to-twitter').'</strong> <code class="auth_code">'.$ack.'</code></li>
						<li><strong class="auth_label">'.__('Consumer Secret ', 'wp-to-twitter').'</strong> <code class="auth_code">'.$acs.'</code></li>
						<li><strong class="auth_label">'.__('Access Token ', 'wp-to-twitter').'</strong> <code class="auth_code">'.$ot.'</code></li>
						<li><strong class="auth_label">'.__('Access Token Secret ', 'wp-to-twitter').'</strong> <code class="auth_code">'.$ots.'</code></li>
					</ul>
					</fieldset>
					<div>
					'.$submit.'
					</div>
				</div>		
				'.$nonce.'
			<p>'.__('Your server time:','wp-to-twitter').' <code>'.$server_time.'</code>.<br />'.__('Twitter\'s current server time: ','wp-to-twitter').'<code>'.$date.'</code>.</p>
			'.$errors.$diff.'</div>' );
	}
	if ( !$auth ) {
		echo "</div>";
		echo "</div>";
	}
}