<?php
// FUNCTION to see if checkboxes should be checked
function jd_checkCheckbox( $theFieldname,$sub1=false,$sub2='' ) {
	if ( $sub1 ) {
		$setting = get_option($theFieldname);
		if ( isset( $setting[$sub1] ) ) {
			$value = ( $sub2 != '' )?$setting[$sub1][$sub2]:$setting[$sub1];
		} else {
			$value = 0;
		}
		if ( $value == 1 ) {
			return 'checked="checked"';
		}
	}
	if( get_option( $theFieldname ) == '1'){
		return 'checked="checked"';
	}
}

function jd_checkSelect( $theFieldname, $theValue, $type='select' ) {
	if( get_option( $theFieldname ) == $theValue ) {
		echo ( $type == 'select' )?'selected="selected"':'checked="checked"';
	}
}

function jd_check_functions() {
	$message = "<div class='update'><ul>";
	// grab or set necessary variables
	$testurl =  get_bloginfo( 'url' );
	$shortener = get_option( 'jd_shortener' );
	$title = urlencode( 'Your blog home' );
	$shrink = jd_shorten_link( $testurl, $title, false, 'true' );
	$api_url = $jdwp_api_post_status;
	$yourls_URL = "";
	if ($shrink == FALSE) {
		if ($shortener == 1) {
			$error = htmlentities( get_option('wp_supr_error') );
		} else if ( $shortener == 2 ) {
			$error = htmlentities( get_option('wp_bitly_error') );
		} else {
			$error = _('No error information is available for your shortener.','wp-to-twitter');
		}	
		$message .= __("<li class=\"error\"><strong>WP to Twitter was unable to contact your selected URL shortening service.</strong></li>",'wp-to-twitter');
		$message .= "<li><code>$error</code></li>";
	} else {
		$message .= __("<li><strong>WP to Twitter successfully contacted your selected URL shortening service.</strong>  The following link should point to your blog homepage:",'wp-to-twitter');
		$message .= " <a href='$shrink'>$shrink</a></li>";	
	}
	//check twitter credentials
	if ( wtt_oauth_test() ) {
		$rand = rand(1000000,9999999);
		$testpost = jd_doTwitterAPIPost( "This is a test of WP to Twitter. $shrink ($rand)" );
			if ($testpost) {
				$message .= __("<li><strong>WP to Twitter successfully submitted a status update to Twitter.</strong></li>",'wp-to-twitter'); 
			} else {
				$error = get_option('jd_status_message');
				$message .=	__("<li class=\"error\"><strong>WP to Twitter failed to submit an update to Twitter.</strong></li>",'wp-to-twitter'); 
				$message .= "<li class=\"error\">$error</li>";
				}
	} else {
		$message .= "<strong>"._e('You have not connected WordPress to Twitter.','wp-to-twitter')."</strong> ";
	}
		// If everything's OK, there's  no reason to do this again.	
		if ($testpost == FALSE && $shrink == FALSE  ) {
			$message .= __("<li class=\"error\"><strong>Your server does not appear to support the required methods for WP to Twitter to function.</strong> You can try it anyway - these tests aren't perfect.</li>", 'wp-to-twitter');
		} else { 
		}
	if ( $testpost && $shrink ) {
	$message .= __("<li><strong>Your server should run WP to Twitter successfully.</strong></li>", 'wp-to-twitter');
	}
	$message .= "</ul>
	</div>";
	return $message;
}

function wpt_update_settings() {
	wpt_check_version();
	if ( !empty($_POST) ) {
		$nonce=$_REQUEST['_wpnonce'];
		if (! wp_verify_nonce($nonce,'wp-to-twitter-nonce') ) die("Security check failed");  
	}
	
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'clear-error' ) {
		update_option( 'wp_twitter_failure','0' );
		update_option( 'wp_url_failure','0' );
		update_option( 'jd_status_message','');
		$message =  __("WP to Twitter Errors Cleared", 'wp-to-twitter');
	}
	
	if ( isset($_POST['oauth_settings'] ) ) {
		$oauth_message = jd_update_oauth_settings( false, $_POST );
	}

	$wp_twitter_error = FALSE;
	$wp_supr_error = FALSE;
	$wp_bitly_error = FALSE;
	$message = "";

	// SET DEFAULT OPTIONS
	if ( get_option( 'twitterInitialised') != '1' ) {
		$initial_settings = array( 
			'post'=> array( 
					'post-published-update'=>1,
					'post-published-text'=>'New post: #title# #url#',
					'post-edited-update'=>1,
					'post-edited-text'=>'Post Edited: #title# #url#'
					),
			'page'=> array( 
					'post-published-update'=>0,
					'post-published-text'=>'New page: #title# #url#',
					'post-edited-update'=>0,
					'post-edited-text'=>'Page edited: #title# #url#'
					)
			);
		update_option( 'wpt_post_types', $initial_settings );
		update_option( 'jd_twit_blogroll', '1');
		update_option( 'newlink-published-text', 'New link: #title# #url#' );
		update_option( 'comment-published-update', 0 );
		update_option( 'comment-published-text', 'New comment: #title# #url#' );				
		update_option( 'limit_categories','0' );
		update_option( 'jd_shortener', '1' );
		update_option( 'jd_strip_nonan', '0' );
		update_option('jd_max_tags',3);
		update_option('jd_max_characters',15);	
		update_option('jd_replace_character','_');
		update_option('wtt_user_permissions','administrator');
		$administrator = get_role('administrator');
		$administrator->add_cap('wpt_twitter_oauth');
		$administrator->add_cap('wpt_twitter_custom');
		$administrator->add_cap('wpt_twitter_switch');
		update_option('wtt_show_custom_tweet','administrator');

		update_option( 'jd_twit_remote', '0' );
		update_option( 'jd_post_excerpt', 30 );
		// Use Google Analytics with Twitter
		update_option( 'twitter-analytics-campaign', 'twitter' );
		update_option( 'use-twitter-analytics', '0' );
		update_option( 'jd_dynamic_analytics','0' );		
		update_option( 'use_dynamic_analytics','category' );			
		// Use custom external URLs to point elsewhere. 
		update_option( 'jd_twit_custom_url', 'external_link' );	
		// Error checking
		update_option( 'wp_twitter_failure','0' );
		update_option( 'wp_url_failure','0' );
		// Default publishing options.
		update_option( 'jd_tweet_default', '0' );
		update_option( 'je_tweet_default_edit','0' );
		update_option( 'wpt_inline_edits', '0' );
		// Note that default options are set.
		update_option( 'twitterInitialised', '1' );	
		//YOURLS API
		update_option( 'jd_keyword_format', '0' );
	}
	if ( get_option( 'twitterInitialised') == '1' && get_option( 'jd_post_excerpt' ) == "" ) { 
		update_option( 'jd_post_excerpt', 30 );
	}

// notifications from oauth connection		
    if ( isset($_POST['oauth_settings'] ) ) {
		if ( $oauth_message == "success" ) {
			print('
				<div id="message" class="updated fade">
					<p>'.__('WP to Twitter is now connected with Twitter.', 'wp-to-twitter').'</p>
				</div>

			');
		} else if ( $oauth_message == "fail" ) {
			print('
				<div id="message" class="updated fade">
					<p>'.__('WP to Twitter failed to connect with Twitter. Try enabling OAuth debugging.', 'wp-to-twitter').'</p>
				</div>

			');
		} else if ( $oauth_message == "cleared" ) {
			print('
				<div id="message" class="updated fade">
					<p>'.__('OAuth Authentication Data Cleared.', 'wp-to-twitter').'</p>
				</div>

			');		
		} else  if ( $oauth_message == 'nosync' ) {
			print('
				<div id="message" class="error fade">
					<p>'.__('OAuth Authentication Failed. Your server time is not in sync with the Twitter servers. Talk to your hosting service to see what can be done.', 'wp-to-twitter').'</p>
				</div>

			');
		} else {
			print('
				<div id="message" class="error fade">
					<p>'.__('OAuth Authentication response not understood.', 'wp-to-twitter').'</p>
				</div>			
			');
		}
	}
		
	if ( isset( $_POST['submit-type'] ) && $_POST['submit-type'] == 'advanced' ) {
		update_option( 'jd_tweet_default', ( isset( $_POST['jd_tweet_default'] ) )?$_POST['jd_tweet_default']:0 );
		update_option( 'jd_tweet_default', ( isset( $_POST['jd_tweet_default'] ) )?$_POST['jd_tweet_default']:0 );		
		update_option( 'wpt_inline_edits', ( isset( $_POST['wpt_inline_edits'] ) )?$_POST['wpt_inline_edits']:0 );		
		update_option( 'jd_twit_remote',( isset( $_POST['jd_twit_remote'] ) )?$_POST['jd_twit_remote']:0 );
		update_option( 'jd_twit_custom_url', $_POST['jd_twit_custom_url'] );
		update_option( 'jd_strip_nonan', ( isset( $_POST['jd_strip_nonan'] ) )?$_POST['jd_strip_nonan']:0 );
		update_option( 'jd_twit_prepend', $_POST['jd_twit_prepend'] );	
		update_option( 'jd_twit_append', $_POST['jd_twit_append'] );
		update_option( 'jd_post_excerpt', $_POST['jd_post_excerpt'] );	
		update_option( 'jd_max_tags',$_POST['jd_max_tags']);
		update_option( 'jd_max_characters',$_POST['jd_max_characters']);	
		update_option( 'jd_replace_character',$_POST['jd_replace_character']);
		update_option( 'jd_date_format',$_POST['jd_date_format'] );	
		update_option( 'jd_dynamic_analytics',$_POST['jd-dynamic-analytics'] );		
		update_option( 'use_dynamic_analytics',( isset( $_POST['use-dynamic-analytics'] ) )?$_POST['use-dynamic-analytics']:0 );		
		update_option( 'use-twitter-analytics', ( isset( $_POST['use-twitter-analytics'] ) )?$_POST['use-twitter-analytics']:0 );
		update_option( 'twitter-analytics-campaign', $_POST['twitter-analytics-campaign'] );
		update_option( 'jd_individual_twitter_users', $_POST['jd_individual_twitter_users'] );
		$wtt_user_permissions = $_POST['wtt_user_permissions'];
		$prev = get_option('wtt_user_permissions');
		if ( $wtt_user_permissions != $prev ) {
			$subscriber = get_role('subscriber'); $subscriber->remove_cap('wpt_twitter_oauth');
			$contributor = get_role('contributor'); $contributor->remove_cap('wpt_twitter_oauth');
			$author = get_role('author'); $author->remove_cap('wpt_twitter_oauth');
			$editor = get_role('editor'); $editor->remove_cap('wpt_twitter_oauth');
			switch ( $wtt_user_permissions ) {
				case 'subscriber': $subscriber->add_cap('wpt_twitter_oauth'); $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');   break;
				case 'contributor': $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');  break;
				case 'author': $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth'); break;
				case 'editor':$editor->add_cap('wpt_twitter_oauth'); break;
				default: 
					$role = get_role( $wtt_user_permissions ); 
					$role->add_cap('wpt_twitter_oauth');
				break;
			}
		}
		update_option( 'wtt_user_permissions',$wtt_user_permissions);
		
		$wtt_show_custom_tweet = $_POST['wtt_show_custom_tweet'];
		$prev = get_option('wtt_show_custom_tweet');
		if ( $wtt_show_custom_tweet != $prev ) {
			$subscriber = get_role('subscriber'); $subscriber->remove_cap('wpt_twitter_custom');
			$contributor = get_role('contributor'); $contributor->remove_cap('wpt_twitter_custom');
			$author = get_role('author'); $author->remove_cap('wpt_twitter_custom');
			$editor = get_role('editor'); $editor->remove_cap('wpt_twitter_custom');
			switch ( $wtt_show_custom_tweet ) {
				case 'subscriber': $subscriber->add_cap('wpt_twitter_custom'); $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');   break;
				case 'contributor': $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');  break;
				case 'author': $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom'); break;
				case 'editor':$editor->add_cap('wpt_twitter_custom'); break;
				default: 
					$role = get_role( $wtt_show_custom_tweet ); 
					$role->add_cap('wpt_twitter_custom');
				break;
			}
		}
		update_option( 'wtt_show_custom_tweet',$wtt_show_custom_tweet);
		
		$wpt_twitter_switch = $_POST['wpt_twitter_switch'];
		$prev = get_option('wpt_twitter_switch');
		if ( $wpt_twitter_switch != $prev ) {
			$subscriber = get_role('subscriber'); $subscriber->remove_cap('wpt_twitter_switch');
			$contributor = get_role('contributor'); $contributor->remove_cap('wpt_twitter_switch');
			$author = get_role('author'); $author->remove_cap('wpt_twitter_switch');
			$editor = get_role('editor'); $editor->remove_cap('wpt_twitter_switch');
			switch ( $wpt_twitter_switch ) {
				case 'subscriber': $subscriber->add_cap('wpt_twitter_switch'); $contributor->add_cap('wpt_twitter_switch'); $author->add_cap('wpt_twitter_switch'); $editor->add_cap('wpt_twitter_switch');   break;
				case 'contributor': $contributor->add_cap('wpt_twitter_switch'); $author->add_cap('wpt_twitter_switch'); $editor->add_cap('wpt_twitter_switch');  break;
				case 'author': $author->add_cap('wpt_twitter_switch'); $editor->add_cap('wpt_twitter_switch'); break;
				case 'editor':$editor->add_cap('wpt_twitter_switch'); break;
				default: 
					$role = get_role( $wpt_twitter_switch ); 
					$role->add_cap('wpt_twitter_switch');
				break;
			}
		}
		update_option( 'wpt_twitter_switch',$wpt_twitter_switch);
		
		update_option( 'disable_url_failure' , ( isset( $_POST['disable_url_failure'] ) )?$_POST['disable_url_failure']:0 );
		update_option( 'disable_twitter_failure' , ( isset( $_POST['disable_twitter_failure'] ) )?$_POST['disable_twitter_failure']:0 );
		update_option( 'disable_oauth_notice' , ( isset( $_POST['disable_oauth_notice'] ) )?$_POST['disable_oauth_notice']:0 );
		update_option( 'wp_debug_oauth' , ( isset( $_POST['wp_debug_oauth'] ) )?$_POST['wp_debug_oauth']:0 );
		update_option( 'wpt_http' , ( isset( $_POST['wpt_http'] ) )?$_POST['wpt_http']:0 );
		
		update_option( 'jd_donations' , ( isset( $_POST['jd_donations'] ) )?$_POST['jd_donations']:0 );
		$wpt_truncation_order = $_POST['wpt_truncation_order'];
		update_option( 'wpt_truncation_order', $wpt_truncation_order );
		$message .= __( 'WP to Twitter Advanced Options Updated' , 'wp-to-twitter');
	}
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'options' ) {
		// UPDATE OPTIONS
		$wpt_settings = get_option('wpt_post_types');
		foreach($_POST['wpt_post_types'] as $key=>$value) {
				$array = array( 
					'post-published-update'=>( isset( $value["post-published-update"] ) )?$value["post-published-update"]:"",
					'post-published-text'=>$value["post-published-text"],
					'post-edited-update'=>( isset( $value["post-edited-update"] ) )?$value["post-edited-update"]:"",
					'post-edited-text'=>$value["post-edited-text"]
					);
				$wpt_settings[$key] = $array;
		}
		update_option( 'wpt_post_types', $wpt_settings );
		update_option( 'newlink-published-text', $_POST['newlink-published-text'] );
		update_option( 'jd_twit_blogroll',(isset($_POST['jd_twit_blogroll']) )?$_POST['jd_twit_blogroll']:"" );
		update_option( 'comment-published-text', $_POST['comment-published-text'] );
		update_option( 'comment-published-update',(isset($_POST['comment-published-update']) )?$_POST['comment-published-update']:"" );	
		update_option( 'jd_shortener', $_POST['jd_shortener'] );

		if ( get_option( 'jd_shortener' ) == 2 && ( get_option( 'bitlylogin' ) == "" || get_option( 'bitlyapi' ) == "" ) ) {
			$message .= __( 'You must add your Bit.ly login and API key in order to shorten URLs with Bit.ly.' , 'wp-to-twitter');
			$message .= "<br />";
		}
		if ( get_option( 'jd_shortener' ) == 6 && ( get_option( 'yourlslogin' ) == "" || get_option( 'yourlsapi' ) == "" || get_option( 'yourlsurl' ) == "" ) ) {
			$message .= __( 'You must add your YOURLS remote URL, login, and password in order to shorten URLs with a remote installation of YOURLS.' , 'wp-to-twitter');
			$message .= "<br />";
		}
		if ( get_option( 'jd_shortener' ) == 5 && ( get_option( 'yourlspath' ) == "" ) ) {
			$message .= __( 'You must add your YOURLS server path in order to shorten URLs with a remote installation of YOURLS.' , 'wp-to-twitter');
			$message .= "<br />";
		}		
		$message .= __( 'WP to Twitter Options Updated' , 'wp-to-twitter');
	}

	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'setcategories' ) {
		if ( isset($_POST['jd_twit_cats']) ) { update_option('jd_twit_cats',1); } else { update_option('jd_twit_cats',0); }
		if ( is_array($_POST['categories'])) {
			$categories = $_POST['categories'];
			update_option('limit_categories','1');
			update_option('tweet_categories',$categories);
			$message = __("Category limits updated.");
		} else {
			update_option('limit_categories','0');
			update_option('tweet_categories','');
			$message = __("Category limits unset.",'wp-to-twitter');
		}
	}
		
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'yourlsapi' ) {
		if ( $_POST['yourlsapi'] != '' && isset( $_POST['submit'] ) ) {
			update_option( 'yourlsapi', trim($_POST['yourlsapi']) );
			$message = __("YOURLS password updated. ", 'wp-to-twitter');
		} else if ( isset( $_POST['clear'] ) ) {
			update_option( 'yourlsapi','' );
			$message = __( "YOURLS password deleted. You will be unable to use your remote YOURLS account to create short URLS.", 'wp-to-twitter');
		} else {
			$message = __( "Failed to save your YOURLS password! ", 'wp-to-twitter' );
		}
		if ( $_POST['yourlslogin'] != '' ) {
			update_option( 'yourlslogin', trim($_POST['yourlslogin']) );
			$message .= __( "YOURLS username added. ",'wp-to-twitter' ); 
		}
		if ( $_POST['yourlsurl'] != '' ) {
			update_option( 'yourlsurl', trim($_POST['yourlsurl']) );
			$message .= __( "YOURLS API url added. ",'wp-to-twitter' ); 
		} else {
			update_option('yourlsurl','');
			$message .= __( "YOURLS API url removed. ",'wp-to-twitter' ); 			
		}
		if ( $_POST['yourlspath'] != '' ) {
			update_option( 'yourlspath', trim($_POST['yourlspath']) );	
			if ( file_exists( $_POST['yourlspath'] ) ) {
			$message .= __( "YOURLS local server path added. ",'wp-to-twitter'); 
			} else {
			$message .= __( "The path to your YOURLS installation is not correct. ",'wp-to-twitter' );
			}
		} else {
			update_option( 'yourlspath','' );
			$message .= __( "YOURLS local server path removed. ",'wp-to-twitter');
		}
		if ( $_POST['jd_keyword_format'] != '' ) {
			update_option( 'jd_keyword_format', $_POST['jd_keyword_format'] );
			if ( $_POST['jd_keyword_format'] == 1 ) {
			$message .= __( "YOURLS will use Post ID for short URL slug.",'wp-to-twitter');
			} else {
			$message .= __( "YOURLS will use your custom keyword for short URL slug.",'wp-to-twitter');
			}
		} else {
			update_option( 'jd_keyword_format','' );
			$message .= __( "YOURLS will not use Post ID for the short URL slug.",'wp-to-twitter');
		}
	} 
	
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'suprapi' ) {
		if ( $_POST['suprapi'] != '' && isset( $_POST['submit'] ) ) {
			update_option( 'suprapi', trim($_POST['suprapi']) );
			update_option( 'suprlogin', trim($_POST['suprlogin']) );
			$message = __("Su.pr API Key and Username Updated", 'wp-to-twitter');
		} else if ( isset( $_POST['clear'] ) ) {
			update_option( 'suprapi','' );
			update_option( 'suprlogin','' );
			$message = __("Su.pr API Key and username deleted. Su.pr URLs created by WP to Twitter will no longer be associated with your account. ", 'wp-to-twitter');
		} else {
			$message = __("Su.pr API Key not added - <a href='http://su.pr/'>get one here</a>! ", 'wp-to-twitter');
		}
	} 
	if ( isset($_POST['submit-type']) && $_POST['submit-type'] == 'bitlyapi' ) {
		if ( $_POST['bitlyapi'] != '' && isset( $_POST['submit'] ) ) {
			update_option( 'bitlyapi', trim($_POST['bitlyapi']) );
			$message = __("Bit.ly API Key Updated.", 'wp-to-twitter');
		} else if ( isset( $_POST['clear'] ) ) {
			update_option( 'bitlyapi','' );
			$message = __("Bit.ly API Key deleted. You cannot use the Bit.ly API without an API key. ", 'wp-to-twitter');
		} else {
			$message = __("Bit.ly API Key not added - <a href='http://bit.ly/account/'>get one here</a>! An API key is required to use the Bit.ly URL shortening service.", 'wp-to-twitter');
		}
		if ( $_POST['bitlylogin'] != '' && isset( $_POST['submit'] ) ) {
			update_option( 'bitlylogin', trim($_POST['bitlylogin']) );
			$message .= __(" Bit.ly User Login Updated.", 'wp-to-twitter');
		} else if ( isset( $_POST['clear'] ) ) {
			update_option( 'bitlylogin','' );
			$message = __("Bit.ly User Login deleted. You cannot use the Bit.ly API without providing your username. ", 'wp-to-twitter');
		} else {
			$message = __("Bit.ly Login not added - <a href='http://bit.ly/account/'>get one here</a>! ", 'wp-to-twitter');
		}
	}
	// Check whether the server has supported for needed functions.
	if (  isset($_POST['submit-type']) && $_POST['submit-type'] == 'check-support' ) {
		$message = jd_check_functions();
	}
?>
<div class="wrap" id="wp-to-twitter">
<?php wpt_marginal_function(); ?>
<?php if ( $message ) { ?>
<div id="message" class="updated fade"><?php echo $message; ?></div>
<?php } ?>
<?php if ( get_option( 'wp_twitter_failure' ) != '0' || get_option( 'wp_url_failure' ) == '1' ) { ?>
		<div class="error">
		<?php if ( get_option( 'wp_twitter_failure' ) == '1' ) {
			_e("<p>One or more of your last posts has failed to send a status update to Twitter. The Tweet has been saved, and you can re-Tweet it at your leisure.</p>", 'wp-to-twitter');
		}
		if ( get_option( 'jd_status_message' ) != '' ) {
			echo "<p><strong>".get_option( 'jd_status_message' )."</strong></p>";
		}
		if ( get_option( 'wp_twitter_failure' ) == '2') {
			echo "<p>".__("Sorry! I couldn't get in touch with the Twitter servers to post your <strong>new link</strong>! You'll have to post it manually, I'm afraid. ", 'wp-to-twitter')."</p>";
		}		
		if ( get_option( 'wp_url_failure' ) == '1' ) {
		_e("<p>The query to the URL shortener API failed, and your URL was not shrunk. The full post URL was attached to your Tweet. Check with your URL shortening provider to see if there are any known issues.</p>", 'wp-to-twitter');
		} ?>
		<?php $admin_url = ( is_plugin_active('wp-tweets-pro/wpt-pro-functions.php') )?admin_url('admin.php?page=wp-tweets-pro'):admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php'); ?>
		<form method="post" action="<?php echo $admin_url; ?>">
		<div><input type="hidden" name="submit-type" value="clear-error" /></div>
		<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
		<p><input type="submit" name="submit" value="<?php _e("Clear 'WP to Twitter' Error Messages", 'wp-to-twitter'); ?>" class="button-primary" /></p>
		</form>		
		</div>
<?php
}
?>	
<?php if (isset($_GET['export']) && $_GET['export'] == "settings") { print_settings(); } ?>
<h2><?php _e("WP to Twitter Options", 'wp-to-twitter'); ?></h2>
<div id="wpt_settings_page" class="postbox-container" style="width: 70%">

<?php $wp_to_twitter_directory = get_bloginfo( 'wpurl' ) . '/' . PLUGINDIR . '/' . dirname( plugin_basename(__FILE__) ); ?>
		
<div class="metabox-holder">

<?php if (function_exists('wtt_connect_oauth') ) { wtt_connect_oauth(); } ?>

<?php if (function_exists( 'wpt_pro_functions' ) ) { wpt_pro_functions(); } ?>
<div class="ui-sortable meta-box-sortables">
<div class="postbox">
	
	<h3><?php _e('Basic Settings','wp-to-twitter'); ?></h3>
	<div class="inside">
	<form method="post" action="">
	<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>
	<div>	
		<input type="submit" name="submit" value="<?php _e("Save WP->Twitter Options", 'wp-to-twitter'); ?>" class="button-primary button-side" />	
			<?php 
			$post_types = get_post_types( '', 'names' );
			$wpt_settings = get_option('wpt_post_types');

				foreach( $post_types as $type ) {
					if ( $type == 'attachment' || $type == 'nav_menu_item' || $type == 'revision' ) {
					
					} else {
						$vowels = array( 'a','e','i','o','u' );
						foreach ( $vowels as $vowel ) {
							if ( strpos($type, $vowel ) === 0 ) { $word = 'an'; break; } else { $word = 'a'; }
						}
				?>
			<fieldset class='wpt_types'>
			<legend><?php _e("Settings for type '$type'",'wp-to-twitter' ); ?></legend>
			<p>
				<input type="checkbox" name="wpt_post_types[<?php echo $type; ?>][post-published-update]" id="<?php echo $type; ?>-post-published-update" value="1" <?php echo jd_checkCheckbox('wpt_post_types',$type,'post-published-update')?> />
				<label for="<?php echo $type; ?>-post-published-update"><strong><?php _e("Update when $word $type is published", 'wp-to-twitter'); ?></strong></label> <label for="<?php echo $type; ?>-post-published-text"><br /><?php _e("Text for new $type updates:", 'wp-to-twitter'); ?></label><br /><input type="text" name="wpt_post_types[<?php echo $type; ?>][post-published-text]" id="<?php echo $type; ?>-post-published-text" size="60" maxlength="120" value="<?php if ( isset( $wpt_settings[$type] ) ) { echo esc_attr( stripslashes( $wpt_settings[$type]['post-published-text'] ) ); } ?>" />
			</p>
			<p>
				<input type="checkbox" name="wpt_post_types[<?php echo $type; ?>][post-edited-update]" id="<?php echo $type; ?>-post-edited-update" value="1" <?php echo jd_checkCheckbox('wpt_post_types',$type,'post-edited-update')?> />
				<label for="<?php echo $type; ?>-post-edited-update"><strong><?php _e("Update when $word $type is edited", 'wp-to-twitter'); ?></strong></label><br /><label for="<?php echo $type; ?>-post-edited-text"><?php _e("Text for $type editing updates:", 'wp-to-twitter'); ?></label><br /><input type="text" name="wpt_post_types[<?php echo $type; ?>][post-edited-text]" id="<?php echo $type; ?>-post-edited-text" size="60" maxlength="120" value="<?php if ( isset( $wpt_settings[$type] ) ) { echo esc_attr( stripslashes( $wpt_settings[$type]['post-edited-text'] ) ); } ?>" />	
			</p>
			</fieldset>
			<?php
					}
				} 
			?>
			<fieldset class="comments">
			<legend><?php _e('Settings for Comments','wp-to-twitter'); ?></legend>
			<p>
				<input type="checkbox" name="comment-published-update" id="comment-published-update" value="1" <?php echo jd_checkCheckbox('comment-published-update')?> />
				<label for="comment-published-update"><strong><?php _e("Update Twitter when new comments are posted", 'wp-to-twitter'); ?></strong></label><br />				
				<label for="comment-published-text"><?php _e("Text for new comments:", 'wp-to-twitter'); ?></label> <input type="text" name="comment-published-text" id="comment-published-text" size="60" maxlength="120" value="<?php echo ( esc_attr( stripslashes( get_option( 'comment-published-text' ) ) ) ); ?>" />
			</p>
			<p><?php _e('In addition to the above short tags, comment templates can use <code>#commenter#</code> to post the commenter\'s provided name in the Tweet. <em>Use this feature at your own risk</em>, as it will let anybody who can post a comment on your site post a phrase in your Twitter stream.','wp-to-twitter'); ?>
			</fieldset>					
			<fieldset>
			<legend><?php _e('Settings for Links','wp-to-twitter'); ?></legend>
			<p>
				<input type="checkbox" name="jd_twit_blogroll" id="jd_twit_blogroll" value="1" <?php echo jd_checkCheckbox('jd_twit_blogroll')?> />
				<label for="jd_twit_blogroll"><strong><?php _e("Update Twitter when you post a Blogroll link", 'wp-to-twitter'); ?></strong></label><br />				
				<label for="newlink-published-text"><?php _e("Text for new link updates:", 'wp-to-twitter'); ?></label> <input type="text" name="newlink-published-text" id="newlink-published-text" size="60" maxlength="120" value="<?php echo ( esc_attr( stripslashes( get_option( 'newlink-published-text' ) ) ) ); ?>" /><br /><small><?php _e('Available shortcodes: <code>#url#</code>, <code>#title#</code>, and <code>#description#</code>.','wp-to-twitter'); ?></small>
			</p>
			</fieldset>
			<fieldset>	
			<legend><?php _e("Choose your short URL service (account settings below)",'wp-to-twitter' ); ?></legend>
			<p>
			<select name="jd_shortener" id="jd_shortener">
				<option value="3" <?php jd_checkSelect('jd_shortener','3'); ?>><?php _e("Don't shorten URLs.", 'wp-to-twitter'); ?></option>
				<option value="7" <?php jd_checkSelect('jd_shortener','7'); ?>><?php _e("Use Su.pr for my URL shortener.", 'wp-to-twitter'); ?></option> 
				<option value="2" <?php jd_checkSelect('jd_shortener','2'); ?>><?php _e("Use Bit.ly for my URL shortener.", 'wp-to-twitter'); ?></option>
				<option value="8" <?php jd_checkSelect('jd_shortener','8'); ?>><?php _e("Use Goo.gl as a URL shortener.", 'wp-to-twitter'); ?></option> 				
				<option value="5" <?php jd_checkSelect('jd_shortener','5'); ?>><?php _e("YOURLS (installed on this server)", 'wp-to-twitter'); ?></option>
				<option value="6" <?php jd_checkSelect('jd_shortener','6'); ?>><?php _e("YOURLS (installed on a remote server)", 'wp-to-twitter'); ?></option>		
				<option value="4" <?php jd_checkSelect('jd_shortener','4'); ?>><?php _e("Use WordPress as a URL shortener.", 'wp-to-twitter'); ?></option> 
			</select>
			</p>
			</fieldset>
				<div>
		<input type="hidden" name="submit-type" value="options" />
		</div>
	<input type="submit" name="submit" value="<?php _e("Save WP->Twitter Options", 'wp-to-twitter'); ?>" class="button-primary" />	
	</div>
	</form>
</div>
</div>
</div>
<div class="ui-sortable meta-box-sortables">
<div class="postbox">
<h3><?php _e('<abbr title="Uniform Resource Locator">URL</abbr> Shortener Account Settings','wp-to-twitter'); ?></h3>
	<div class="inside">
		<div class="panel">
		<h4 class="supr"><span><?php _e("Your Su.pr account details", 'wp-to-twitter'); ?> <?php _e('(optional)','wp-to-twitter'); ?></span></h4>
	<form method="post" action="">
	<div>
		<p>
		<label for="suprlogin"><?php _e("Your Su.pr Username:", 'wp-to-twitter'); ?></label>
		<input type="text" name="suprlogin" id="suprlogin" size="40" value="<?php echo ( esc_attr( get_option( 'suprlogin' ) ) ) ?>" />
		</p>
		<p>
		<label for="suprapi"><?php _e("Your Su.pr <abbr title='application programming interface'>API</abbr> Key:", 'wp-to-twitter'); ?></label>
		<input type="text" name="suprapi" id="suprapi" size="40" value="<?php echo ( esc_attr( get_option( 'suprapi' ) ) ) ?>" />
		</p>
		<div>
		<input type="hidden" name="submit-type" value="suprapi" />
		</div>
		<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
		<p><input type="submit" name="submit" value="Save Su.pr API Key" class="button-primary" /> <input type="submit" name="clear" value="Clear Su.pr API Key" />&raquo; <small><?php _e("Don't have a Su.pr account or API key? <a href='http://su.pr/'>Get one here</a>!<br />You'll need an API key in order to associate the URLs you create with your Su.pr account.", 'wp-to-twitter'); ?></small></p>
	</div>
	</form>
	</div>
	<div class="panel">
<h4 class="bitly"><span><?php _e("Your Bit.ly account details", 'wp-to-twitter'); ?></span></h4>
	<form method="post" action="">
	<div>
		<p>
		<label for="bitlylogin"><?php _e("Your Bit.ly username:", 'wp-to-twitter'); ?></label>
		<input type="text" name="bitlylogin" id="bitlylogin" value="<?php echo ( esc_attr( get_option( 'bitlylogin' ) ) ) ?>" />
		<br /><small><?php _e('This must be a standard Bit.ly account. Your Twitter or Facebook log-in will not work.','wp-to-twitter'); ?></small></p>	
		<p>
		<label for="bitlyapi"><?php _e("Your Bit.ly <abbr title='application programming interface'>API</abbr> Key:", 'wp-to-twitter'); ?></label>
		<input type="text" name="bitlyapi" id="bitlyapi" size="40" value="<?php echo ( esc_attr( get_option( 'bitlyapi' ) ) ) ?>" />
		</p>

		<div>
		<input type="hidden" name="submit-type" value="bitlyapi" />
		</div>
	<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
		<p><input type="submit" name="submit" value="<?php _e('Save Bit.ly API Key','wp-to-twitter'); ?>" class="button-primary" /> <input type="submit" name="clear" value="<?php _e('Clear Bit.ly API Key','wp-to-twitter'); ?>" /><br /><small><?php _e("A Bit.ly API key and username is required to shorten URLs via the Bit.ly API and WP to Twitter.", 'wp-to-twitter' ); ?></small></p>
	</div>
	</form>	
</div>
<div class="panel">
<h4 class="yourls"><span><?php _e("Your YOURLS account details", 'wp-to-twitter'); ?></span></h4>
	<form method="post" action="">
	<div>
		<p>
		<label for="yourlspath"><?php _e('Path to your YOURLS config file (Local installations)','wp-to-twitter'); ?></label> <input type="text" id="yourlspath" name="yourlspath" size="60" value="<?php echo ( esc_attr( get_option( 'yourlspath' ) ) ); ?>"/>
		<small><?php _e('Example:','wp-to-twitter'); ?> <code>/home/username/www/www/yourls/includes/config.php</code></small>
		</p>				
		<p>
		<label for="yourlsurl"><?php _e('URI to the YOURLS API (Remote installations)','wp-to-twitter'); ?></label> <input type="text" id="yourlsurl" name="yourlsurl" size="60" value="<?php echo ( esc_attr( get_option( 'yourlsurl' ) ) ); ?>"/>
		<small><?php _e('Example:','wp-to-twitter'); ?> <code>http://domain.com/yourls-api.php</code></small>
		</p>
		<p>
		<label for="yourlslogin"><?php _e("Your YOURLS username:", 'wp-to-twitter'); ?></label>
		<input type="text" name="yourlslogin" id="yourlslogin" size="30" value="<?php echo ( esc_attr( get_option( 'yourlslogin' ) ) ) ?>" />
		</p>	
		<p>
		<label for="yourlsapi"><?php _e("Your YOURLS password:", 'wp-to-twitter'); ?> <?php if ( get_option( 'yourlsapi' ) != '') { _e("<em>Saved</em>",'wp-to-twitter'); } ?></label>
		<input type="password" name="yourlsapi" id="yourlsapi" size="30" value="" />
		</p>
		<p>
		<input type="radio" name="jd_keyword_format" id="jd_keyword_id" value="1" <?php jd_checkSelect( 'jd_keyword_format',1,'checkbox' ); ?> /> 		<label for="jd_keyword_id"><?php _e("Post ID for YOURLS url slug.",'wp-to-twitter'); ?></label><br />
		<input type="radio" name="jd_keyword_format" id="jd_keyword" value="2" <?php jd_checkSelect( 'jd_keyword_format',2,'checkbox' ); ?> /> 		<label for="jd_keyword"><?php _e("Custom keyword for YOURLS url slug.",'wp-to-twitter'); ?></label><br />
		<input type="radio" name="jd_keyword_format" id="jd_keyword_default" value="0" <?php jd_checkSelect( 'jd_keyword_format',0,'checkbox' ); ?> /> <label for="jd_keyword_default"><?php _e("Default: sequential URL numbering.",'wp-to-twitter'); ?></label>
		</p>
		<div>
		<input type="hidden" name="submit-type" value="yourlsapi" />
		</div>
	<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
		<p><input type="submit" name="submit" value="<?php _e('Save YOURLS Account Info','wp-to-twitter'); ?>" class="button-primary" /> <input type="submit" name="clear" value="<?php _e('Clear YOURLS password','wp-to-twitter'); ?>" /><br /><small><?php _e("A YOURLS password and username is required to shorten URLs via the remote YOURLS API and WP to Twitter.", 'wp-to-twitter' ); ?></small></p>
	</div>
	</form>		
	</div>
	
</div>
</div>
</div>

<div class="ui-sortable meta-box-sortables">
<div class="postbox">
	<h3><?php _e('Advanced Settings','wp-to-twitter'); ?></h3>
	<div class="inside">
	<form method="post" action="">
	<div>		
	<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
	<input type="submit" name="submit" value="<?php _e("Save Advanced WP->Twitter Options", 'wp-to-twitter'); ?>" class="button-primary button-side" />	
			<fieldset>
				<legend><?php _e("Advanced Tweet settings","wp-to-twitter"); ?></legend>
			<p>
				 <input type="checkbox" name="jd_strip_nonan" id="jd_strip_nonan" value="1" <?php echo jd_checkCheckbox('jd_strip_nonan'); ?> /> <label for="jd_strip_nonan"><?php _e("Strip nonalphanumeric characters from tags",'wp-to-twitter'); ?></label><br />
				<label for="jd_replace_character"><?php _e("Spaces in tags replaced with:",'wp-to-twitter'); ?></label> <input type="text" name="jd_replace_character" id="jd_replace_character" value="<?php echo esc_attr( get_option('jd_replace_character') ); ?>" size="3" /><br />
				
				<small><?php _e("Default replacement is an underscore (<code>_</code>). Use <code>[ ]</code> to remove spaces entirely.",'wp-to-twitter'); ?></small>					
			</p>
			<p>
			<label for="jd_max_tags"><?php _e("Maximum number of tags to include:",'wp-to-twitter'); ?></label> <input type="text" name="jd_max_tags" id="jd_max_tags" value="<?php echo esc_attr( get_option('jd_max_tags') ); ?>" size="3" />
			<label for="jd_max_characters"><?php _e("Maximum length in characters for included tags:",'wp-to-twitter'); ?></label> <input type="text" name="jd_max_characters" id="jd_max_characters" value="<?php echo esc_attr( get_option('jd_max_characters') ); ?>" size="3" /><br />
			<small><?php _e("These options allow you to restrict the length and number of WordPress tags sent to Twitter as hashtags. Set to <code>0</code> or leave blank to allow any and all tags.",'wp-to-twitter'); ?></small>			
			</p>			
			<p>
				<label for="jd_post_excerpt"><?php _e("Length of post excerpt (in characters):", 'wp-to-twitter'); ?></label> <input type="text" name="jd_post_excerpt" id="jd_post_excerpt" size="3" maxlength="3" value="<?php echo ( esc_attr( get_option( 'jd_post_excerpt' ) ) ) ?>" /><br /><small><?php _e("By default, extracted from the post itself. If you use the 'Excerpt' field, that will be used instead.", 'wp-to-twitter'); ?></small>
			</p>				
			<p>
				<label for="jd_date_format"><?php _e("WP to Twitter Date Formatting:", 'wp-to-twitter'); ?></label> <input type="text" name="jd_date_format" id="jd_date_format" size="12" maxlength="12" value="<?php if (get_option('jd_date_format')=='') { echo ( esc_attr( get_option('date_format') ) ); } else { echo ( esc_attr( get_option( 'jd_date_format' ) ) ); }?>" /> (<?php if ( get_option( 'jd_date_format' ) != '' ) { echo date_i18n( get_option( 'jd_date_format' ) ); } else { echo "<em>".date_i18n( get_option( 'date_format' ) )."</em>"; } ?>)<br />
				<small><?php _e("Default is from your general settings. <a href='http://codex.wordpress.org/Formatting_Date_and_Time'>Date Formatting Documentation</a>.", 'wp-to-twitter'); ?></small>
			</p>
			
			<p>
				<label for="jd_twit_prepend"><?php _e("Custom text before all Tweets:", 'wp-to-twitter'); ?></label> <input type="text" name="jd_twit_prepend" id="jd_twit_prepend" size="20" maxlength="20" value="<?php echo ( esc_attr( get_option( 'jd_twit_prepend' ) ) ) ?>" />
				<label for="jd_twit_append"><?php _e("Custom text after all Tweets:", 'wp-to-twitter'); ?></label> <input type="text" name="jd_twit_append" id="jd_twit_append" size="20" maxlength="20" value="<?php echo ( esc_attr( get_option( 'jd_twit_append' ) ) ) ?>" />
			</p>
			<p>
				<label for="jd_twit_custom_url"><?php _e("Custom field for an alternate URL to be shortened and Tweeted:", 'wp-to-twitter'); ?></label> <input type="text" name="jd_twit_custom_url" id="jd_twit_custom_url" size="40" maxlength="120" value="<?php echo ( esc_attr( get_option( 'jd_twit_custom_url' ) ) ) ?>" /><br />
				<small><?php _e("You can use a custom field to send an alternate URL for your post. The value is the name of a custom field containing your external URL.", 'wp-to-twitter'); ?></small>
			</p>
			<?php 
			$inputs = '';
			$default_order = array( 
				'excerpt'=>0,
				'title'=>1,
				'date'=>2,
				'category'=>3,
				'blogname'=>4,
				'author'=>5,
				'account'=>6,
				'tags'=>7,
				'modified'=>8 );
			$preferred_order = get_option( 'wpt_truncation_order' );
			if ( is_array( $preferred_order ) ) { $default_order = $preferred_order; }
			asort($default_order);
			foreach ( $default_order as $k=>$v ) {
				$label = ucfirst($k);
				$inputs .= "<input type='text' size='2' value='$v' name='wpt_truncation_order[$k]' /> <label for='$k-$v'>$label</label><br />";
			}
			?>
			<fieldset>
			<legend><?php _e('Preferred status update truncation sequence','wp-to-twitter'); ?></legend>
			<p>
			<?php echo $inputs; ?>
			<small><?php _e('This is the order in which items will be abbreviated or removed from your status update if it is too long to send to Twitter.','wp-to-twitter'); ?></small>
			</p>
			</fieldset>
		</fieldset>	
		<fieldset>
		<legend><?php _e( "Special Cases when WordPress should send a Tweet",'wp-to-twitter' ); ?></legend>
			<p>
				<input type="checkbox" name="jd_tweet_default" id="jd_tweet_default" value="1" <?php echo jd_checkCheckbox('jd_tweet_default')?> />
				<label for="jd_tweet_default"><?php _e("Do not post Tweets by default", 'wp-to-twitter'); ?></label><br />
				<input type="checkbox" name="jd_tweet_default_edit" id="jd_tweet_default_edit" value="1" <?php echo jd_checkCheckbox('jd_tweet_default_edit')?> />
				<label for="jd_tweet_default_edit"><?php _e("Do not post Tweets by default (editing only)", 'wp-to-twitter'); ?></label><br />				
				<small><?php _e("By default, all posts meeting other requirements will be posted to Twitter. Check this to change your setting.", 'wp-to-twitter'); ?></small>
			</p>
			<p>
				<input type="checkbox" name="wpt_inline_edits" id="wpt_inline_edits" value="1" <?php echo jd_checkCheckbox('wpt_inline_edits')?> />
				<label for="wpt_inline_edits"><?php _e("Allow status updates from Quick Edit", 'wp-to-twitter'); ?></label><br />
				<small><?php _e("If checked, all posts edited individually or in bulk through the Quick Edit feature will be Tweeted.", 'wp-to-twitter'); ?></small>

			</p>
			<?php if ( function_exists( 'wpt_pro_exists') && get_option( 'wpt_delay_tweets' ) > 0 ) { 
				$r_disabled = " disabled='disabled'"; 
				$r_message = "<em>".__('Delaying tweets with WP Tweets PRO moves Tweeting to an publishing-independent action.','wp-to-twitter' )."</em>"; 
			} else { 
				$r_disabled = ''; 
				$r_message = '';
			} ?>
			<p>
				<input type="checkbox"<?php echo $r_disabled; ?> name="jd_twit_remote" id="jd_twit_remote" value="1" <?php echo jd_checkCheckbox('jd_twit_remote')?> />
				<label for="jd_twit_remote"><?php _e("Send Twitter Updates on remote publication (Post by Email or XMLRPC Client)", 'wp-to-twitter'); ?></label><br />
				<?php echo $r_message; ?>
			</p>
		</fieldset>
		<fieldset>
		<legend><?php _e( "Google Analytics Settings",'wp-to-twitter' ); ?></legend>
				<p><?php _e("You can track the response from Twitter using Google Analytics by defining a campaign identifier here. You can either define a static identifier or a dynamic identifier. Static identifiers don't change from post to post; dynamic identifiers are derived from information relevant to the specific post. Dynamic identifiers will allow you to break down your statistics by an additional variable.","wp-to-twitter"); ?></p>
				
			<p>
				<input type="checkbox" name="use-twitter-analytics" id="use-twitter-analytics" value="1" <?php echo jd_checkCheckbox('use-twitter-analytics')?> />
				<label for="use-twitter-analytics"><?php _e("Use a Static Identifier with WP-to-Twitter", 'wp-to-twitter'); ?></label><br />
				<label for="twitter-analytics-campaign"><?php _e("Static Campaign identifier for Google Analytics:", 'wp-to-twitter'); ?></label> <input type="text" name="twitter-analytics-campaign" id="twitter-analytics-campaign" size="40" maxlength="120" value="<?php echo ( esc_attr( get_option( 'twitter-analytics-campaign' ) ) ) ?>" /><br />
			</p>
			<p>
				<input type="checkbox" name="use-dynamic-analytics" id="use-dynamic-analytics" value="1" <?php echo jd_checkCheckbox('use_dynamic_analytics')?> />
				<label for="use-dynamic-analytics"><?php _e("Use a dynamic identifier with Google Analytics and WP-to-Twitter", 'wp-to-twitter'); ?></label><br />
			<label for="jd-dynamic-analytics"><?php _e("What dynamic identifier would you like to use?","wp-to-twitter"); ?></label> 
				<select name="jd-dynamic-analytics" id="jd-dynamic-analytics">
					<option value="post_category"<?php jd_checkSelect( 'jd_dynamic_analytics','post_category'); ?>><?php _e("Category","wp-to-twitter"); ?></option>
					<option value="post_ID"<?php jd_checkSelect( 'jd_dynamic_analytics','post_ID'); ?>><?php _e("Post ID","wp-to-twitter"); ?></option>
					<option value="post_title"<?php jd_checkSelect( 'jd_dynamic_analytics','post_title'); ?>><?php _e("Post Title","wp-to-twitter"); ?></option>
					<option value="post_author"<?php jd_checkSelect( 'jd_dynamic_analytics','post_author'); ?>><?php _e("Author","wp-to-twitter"); ?></option>
				</select><br />
			</p>
		</fieldset>
		<fieldset id="indauthors">
		<legend><?php _e('Individual Authors','wp-to-twitter'); ?></legend>
			<p>
				<input type="checkbox" name="jd_individual_twitter_users" id="jd_individual_twitter_users" value="1" <?php echo jd_checkCheckbox('jd_individual_twitter_users')?> />
				<label for="jd_individual_twitter_users"><?php _e("Authors have individual Twitter accounts", 'wp-to-twitter'); ?></label><br /><small><?php _e('Authors can add their username in their user profile. This feature can only add an @reference to the author. The @reference is placed using the <code>#account#</code> shortcode, which will pick up the main account if user accounts are not enabled.', 'wp-to-twitter'); ?></small>
			</p>
		<?php
		global $wp_roles;
		$roles = $wp_roles->get_names();
		$options = '';
		$permissions = '';
		$switcher = '';
		foreach ( $roles as $role=>$rolename ) {
			$permissions .= ($role !='subscriber')?"<option value='$role'".wtt_option_selected(get_option('wtt_user_permissions'),$role,'option').">$rolename</option>\n":'';
			$options .= ($role !='subscriber')?"<option value='$role'".wtt_option_selected(get_option('wtt_show_custom_tweet'),$role,'option').">$rolename</option>\n":'';
			$switcher .= ($role !='subscriber')?"<option value='$role'".wtt_option_selected(get_option('wpt_twitter_switch'),$role,'option').">$rolename</option>\n":'';			
		}
		?>
		    <p>
			<label for="wtt_user_permissions"><?php _e('Choose the lowest user group that can add their Twitter information','wp-to-twitter'); ?></label> <select id="wtt_user_permissions" name="wtt_user_permissions">
				<?php echo $permissions; ?>
			</select> 
			</p>
		    <p>
			<label for="wtt_show_custom_tweet"><?php _e('Choose the lowest user group that can see the Custom Tweet options when posting','wp-to-twitter'); ?></label> <select id="wtt_show_custom_tweet" name="wtt_show_custom_tweet">
				<?php echo $options; ?>
			</select> 
			</p>
			<p>
			<label for="wpt_twitter_switch"><?php _e('User groups above this can toggle the Tweet/Don\'t Tweet option, but not see other custom tweet options.','wp-to-twitter'); ?></label> <select id="wpt_twitter_switch" name="wpt_twitter_switch">
				<?php echo $switcher; ?>
			</select> 
			</p>
		</fieldset>
		<fieldset>
		<legend><?php _e('Disable Error Messages','wp-to-twitter'); ?></legend>
			<ul>
			<li><input type="checkbox" name="disable_url_failure" id="disable_url_failure" value="1" <?php echo jd_checkCheckbox('disable_url_failure')?> />	<label for="disable_url_failure"><?php _e("Disable global URL shortener error messages.", 'wp-to-twitter'); ?></label></li>
			<li><input type="checkbox" name="disable_twitter_failure" id="disable_twitter_failure" value="1" <?php echo jd_checkCheckbox('disable_twitter_failure')?> />	<label for="disable_twitter_failure"><?php _e("Disable global Twitter API error messages.", 'wp-to-twitter'); ?></label></li>
			<li><input type="checkbox" name="disable_oauth_notice" id="disable_oauth_notice" value="1" <?php echo jd_checkCheckbox('disable_oauth_notice')?> /> <label for="disable_oauth_notice"><?php _e("Disable notification to implement OAuth", 'wp-to-twitter'); ?></label></li>
			<li><input type="checkbox" name="wp_debug_oauth" id="wp_debug_oauth" value="1" <?php echo jd_checkCheckbox('wp_debug_oauth')?> />
				<label for="wp_debug_oauth"><?php _e("Get Debugging Data for OAuth Connection", 'wp-to-twitter'); ?></label></li>
			<li><input type="checkbox" name="wpt_http" id="wpt_http" value="1" <?php echo jd_checkCheckbox('wpt_http')?> />
				<label for="wpt_http"><?php _e("Switch to <code>http</code> connection. (Default is https)", 'wp-to-twitter'); ?></label></li>				
			<li><input type="checkbox" name="jd_donations" id="jd_donations" value="1" <?php echo jd_checkCheckbox('jd_donations')?> />
				<label for="jd_donations"><strong><?php _e("I made a donation, so stop whinging at me, please.", 'wp-to-twitter'); ?></strong></label></li>
			</ul>
		</fieldset>
		<div>
		<input type="hidden" name="submit-type" value="advanced" />
		</div>
	<input type="submit" name="submit" value="<?php _e("Save Advanced WP->Twitter Options", 'wp-to-twitter'); ?>" class="button-primary" />	
	</div>
	</form>
</div>
</div>
</div>
<div class="ui-sortable meta-box-sortables">
	<div class="postbox categories">
	<h3><?php _e('Limit Updating Categories','wp-to-twitter'); ?></h3>
		<div class="inside">
			<p>
			<?php _e('If no categories are checked, limiting by category will be ignored, and all categories will be Tweeted.','wp-to-twitter'); ?>
			<?php if ( get_option('limit_categories') == '0' ) {	_e('<em>Category limits are disabled.</em>','wp-to-twitter'); } ?>
			</p>
	<?php jd_list_categories(); ?>

		</div>
	</div>
</div>

	<div class="postbox" id="get-support">
	<h3><?php _e('Get Plug-in Support','wp-to-twitter'); ?></h3>
		<div class="inside">
		<?php if ( !function_exists( 'wpt_pro_exists' ) ) { ?>
		<p><?php _e('Support requests without a donation will not be answered, but will be treated as bug reports.','wp-to-twitter'); ?></p>
		<?php } ?>
		<?php wpt_get_support_form(); ?>
		</div>
	</div>
	
	<form method="post" action="">
	<fieldset>
	<input type="hidden" name="submit-type" value="check-support" />
	<?php $nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);  echo "<div>$nonce</div>"; ?>	
		<p>
		<input type="submit" name="submit" value="<?php _e('Check Support','wp-to-twitter'); ?>" class="button-primary" /> <?php _e('Check whether your server supports <a href="http://www.joedolson.com/articles/wp-to-twitter/">WP to Twitter\'s</a> queries to the Twitter and URL shortening APIs. This test will send a status update to Twitter and shorten a URL using your selected methods.','wp-to-twitter'); ?>
		</p>
	</fieldset>
	</form>		
</div>
</div>
<div class="postbox-container" style="width:20%">
<div class="metabox-holder">
	<div class="ui-sortable meta-box-sortables">
		<div class="postbox">
			<?php if (  !function_exists( 'wpt_pro_exists' )  ) { ?>
			<h3><strong><?php _e('Support WP to Twitter','wp-to-twitter'); ?></strong></h3>
			<?php } else { ?>
			<h3><strong><?php _e('WP to Twitter Support','wp-to-twitter'); ?></strong></h3>			
			<?php } ?>
			<div class="inside resources">
			<ul>
			<li><a href="?page=wp-to-twitter/wp-to-twitter.php&amp;export=settings"><?php _e("View Settings",'wp-to-twitter'); ?></a></li>
			<?php if ( function_exists( 'wpt_pro_exists' ) ) { $support = admin_url('admin.php?page=wp-tweets-pro'); } else { $support = admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php');} ?>
			<li><a href="<?php echo $support; ?>#get-support"><?php _e("Get Support",'wp-to-twitter'); ?></a></li>
			</ul>
			<?php if ( get_option('jd_donations') != 1 && !function_exists( 'wpt_pro_exists' )  ) { ?>
			<div>
			<p><?php _e('<a href="http://www.joedolson.com/donate.php">Make a donation today!</a> Every donation counts - donate $2, $10, or $100 and help me keep this plug-in running!','wp-to-twitter'); ?></p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
				<div>
				<input type="hidden" name="cmd" value="_s-xclick" />
				<input type="hidden" name="hosted_button_id" value="8490399" />
				<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donate_LG.gif" name="submit" alt="Donate" />
				<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
				</div>
			</form>
			</div>		
		<?php } ?>
			</div>
		</div>
	</div>
	<?php if ( !function_exists( 'wpt_pro_exists' )  ) { ?>
	<div class="ui-sortable meta-box-sortables">
		<div class="postbox">
			<h3><strong><?php _e('Upgrade Now!','wp-to-twitter'); ?></strong></h3>
			<div class="inside purchase">
				<strong><a href="http://www.joedolson.com/articles/wp-tweets-pro/"><?php _e('Upgrade to <strong>WP Tweets PRO</strong> for more control!','wp-to-twitter'); ?></a></strong>
			<p><?php _e('Extra features with the PRO upgrade:','wp-to-twitter'); ?></p>
			<ul>
				<li><?php _e('Users can post to their own Twitter accounts','wp-to-twitter'); ?></li>
				<li><?php _e('Set a timer to send your Tweet minutes or hours after you publish the post','wp-to-twitter'); ?></li>
				<li><?php _e('Automatically re-send Tweets at an assigned time after publishing','wp-to-twitter'); ?></li>
			</ul>
			
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="ui-sortable meta-box-sortables">
		<div class="postbox">
		<h3><?php _e('Shortcodes','wp-to-twitter'); ?></h3>
		<div class="inside">
			<p><?php _e("Available in post update templates:", 'wp-to-twitter'); ?></p>
			<ul>
			<li><?php _e("<code>#title#</code>: the title of your blog post", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#blog#</code>: the title of your blog", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#post#</code>: a short excerpt of the post content", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#category#</code>: the first selected category for the post", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#date#</code>: the post date", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#modified#</code>: the post modified date", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#url#</code>: the post URL", 'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#author#</code>: the post author",'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#account#</code>: the twitter @reference for the account (or the author, if author settings are enabled and set.)",'wp-to-twitter'); ?></li>
			<li><?php _e("<code>#tags#</code>: your tags modified into hashtags. See options in the Advanced Settings section, below.",'wp-to-twitter'); ?></li>
			</ul>
			<p><?php _e("You can also create custom shortcodes to access WordPress custom fields. Use doubled square brackets surrounding the name of your custom field to add the value of that custom field to your status update. Example: <code>[[custom_field]]</code></p>", 'wp-to-twitter'); ?>
		</div>
		</div>
	</div>
</div>
</div>
</div>
<?php global $wp_version; }