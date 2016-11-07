<?php
/*
Plugin Name: WP to Twitter
Plugin URI: http://www.joedolson.com/articles/wp-to-twitter/
Description: Posts a Tweet when you update your WordPress blog or post to your blogroll, using your chosen URL shortening service. Rich in features for customizing and promoting your Tweets.
Version: 2.4.6
Author: Joseph Dolson
Author URI: http://www.joedolson.com/
*/
/*  Copyright 2008-2012  Joseph C Dolson  (email : wp-to-twitter@joedolson.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
if ('wp-to-twitter.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
     die ('<h2>Direct File Access Prohibited</h2>');
}
global $wp_version;
if ( version_compare( $wp_version , '3.0' , '<' ) && is_ssl() ) {
	$wp_content_url = str_replace( 'http://' , 'https://' , get_option( 'siteurl' ) );
} else {
	$wp_content_url = get_option( 'siteurl' );
}
$wp_content_url .= '/wp-content';
$wp_content_dir = ABSPATH . 'wp-content';

if ( defined('WP_CONTENT_URL') ) {
	$wp_content_url = constant('WP_CONTENT_URL');
}
if ( defined('WP_CONTENT_DIR') ) {
	$wp_content_dir = constant('WP_CONTENT_DIR');
}
$wp_plugin_url = $wp_content_url . '/plugins';
$wp_plugin_dir = $wp_content_dir . '/plugins';
$wpmu_plugin_url = $wp_content_url . '/mu-plugins';
$wpmu_plugin_dir = $wp_content_dir . '/mu-plugins';
include_once( ABSPATH . 'wp-admin/includes/plugin.php' ); // required in order to access is_plugin_active()

if ( version_compare( phpversion(), '5.0', '<' ) ) {
	$warning = __('WP to Twitter requires PHP version 5 or above. Please upgrade PHP to run WP to Twitter.','wp-to-twitter' );
	add_action('admin_notices', create_function( '', "echo \"<div class='error'><p>$warning</p></div>\";" ) );
} else {
	require_once( $wp_plugin_dir . '/wp-to-twitter/wp-to-twitter-oauth.php' );
}
require_once( $wp_plugin_dir . '/wp-to-twitter/wp-to-twitter-manager.php' );
require_once( $wp_plugin_dir . '/wp-to-twitter/functions.php' );

global $wpt_version,$jd_plugin_url,$jdwp_api_post_status;
$wpt_version = "2.4.6";
$plugin_dir = basename(dirname(__FILE__));
load_plugin_textdomain( 'wp-to-twitter', false, dirname( plugin_basename( __FILE__ ) ) );

$protocol = ( get_option( 'wpt_http' ) == '1' )?'http:':'https:';
$jdwp_api_post_status = "$protocol//api.twitter.com/1/statuses/update.json";

$jd_plugin_url = "http://www.joedolson.com/articles/wp-to-twitter/";
$jd_donate_url = "http://www.joedolson.com/articles/wp-tweets-pro/";

function wpt_marginal_function() {
global $wp_version;
$exit_msg=__('WP to Twitter requires WordPress 2.9.2 or a more recent version, but some features will not work below 3.0.6. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update WordPress to continue using WP to Twitter with all features!</a>','wp-to-twitter');
	if ( version_compare( $wp_version,"3.0.6","<" ) ) {
		if ( is_admin() ) {
			echo "<div class='error'><p>".($exit_msg)."</p></div>";
		}
	}
}
 // check for OAuth configuration
function wpt_check_oauth( $auth=false ) {
	if ( !function_exists('wtt_oauth_test') ) {
		$oauth = false;
	} else {
		$oauth = wtt_oauth_test( $auth );
	}
	return $oauth;
}
if ( !wpt_check_oauth() && get_option('disable_oauth_notice') != '1' ) {
	$admin_url = ( is_plugin_active('wp-tweets-pro/wpt-pro-functions.php') )?admin_url('admin.php?page=wp-tweets-pro'):admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php');
	$message = sprintf(__("Twitter requires authentication by OAuth. You will need to <a href='%s'>update your settings</a> to complete installation of WP to Twitter.", 'wp-to-twitter'), $admin_url );
	add_action('admin_notices', create_function( "", "if ( ! current_user_can( 'manage_options' ) ) { return; } else { 
		echo \"<div class='error'><p>$message</p></div>\";}" ) );
}

function wpt_check_version() {
	global $wpt_version;
	$prev_version = get_option( 'wp_to_twitter_version' );
	if ( version_compare( $prev_version,$wpt_version,"<" ) ) {
		wptotwitter_activate();
	}
}

function wptotwitter_activate() {
global $wpt_version;
$prev_version = get_option( 'wp_to_twitter_version' );
// this is a switch to plan for future versions
$upgrade = version_compare( $prev_version,"2.2.9","<" );
	if ($upgrade) {
		delete_option( 'x-twitterlogin' );
		delete_option( 'twitterlogin' );
		delete_option( 'twitterpw' );
		delete_option( 'jd-use-link-title' );
		delete_option( 'jd-use-link-description' );
		delete_option( 'jd_use_both_services' );
		delete_option( 'jd-twitter-service-name' );
		delete_option( 'jd_api_post_status' );
		delete_option( 'jd-twitter-char-limit' );
		delete_option( 'x-twitterpw' );	
		delete_option( 'x_jd_api_post_status' );
		delete_option( 'cligsapi' );
		delete_option( 'cligslogin' );
		delete_option( 'wp_cligs_error' );
	}
$upgrade = version_compare( $prev_version, "2.3.1","<" );
	if ($upgrade) {
		$array = 
			array(
				'post'=> array(
						'post-published-update'=>get_option('newpost-published-update'),
						'post-published-text'=>get_option('newpost-published-text'),
						'post-edited-update'=>get_option('oldpost-edited-update'),
						'post-edited-text'=>get_option('oldpost-edited-text')
					),
				'page'=> array(
						'post-published-update'=>get_option('jd_twit_pages'),
						'post-published-text'=>get_option('newpage-published-text'),
						'post-edited-update'=>get_option('jd_twit_edited_pages'),
						'post-edited-text'=>get_option('oldpage-edited-text')				
					)
			);
		add_option( 'wpt_post_types', $array );
		add_option( 'comment-published-update', 0 );
		add_option( 'comment-published-text', 'New comment on #title# #url#' );
		delete_option('newpost-published-update');
		delete_option('newpost-published-text');
		delete_option('oldpost-edited-update');
		delete_option('oldpost-edited-text');
		delete_option('newpage-published-text');
		delete_option('oldpage-edited-text');
		delete_option( 'newpost-published-showlink' );
		delete_option( 'oldpost-edited-showlink' );
		delete_option( 'jd_twit_pages' );
		delete_option( 'jd_twit_edited_pages' );		
		delete_option( 'jd_twit_postie' );
	}
$upgrade = version_compare( $prev_version, "2.3.3","<" );
	if ( $upgrade ) {
		delete_option( 'jd_twit_quickpress' );
	}
$upgrade = version_compare( $prev_version, "2.3.4","<" );
	if ( $upgrade ) {
		add_option( 'wpt_inline_edits', '0' );
	}
$upgrade = version_compare( $prev_version, "2.3.15","<" );
	if ( $upgrade ) {
		$use = get_option( 'use_tags_as_hashtags' );
		if ( $use == 1 ) {
			$wpt_settings = get_option( 'wpt_post_types' );
			$post_types = get_post_types( '', 'names' );
			foreach ( $post_types as $type ) {
				if ( isset($wpt_settings[$type]) ) {
					$t1 = $wpt_settings[$type]['post-published-text'].' #tags#';
					$t2 = $wpt_settings[$type]['post-edited-text'].' #tags#';
					$wpt_settings[$type]['post-published-text'] = $t1;
					$wpt_settings[$type]['post-edited-text'] = $t2;
				}
			}
			update_option('wpt_post_types',$wpt_settings );
		}
		delete_option( 'use_tags_as_hashtags' );
	}
$upgrade = version_compare( $prev_version, "2.4.0","<" );
	if ( $upgrade ) {
		$perms = get_option('wtt_user_permissions');
		switch( $perms ) {
			case 'read':$update = 'subscriber';	break;
			case 'edit_posts':$update = 'contributor';	break;
			case 'publish_posts':$update = 'author';	break;
			case 'moderate_comments':$update = 'editor';	break;
			case 'manage_options':$update = 'administrator';	break;
			default:$update = 'administrator';
		}
		update_option( 'wtt_user_permissions',$update );
	}
$upgrade = version_compare( $prev_version, "2.4.1","<" );
	$subscriber = get_role('subscriber');
	$contributor = get_role('contributor');
	$author = get_role('author');
	$editor = get_role('editor');
	$administrator = get_role('administrator');
	$administrator->add_cap('wpt_twitter_oauth');
	$administrator->add_cap('wpt_twitter_custom');
	$administrator->add_cap('wpt_twitter_switch');
	switch ( get_option('wtt_user_permissions') ) {
		case 'subscriber': $subscriber->add_cap('wpt_twitter_oauth'); $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');   break;
		case 'contributor': $contributor->add_cap('wpt_twitter_oauth'); $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth');  break;
		case 'author': $author->add_cap('wpt_twitter_oauth'); $editor->add_cap('wpt_twitter_oauth'); break;
		case 'editor':$editor->add_cap('wpt_twitter_oauth'); break;
		case 'administrator': break;
		default: 
			$role = get_role( get_option('wtt_user_permissions') ); 
			if ( is_object($role) ) {			
				$role->add_cap('wpt_twitter_oauth');
			}
		break;
	}
	switch ( get_option('wtt_show_custom_tweet') ) {
		case 'subscriber': $subscriber->add_cap('wpt_twitter_custom'); $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');   break;
		case 'contributor': $contributor->add_cap('wpt_twitter_custom'); $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom');  break;
		case 'author': $author->add_cap('wpt_twitter_custom'); $editor->add_cap('wpt_twitter_custom'); break;
		case 'editor':$editor->add_cap('wpt_twitter_custom'); break;
		case 'administrator': break;
		default: 
			$role = get_role( get_option('wtt_show_custom_tweet') );
			if ( is_object($role) ) {
				$role->add_cap('wpt_twitter_custom');
			}
		break;
	}
	update_option( 'wp_to_twitter_version',$wpt_version );
}	
	
// Function checks for an alternate URL to be Tweeted. Contribution by Bill Berry.	
function external_or_permalink( $post_ID ) {
	$ex_link = false;
       $wtb_extlink_custom_field = get_option('jd_twit_custom_url'); 
       $permalink = get_permalink( $post_ID );
			if ( $wtb_extlink_custom_field != '' ) {
				$ex_link = get_post_meta($post_ID, $wtb_extlink_custom_field, true);
			}
       return ( $ex_link ) ? $ex_link : $permalink;
}

// This function performs the API post to Twitter
function jd_doTwitterAPIPost( $twit, $auth=false ) {
	// prevent duplicate Tweets
	if ( !wpt_check_oauth( $auth )	) { return true; } // exit silently if not authorized

	$check = ( !$auth )?get_option('jd_last_tweet'):get_user_meta( $auth, 'wpt_last_tweet', true ); // get user's last tweet
	if ( $check == $twit || $twit == '' || !$twit ) {
		return true;
	} else {
		global $jdwp_api_post_status;
		if ( wtt_oauth_test( $auth ) && ( $connection = wtt_oauth_connection( $auth ) ) ) {
			$connection->post( $jdwp_api_post_status, array( 'status' => $twit, 'source' => 'wp-to-twitter'	) );
			$http_code = ($connection)?$connection->http_code:'failed';
		} else if ( wtt_oauth_test( false ) && ( $connection = wtt_oauth_connection( false ) ) ) {
			$connection->post( $jdwp_api_post_status, array( 'status' => $twit, 'source' => 'wp-to-twitter'	) );
			$http_code = ($connection)?$connection->http_code:'failed';		
		}
		if ( $connection ) {
			switch ($http_code) {
				case '200':
					$return = true;
					$error = __("200 OK: Success!",'wp-to-twitter');
					delete_option('wpt_authentication_missing');
					break;
				case '400':
					$return = false;
					$error = __("400 Bad Request: The request was invalid. This is the status code returned during rate limiting.",'wp-to-twitter');
					break;
				case '401':
					$return = false;
					$error = __("401 Unauthorized: Authentication credentials were missing or incorrect.",'wp-to-twitter');
					update_option( 'wpt_authentication_missing','true');
					break;
				case '403':
					$return = false;
					$error = __("403 Forbidden: The request is understood, but it has been refused. This code is used when requests are understood, but are denied by Twitter. Reasons can include: Too many Tweets created in a short time or the same Tweet was submitted twice in a row, among others. This is not an error by WP to Twitter.",'wp-to-twitter');
					break;
				case '500':
					$return = false;
					$error = __("500 Internal Server Error: Something is broken at Twitter.",'wp-to-twitter');
					break;
				case '503':
					$return = false;
					$error = __("503 Service Unavailable: The Twitter servers are up, but overloaded with requests - Please try again later.",'wp-to-twitter');
					break;
				case '502':
					$return = false;
					$error = __("502 Bad Gateway: Twitter is down or being upgraded.",'wp-to-twitter');
					break;
				default:
					$return = false;
					$error = __("<strong>Code $http_code</strong>: Twitter did not return a recognized response code.",'wp-to-twitter');
					break;
			}
			// debugging
			//wp_mail('joe@joedolson.com','Response code',"$http_code $error" );
			// end debugging
			$update = ( !$auth )?update_option( 'jd_last_tweet',$twit ):update_user_meta( $auth, 'wpt_last_tweet',$twit );
			if ( !$return ) {
				update_option( 'jd_status_message',$error );
			} else {
				delete_option( 'jd_status_message' );
			}
			return $return;			
		} else {
			update_option( 'jd_status_message',__('No Twitter OAuth connection found.','wp-to-twitter') );
		}
	}
}

function fake_normalize( $string ) {
	if ( version_compare( PHP_VERSION, '5.0.0', '>=' ) && function_exists('normalizer_normalize') ) {
		if ( normalizer_is_normalized( $string ) ) { return $string; }
		return normalizer_normalize( $string );
	} else {
		return preg_replace( '~&([a-z]{1,2})(acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml|mp);~i', '$1', htmlentities( $string, ENT_NOQUOTES, 'UTF-8' ) );
	}
}

function jd_truncate_tweet( $sentence, $postinfo, $thisposturl, $post_ID, $retweet=false ) {
	$sentence = trim(custom_shortcodes( $sentence, $post_ID ));				
	// generate all template variable values
	$auth = $postinfo['authId'];
	$title = trim( apply_filters( 'wpt_status', $postinfo['postTitle'], $post_ID, 'title' ) );
	$blogname = trim($postinfo['blogTitle']);
	$excerpt = trim( apply_filters( 'wpt_status', $postinfo['postExcerpt'], $post_ID, 'post' ) );
	$thisposturl = trim($thisposturl);
	$category = trim($postinfo['category']);
		$post = get_post( $post_ID );
		$user_account = get_user_meta( $auth,'wtt_twitter_username', true ) ;
	$author = ( $user_account != '' )?"$user_account":get_the_author_meta( 'display_name',$post->post_author );
	$tags = generate_hash_tags( $post_ID );
	$account = "@".get_option('wtt_twitter_username');
	$date = trim($postinfo['postDate']);
	$modified = trim($postinfo['postModified']);
	if ( get_option( 'jd_individual_twitter_users' ) == 1 ) {
		if ( $user_account == '' ) {
			if ( get_user_meta( $auth, 'wp-to-twitter-enable-user',true ) == 'mainAtTwitter' ) {
				$account = "@" . stripcslashes(get_user_meta( $auth, 'wp-to-twitter-user-username',true ));
			} else if ( get_user_meta( $auth, 'wp-to-twitter-enable-user',true ) == 'mainAtTwitterPlus' ) {
				$account = "@" . stripcslashes(get_user_meta( $auth, 'wp-to-twitter-user-username',true ) . ' @' . get_option( 'wtt_twitter_username' ));
			}
		} else {
			$account = "@$user_account";
		}
	}
	if ( !$retweet ) {	
		if ( get_option( 'jd_twit_prepend' ) != "" && $sentence != '' ) {
			$sentence = get_option( 'jd_twit_prepend' ) . " " . $sentence;
		}
		if ( get_option( 'jd_twit_append' ) != "" && $sentence != '' ) {
			$sentence = $sentence . " " . get_option( 'jd_twit_append' );
		}
	}
	$encoding = get_option('blog_charset');
	// create full unconditional post sentence - prior to truncation
	$post_sentence = str_ireplace( '#account#', $account, $sentence );
	$post_sentence = str_ireplace( '#url#', $thisposturl, $post_sentence );
	$post_sentence = str_ireplace( '#title#', $title, $post_sentence );
	$post_sentence = str_ireplace( '#blog#',$blogname, $post_sentence );
	$post_sentence = str_ireplace( '#post#',$excerpt, $post_sentence );
	$post_sentence = str_ireplace( '#category#',$category, $post_sentence );
	$post_sentence = str_ireplace( '#date#', $date, $post_sentence );
	$post_sentence = str_ireplace( '#author#', $author, $post_sentence );
	$post_sentence = str_ireplace( '#tags#', $tags, $post_sentence );
	$post_sentence = str_ireplace( '#modified#', $modified, $post_sentence );

	$url_strlen = mb_strlen( urldecode( fake_normalize( $thisposturl ) ), $encoding );
	// check total length 
	$str_length = mb_strlen( urldecode( fake_normalize( $post_sentence ) ), $encoding );
	if ( $str_length < 140 ) {
		if ( mb_strlen( fake_normalize ( $post_sentence ) ) > 140 ) { $post_sentence = mb_substr( $post_sentence,0,139,$encoding ); }	
	} else {
		// what is the excerpt supposed to be?
		$length = get_option( 'jd_post_excerpt' );
		// build an array of variable names and the number of characters in that variable.
		$length_array = array();
		$length_array['excerpt'] = mb_strlen(fake_normalize($excerpt),$encoding);
		$length_array['title'] = mb_strlen(fake_normalize($title),$encoding);
		$length_array['date'] = mb_strlen(fake_normalize($date),$encoding);		
		$length_array['category'] = mb_strlen(fake_normalize($category),$encoding);
		$length_array['blogname'] = mb_strlen(fake_normalize($blogname),$encoding);
		$length_array['author'] = mb_strlen(fake_normalize($author),$encoding);
		$length_array['account'] = mb_strlen(fake_normalize($account),$encoding);
		$length_array['tags'] = mb_strlen(fake_normalize($tags),$encoding);
		$length_array['modified'] = mb_strlen(fake_normalize($modified),$encoding);
		// if the total length is too long, truncate items until the length is appropriate. 
		// truncation is in order of items which can most afford to be truncated. URL is never truncated.
		// Twitter has made their t.co shortener automatic and mandatory; this has some weird effects on
		// character counting prior to posting. All URLS are automatically 19 characters. Period.
		$order = get_option( 'wpt_truncation_order' );
		if ( is_array( $order ) ) {
			asort($order);
			$preferred = array();
			foreach ( $order as $k=>$v ) {
				$preferred[$k] = $length_array[$k];
			}
		} else {
			$preferred = $length_array;
		}
		$diff = $url_strlen - 19;
		if ( $str_length > ( 140 + $diff ) ) {
			foreach($preferred AS $key=>$value) {
				$str_length = mb_strlen( urldecode( fake_normalize( trim( $post_sentence ) ) ),$encoding );
				if ( $str_length > ( 140 + $diff ) ) {
					$trim = $str_length - ( 140 + $diff );
					$old_value = ${$key};
					// prevent URL from being modified
					$post_sentence = str_ireplace( $thisposturl, '#url#', $post_sentence ); 
					// modify the value and replace old with new
					if ( $key == 'account' || $key == 'author' || $key == 'category' || $key == 'date' || $key == 'modified' ) {
					// these elements make no sense if truncated, so remove them entirely.
						$new_value = '';
					} else if ( $key == 'tags' ) {
						// replaced, keeps the tags as such intact.
                        // remove any stray hash characters due to string truncation
                        // $new_value = str_replace( ' # ','',' '.mb_substr( $old_value,0,-( $trim ),$encoding ).' ');                       
                        if (mb_strlen($old_value)-$trim <= 2) {
                            $new_value = '';
                        } else {
                            $new_value = $old_value;
                            while ((mb_strlen($old_value)-$trim) < mb_strlen($new_value)) {
                                $new_value = trim(mb_substr($new_value,0,mb_strrpos($new_value,'#',$encoding)-1));
                            }
                        }
					} else {
						$new_value = mb_substr( $old_value,0,-( $trim ),$encoding );					
					}
					$post_sentence = str_ireplace( $old_value,$new_value,$post_sentence );
					// put URL back before checking length
					$post_sentence = str_ireplace( '#url#', $thisposturl, $post_sentence ); 					
				} else {
					if ( mb_strlen( fake_normalize ( $post_sentence ),$encoding ) > ( 140 + $diff ) ) { $post_sentence = mb_substr( $post_sentence,0,( 139 + $diff ),$encoding ); }
				}
			}
		}
		// this is needed in case a tweet needs to be truncated outright and the truncation values aren't in the above.
		// 1) removes URL 2) checks length of remainder 3) Replaces URL
		$temp_sentence = str_ireplace( $thisposturl, '#url#', $post_sentence );
		if ( mb_strlen( fake_normalize( $temp_sentence ) ) > 127 ) { 
			$post_sentence = trim(mb_substr( $temp_sentence,0,127,$encoding ));
			$post_sentence = ( strpos($post_sentence,'#url#') === false )?$post_sentence .' '. $thisposturl:str_ireplace( '#url#',$thisposturl,$post_sentence );
		}
	}
	return $post_sentence;
}
function jd_shorten_link( $thispostlink, $thisposttitle, $post_ID, $testmode='false' ) {
		// filter link before sending to shortener or adding analytics
		$thispostlink = apply_filters('wpt_shorten_link',$thispostlink,$post_ID );
		$suprapi =  trim ( get_option( 'suprapi' ) );
		$suprlogin = trim ( get_option( 'suprlogin' ) );
		$bitlyapi =  trim ( get_option( 'bitlyapi' ) );
		$bitlylogin =  trim ( strtolower( get_option( 'bitlylogin' ) ) );
		$yourlslogin =  trim ( get_option( 'yourlslogin') );
		$yourlsapi = stripcslashes( get_option( 'yourlsapi' ) );
		if ($testmode == 'false') {
			if ( get_option('use-twitter-analytics') == 1 || get_option('use_dynamic_analytics') == 1 ) {
				if ( get_option('use_dynamic_analytics') == '1' ) {
					$campaign_type = get_option('jd_dynamic_analytics');
					if ($campaign_type == "post_category" && $testmode != 'link' ) {
						$category = get_the_category( $post_ID );
						$campaign = $category[0]->cat_name;
					} else if ($campaign_type == "post_ID") {
						$campaign = $post_ID;
					} else if ($campaign_type == "post_title" && $testmode != 'link' ) {
						$post = get_post( $post_ID );
						$campaign = $post->post_title; 
					} else {
						if ( $testmode != 'link' ) {
						$post = get_post( $post_ID );
						$post_author = $post->post_author;
						$campaign = get_the_author_meta( 'user_login',$post_author );
						} else {
							$post_author = '';
							$campaign = '';
						}
					}
				} else {
					$campaign = get_option('twitter-analytics-campaign');
				}
				$campaign = urlencode($campaign);
				if ( strpos( $thispostlink,"%3F" ) === FALSE && strpos( $thispostlink,"?" ) === FALSE ) {
					$ct = "?";
				} else {
					$ct = "&";
				}
				$ga = "utm_campaign=$campaign&utm_medium=twitter&utm_source=twitter";
				$thispostlink .= $ct .= $ga;
			}
		}
		$thispostlink = urldecode(trim($thispostlink));
		$thispostlink = urlencode($thispostlink);

		// custom word setting
		$keyword_format = ( get_option( 'jd_keyword_format' ) == '1' )?$post_ID:'';
		$keyword_format = ( get_option( 'jd_keyword_format' ) == '2' )?get_post_meta( $post_ID,'_yourls_keyword',true ):$keyword_format;
		// Generate and grab the short url
		switch ( get_option( 'jd_shortener' ) ) {
			case 0:
			case 1:
			$shrink = urldecode($thispostlink);
			case 4:
				if ( function_exists('wp_get_shortlink') ) {
					$shrink = wp_get_shortlink( $post_ID );
				} else {
					$shrink = urldecode($thispostlink);				
				}
			break;
			case 2: // updated to v3 3/31/2010
			$decoded = jd_remote_json( "http://api.bitly.com/v3/shorten?longUrl=".$thispostlink."&login=".$bitlylogin."&apiKey=".$bitlyapi."&format=json" );
			$error = '';
				if ($decoded) {
					if ($decoded['status_code'] != 200) {
						$shrink = $decoded;
						$error = $decoded['status_txt'];
					} else {
						$shrink = $decoded['data']['url'];		
					}
				} else {
				$shrink = false;
				update_option( 'wp_bitly_error',"JSON result could not be decoded");
				}	
				if ( !is_valid_url($shrink) ) { $shrink = false; update_option( 'wp_bitly_error',$error ); }
			break;
			case 3:
			$shrink = urldecode($thispostlink);
			break;
			case 5:
			// local YOURLS installation
			$thispostlink = urldecode($thispostlink);
			global $yourls_reserved_URL;
			define('YOURLS_INSTALLING', true); // Pretend we're installing YOURLS to bypass test for install or upgrade
			define('YOURLS_FLOOD_DELAY_SECONDS', 0); // Disable flood check
			$opath = get_option( 'yourlspath' );
			$ypath = str_replace( 'user','includes', $opath );
			if ( file_exists( dirname( $ypath ).'/load-yourls.php' ) ) { // YOURLS 1.4+
				global $ydb;
				require_once( dirname( $ypath ).'/load-yourls.php' );
				if ( function_exists( 'yourls_add_new_link' ) ) {
					$yourls_result = yourls_add_new_link( $thispostlink, $keyword_format );
				} else {
					$yourls_result = $thispostlink;
				}
			} else { // YOURLS 1.3
				require_once( get_option( 'yourlspath' ) ); 
				$yourls_db = new wpdb( YOURLS_DB_USER, YOURLS_DB_PASS, YOURLS_DB_NAME, YOURLS_DB_HOST );
				$yourls_result = yourls_add_new_link( $thispostlink, $keyword_format, $yourls_db );
			}
			if ($yourls_result) {
				$shrink = $yourls_result['shorturl'];			
			} else {
				$shrink = false;
			}
			break;
			case 6:
			// remote YOURLS installation
			$api_url = sprintf( get_option('yourlsurl') . '?username=%s&password=%s&url=%s&format=json&action=shorturl&keyword=%s',
				$yourlslogin, $yourlsapi, $thispostlink, $keyword_format );
			$json = jd_remote_json( $api_url, false );			
			if ($json) {
				$shrink = $json->shorturl;
			} else {
				$shrink = false;
			}
			break;
			case 7:
				if ( $suprapi != '') {
					$decoded = jd_remote_json( "http://su.pr/api/shorten?longUrl=".$thispostlink."&login=".$suprlogin."&apiKey=".$suprapi );
				} else {
					$decoded = jd_remote_json( "http://su.pr/api/shorten?longUrl=".$thispostlink );
				}
				update_option( 'wp_supr_error',"Su.pr API result: $decoded" );
				if ($decoded['statusCode'] == 'OK') {
					$page = str_replace("&","&#38;", urldecode($thispostlink));
					$shrink = $decoded['results'][$page]['shortUrl'];
					$error = $decoded['errorMessage'];
				} else {
					$shrink = false;
					$error = $decoded['errorMessage'];
					update_option( 'wp_supr_error',"JSON result could not be decoded");
				}	
				if ( !is_valid_url($shrink) ) { $shrink = false; update_option( 'wp_supr_error',$error ); }
			break;
			case 8:
			// Goo.gl
				$url = "https://www.googleapis.com/urlshortener/v1/url?key=AIzaSyBSnqQOg3vX1gwR7y2l-40yEG9SZiaYPUQ";
				$link = urldecode($thispostlink);
				$body = "{'longUrl':'$link'}";
				//$body = json_encode($data);
				$json = jd_fetch_url( $url, 'POST', $body, 'Content-Type: application/json' );
				$decoded = json_decode($json);
				//$url = $decoded['id'];
				$shrink = $decoded->id;
				if ( !is_valid_url($shrink) ) { $shrink = false; }
			break;
		}
		if ($testmode != 'true') {
			if ( $shrink === false || ( stristr( $shrink, "http://" ) === FALSE )) {
				update_option( 'wp_url_failure','1' );
				$shrink = urldecode( $thispostlink );
			} else {
				update_option( 'wp_url_failure','0' );
			}
		}
	return $shrink;
}

function jd_expand_url( $short_url ) {
	$short_url = urlencode( $short_url );
	$decoded = jd_remote_json("http://api.longurl.org/v2/expand?format=json&url=" . $short_url );
	$url = $decoded['long-url'];
	return $url;
	//return $short_url;
}
function jd_expand_yourl( $short_url, $remote ) {
	if ( $remote == 6 ) {
		$short_url = urlencode( $short_url );
		$yourl_api = get_option( 'yourlsurl' );
		$user = get_option( 'yourlslogin' );
		$pass = stripcslashes( get_option( 'yourlsapi' ) );
		$decoded = jd_remote_json( $yourl_api . "?action=expand&shorturl=$short_url&format=json&username=$user&password=$pass" );
		$url = $decoded['longurl'];
		return $url;
	} else {
		global $yourls_reserved_URL;
		define('YOURLS_INSTALLING', true); // Pretend we're installing YOURLS to bypass test for install or upgrade
		define('YOURLS_FLOOD_DELAY_SECONDS', 0); // Disable flood check
		if ( file_exists( dirname( get_option( 'yourlspath' ) ).'/load-yourls.php' ) ) { // YOURLS 1.4
			global $ydb;
			require_once( dirname( get_option( 'yourlspath' ) ).'/load-yourls.php' ); 
			$yourls_result = yourls_api_expand( $short_url );
		} else { // YOURLS 1.3
			require_once( get_option( 'yourlspath' ) ); 
			$yourls_db = new wpdb( YOURLS_DB_USER, YOURLS_DB_PASS, YOURLS_DB_NAME, YOURLS_DB_HOST );
			$yourls_result = yourls_api_expand( $short_url );
		}	
		$url = $yourls_result['longurl'];
		return $url;
	}
}

function in_allowed_category( $array ) {
	$allowed_categories =  get_option( 'tweet_categories' );
	if ( is_array( $array ) && is_array( $allowed_categories ) ) {
	$common = @array_intersect( $array,$allowed_categories );
		if ( count( $common ) >= 1 ) {
			return true;
		} else {
			return false;
		}
	} else {
		return true;
	}
}

function jd_post_info( $post_ID ) {
	$get_post_info = get_post( $post_ID );
	$category_ids = false;
	$values = array();
	$values['id'] = $post_ID;
	// get post author
	$values['authId'] = $get_post_info->post_author;
		$postdate = $get_post_info->post_date;
		$altformat = "Y-m-d H:i";		
		$dateformat = (get_option('jd_date_format')=='')?get_option('date_format'):get_option('jd_date_format');
		$thisdate = mysql2date( $dateformat,$postdate );
		$altdate = mysql2date( $altformat, $postdate );
	$values['_postDate'] = $altdate;
	$values['postDate'] = $thisdate;
		$moddate = $get_post_info->post_modified;
		$moddate = mysql2date( $altformat,$moddate );
	$values['_postModified'] = $moddate;
	$values['postModified'] = mysql2date( $dateformat,$moddate );
	// get first category
		$category = null;
		$categories = get_the_category( $post_ID );
		if ( is_array( $categories ) ) {
			if ( count($categories) > 0 ) {
				$category = $categories[0]->cat_name;
			}		
			foreach ($categories AS $cat) {
				$category_ids[] = $cat->term_id;
			}
		} else {
			$category = '';
			$category_ids = array();
		}
	$values['categoryIds'] = $category_ids;
	$values['category'] = $category;
		$excerpt_length = get_option( 'jd_post_excerpt' );
	$post_excerpt = ( trim( $get_post_info->post_excerpt ) == "" )?@mb_substr( strip_tags( strip_shortcodes( $get_post_info->post_content ) ), 0, $excerpt_length ):@mb_substr( strip_tags( strip_shortcodes( $get_post_info->post_excerpt ) ), 0, $excerpt_length );
	$values['postExcerpt'] = html_entity_decode( $post_excerpt, ENT_COMPAT, get_option('blog_charset') );
	/* vestigial qtrans support
	// Want to deal with this later, when I have time to provide full support. Don't see the point in just providing support for titles.
	if ( function_exists( 'something from qtranslate' ) ) {
		$thisposttitle =  wpt_qtranslate( $get_post_info->post_title);
			if ($thisposttitle == "") {
				$thisposttitle =  wpt_qtranslate( $_POST['title'] ) ;
			}	
	} else { */
	$thisposttitle =  stripcslashes( strip_tags( $get_post_info->post_title ) );
		if ($thisposttitle == "") {
			$thisposttitle =  stripcslashes( strip_tags( $_POST['title'] ) );
		}
	/* } */
	$values['postTitle'] = html_entity_decode( $thisposttitle, ENT_COMPAT, get_option('blog_charset') );
	$values['postLink'] = external_or_permalink( $post_ID );
	$values['blogTitle'] = get_bloginfo( 'name' );
	$values['shortUrl'] = get_post_meta( $post_ID, '_wp_jd_clig', TRUE );
	$values['postStatus'] = $get_post_info->post_status;
	$values['postType'] = $get_post_info->post_type;
	$values = apply_filters( 'wpt_post_info',$values, $post_ID );
	return $values;
}
/*
function wpt_qtranslate( $string ) {
    $regex='/(<!--:[a-z]+-->)(.*)(<!--:-->)/U';
    preg_match_all($regex,$string,$matches,PREG_PATTERN_ORDER);
    $counter=0;
    $result="";
    if (empty($matches[0])) { return stripcslashes( strip_tags( $string ) ); }
    while ( $counter < count($matches[0]) ) {
           $result .= $matches[1][$counter] .   stripcslashes( strip_tags( $matches[2][$counter] ) ) . $matches[3][$counter];
           $counter++;
    }
    return $result;
}
*/

function jd_get_post_meta( $post_ID, $value, $boolean ) {
	$return = get_post_meta( $post_ID, "_$value", TRUE );
	if (!$return) {
		$return = get_post_meta( $post_ID, $value, TRUE );
	}
	return $return;
}

function jd_twit( $post_ID ) {
	wpt_check_version();
	$jd_tweet_this = get_post_meta( $post_ID, '_jd_tweet_this', true );
	$newpost = $oldpost = $is_inline_edit = false;
	if ( get_option('wpt_inline_edits') != 1 ) {
		if ( isset($_POST['_inline_edit']) ) { return; }
	} else {
		if ( isset($_POST['_inline_edit']) ) { $is_inline_edit = true; }
	}
	if ( $jd_tweet_this != "no" ) {
		$post_info = jd_post_info( $post_ID );
		/* debug data
		wp_mail('joe@joedolson.com','Debug Data 1',print_r($post_info,1) );
		wp_mail('joe@joedolson.com','Debug Data 2',print_r($_POST,1) );
		// custom for Jason Ashmore -- but shouldn't hurt anybody else */
		if ( $post_info['postTitle'] == '' || strpos( $post_info['postTitle'],'Untitled' ) === 0 ) { return; }
		$post_type = $post_info['postType'];
		// if the post modified date and the post date are the same, this is new.
		$new = wpt_date_compare( $post_info['_postModified'], $post_info['_postDate'] );
		// if this post is not previously published but has been backdated: lit. if post date is edited, but save option is 'publish'
		if ( $new == 0 && ( isset( $_POST['edit_date'] ) && $_POST['edit_date'] == 1 && !isset( $_POST['save'] ) ) ) { $new = 1; }
		// post modified = updated? // postdate == published? therefore: posts which have been updated after creation (scheduled, updated in draft) may not turn up as new. // postStatus == future
		$post_type_settings = get_option('wpt_post_types');
		$post_types = array_keys($post_type_settings);		
		if ( in_array( $post_type, $post_types ) ) {
			$sentence = '';
			$cT = get_post_meta( $post_ID, '_jd_twitter', true );
			if ( isset( $_POST['_jd_twitter'] ) && $_POST['_jd_twitter'] != '' ) { $cT = $_POST['_jd_twitter']; }
			$customTweet = ( $cT != '' )?stripcslashes( trim( $cT ) ):'';
			// excluded post statuses that should never be tweeted		
			if ( $post_info['postStatus'] != 'draft' && $post_info['postStatus'] != 'auto-draft' && $post_info['postStatus'] != 'private' && $post_info['postStatus'] != 'inherit' && $post_info['postStatus'] != 'trash' ) {
			// && $post_info['postStatus'] != 'pending'
				// if ops is set and equals 'publish', this is being edited. Otherwise, it's a new post.
				if ( ( $new == 0 && $post_info['postStatus'] != 'future' ) || $is_inline_edit == true ) {
					// if this is an old post and editing updates are enabled
					if ( $post_type_settings[$post_type]['post-edited-update'] == '1' ) {
						$nptext = stripcslashes( $post_type_settings[$post_type]['post-edited-text'] );
						$oldpost = true;
					}
				} else {
					if ( $post_type_settings[$post_type]['post-published-update'] == '1' ) {
						$nptext = stripcslashes( $post_type_settings[$post_type]['post-published-text'] );	
						$newpost = true;
					}
				}
			}
			if ($newpost || $oldpost) {
				$sentence = ( $customTweet != "" ) ? $customTweet : $nptext;
				if ($post_info['shortUrl'] != '') {
					$shrink = $post_info['shortUrl'];
				} else {
					$shrink = jd_shorten_link( $post_info['postLink'], $post_info['postTitle'], $post_ID );
					store_url( $post_ID, $shrink );
				}
				$sentence = jd_truncate_tweet( $sentence, $post_info, $shrink, $post_ID );
				/* vestigial qtrans support
				$regex="/<!--:[a-z]+-->(.*)<!--:-->/U";
				//Return all the languages in the posttitle 
				preg_match_all($regex,$jd_post_info['postTitle'],$matches,PREG_PATTERN_ORDER);
				*/
			}
			if ( $sentence != '' ) {
				if ( get_option('jd_twit_cats') == '1' ) {
					$continue = ( !in_allowed_category( $post_info['categoryIds'] ) )?true:false;
				} else {
					$continue = ( in_allowed_category( $post_info['categoryIds'] ) )?true:false;
				}
				if ( get_option('limit_categories') == '0' ) { $continue = true; }
				if ( $continue ) {
					// WPT PRO //
					if ( function_exists( 'wpt_pro_exists' ) ) {
						$auth = $post_info['authId'];
						$user = get_userdata( $auth );
						$auth_verified = wtt_oauth_test( $auth,'verify' );
						if ( $post_info['wpt_delay_tweet'] == 0 || $post_info['wpt_no_delay'] == 'on' ) {
							$sendToTwitter = jd_doTwitterAPIPost( $sentence, $auth );
							if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
								$offset = rand(60,240);	// delay co-tweet by 1-4 minutes.
								wp_schedule_single_event( time()+$offset, 'wpt_schedule_tweet_action', array( 'id'=>false, 'sentence'=>$sentence, 'rt'=>0 ) );
							}
						} else {
							$time = ( (int) $post_info['wpt_delay_tweet'] )*60;
							wp_schedule_single_event( time()+$time, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$sentence, 'rt'=>0 ) );
							if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
								$offset = rand(60,240);	// delay co-tweet by 1-4 minutes.						
								wp_schedule_single_event( time()+$time+$offset, 'wpt_schedule_tweet_action', array( 'id'=>false, 'sentence'=>$sentence, 'rt'=>0 ) );
							}
							$sendToTwitter = true;
						}
						if ( $post_info['wpt_retweet_after'] != 0 && $post_info['wpt_no_repost'] != 'on' ) {
							$repeat = $post_info['wpt_retweet_repeat'];
							for ( $i=1;$i<=$repeat;$i++ ) {
								if ( $i == 1 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}
								if ( $i == 2 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt2');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt2');								
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}
								if ( $i == 3 ) { 
									$retweet = $sentence; 
								}
								if ( $i == 4 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');								
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}
								$time = ($post_info['wpt_retweet_after'])*(60*60)*$i;
								wp_schedule_single_event( time()+$time, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$retweet, 'rt'=>$i ) );
								if ( $post_info['wpt_cotweet'] == 1 && $auth_verified ) {
									$offset = rand(60,240); // delay each co-tweet by 1-4 minutes
									wp_schedule_single_event( time()+$time+$offset, 'wpt_schedule_tweet_action', array( 'id'=>false, 'sentence'=>$retweet, 'rt'=>$i ) );
								}
								$sendToTwitter = true;
								if ( $i == 4 ) { break; }
							}
						}
					} else {
						$sendToTwitter = jd_doTwitterAPIPost( $sentence );
					}
					// END WPT PRO //
					$jwt = get_post_meta( $post_ID, '_jd_wp_twitter', true );
					if ( !is_array( $jwt ) ){ $jwt=array(); }
					$jwt[] = urldecode( $sentence );
					$_POST['_jd_wp_twitter'] = $jwt;
					update_post_meta( $post_ID,'_jd_wp_twitter', $jwt );
					if ( $sendToTwitter == false ) {
						update_option( 'wp_twitter_failure','1' );
					}
				}
			}
		} else {
			return $post_ID;
		}
	}
	return $post_ID;
}


// Add Tweets on links in Blogroll
function jd_twit_link( $link_ID )  {
	wpt_check_version();
	global $wpt_version;
	$thislinkprivate = $_POST['link_visible'];
	if ($thislinkprivate != 'N') {
		$thislinkname = stripcslashes( $_POST['link_name'] );
		$thispostlink =  $_POST['link_url'] ;
		$thislinkdescription =  stripcslashes( $_POST['link_description'] );
		$sentence = stripcslashes( get_option( 'newlink-published-text' ) );
		$sentence = str_ireplace("#title#",$thislinkname,$sentence);
		$sentence = str_ireplace("#description#",$thislinkdescription,$sentence);		 

		if (mb_strlen( $sentence ) > 120) {
			$sentence = mb_substr($sentence,0,116) . '...';
		}
		$shrink = jd_shorten_link( $thispostlink, $thislinkname, $link_ID, 'link' );
			if ( stripos($sentence,"#url#") === FALSE ) {
				$sentence = $sentence . " " . $shrink;
			} else {
				$sentence = str_ireplace("#url#",$shrink,$sentence);
			}						
			if ( $sentence != '' ) {
				$sendToTwitter = jd_doTwitterAPIPost( $sentence );
				if ( $sendToTwitter == false ) { update_option('wp_twitter_failure','2'); }
			}
		return $link_ID;
	} else {
		return;
	}
}
// HANDLES xmlrpc POSTS
function jd_twit_xmlrpc( $post_ID ) {
	wpt_check_version();
	
	$post_info = jd_post_info( $post_ID );	
	$post_type = $post_info['postType'];
	$settings = get_option('wpt_post_types');
	$post_types = array_keys($settings);
	// if the post modified date and the post date are the same, this is new.
	$new = wpt_date_compare( $post_info['_postModified'], $post_info['_postDate'] );
	if ( in_array( $post_type, $post_types ) ) {		
		$sentence = '';	
		if ( get_option('jd_tweet_default') != '1' && get_option('jd_twit_remote') == '1' ) {
			$poststatus = $post_info['postStatus'];
			if ( $poststatus == 'publish' ) {
				if ( $new === 1 && $settings[$post_type]['post-published-update'] == '1' ) {
					$sentence = stripcslashes( $settings[$post_type]['post-published-text'] );
				} else if ( $new === 0 && $settings[$post_type]['post-edited-update'] == '1' && get_option( 'jd_tweet_default_edit' ) != '1' ) {
					$sentence = stripcslashes( $settings[$post_type]['post-edited-text'] );
				} else {
					return;
				}
			} else {
				return;
			}
			$shrink = jd_shorten_link( $post_info['postLink'], $post_info['postTitle'], $post_ID );
			// Stores the short URL in a custom field for later use as needed.
			store_url($post_ID, $shrink);				
			// Check the length of the Tweet and truncate parts as necessary.
			$sentence = jd_truncate_tweet( $sentence, $post_info, $shrink, $post_ID );
			if ( $sentence != '' ) {	
				if ( get_option('jd_twit_cats') == '1' ) {
					$continue = ( !in_allowed_category( $post_info['categoryIds'] ) )?true:false;
				} else {
					$continue = ( in_allowed_category( $post_info['categoryIds'] ) )?true:false;				
				}
				if ( get_option('limit_categories') == '0' ) { $continue = true; }
				if ( $continue ) {
					// WPT PRO //
					if ( function_exists( 'wpt_pro_exists' ) ) {
						$auth = $post_info['authId'];
						$user = get_userdata( $auth );
						//if ( user_can( $user, 'update_core' ) ) { $auth = false; } // This is the super admin. No, it's not.
						if ( $post_info['wpt_delay_tweet'] == 0 || $post_info['wpt_no_delay'] == 'on' ) {
							$sendToTwitter = jd_doTwitterAPIPost( $sentence, $auth );
						} else {
							$time = ( (int) $post_info['wpt_delay_tweet'] )*60;
							wp_schedule_single_event( time()+$time, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$sentence, 'rt'=>0 ) );
							$sendToTwitter = true;
						}
						if ( $post_info['wpt_retweet_after'] != 0 && $post_info['wpt_no_repost'] != 'on' ) {
							$repeat = $post_info['wpt_retweet_repeat'];
							for ( $i=1;$i<=$repeat;$i++ ) {
								if ( $i == 1 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}
								if ( $i == 2 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt2');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt2');								
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}
								if ( $i == 3 ) { 
									$retweet = $sentence; 
								}
								if ( $i == 4 ) { 
									$prepend = ( get_option('wpt_prepend') == 1 )?'':get_option('wpt_prepend_rt');
									$append = ( get_option('wpt_prepend') != 1 )?'':get_option('wpt_prepend_rt');								
									$retweet = jd_truncate_tweet( trim( $prepend.$sentence.$append ), $post_info, $shrink, $post_ID,true ); 
								}								$time = ($post_info['wpt_retweet_after'])*(60*60)*$i;
								wp_schedule_single_event( time()+$time, 'wpt_schedule_tweet_action', array( 'id'=>$auth, 'sentence'=>$retweet, 'rt'=>$i ) );
								$sendToTwitter = true;
								if ( $i == 4 ) { break; }
							}
						}
					} else {
						$sendToTwitter = jd_doTwitterAPIPost( $sentence );
					}
					// END WPT PRO //			
					$sendToTwitter = jd_doTwitterAPIPost( $sentence );
					$jwt = get_post_meta( $post_ID, '_jd_wp_twitter', true );
					if ( !is_array( $jwt ) ){ $jwt=array(); }					
					$jwt[] = urldecode( $sentence );
					update_post_meta( $post_ID,'_jd_wp_twitter', $jwt );					
					if ($sendToTwitter == false ) {
						update_option('wp_twitter_failure','1');
					}
				}				
			}
		}
	return $post_ID;
	}
} // END jd_twit_xmlrpc

// Add comment Tweet function from Luis Nobrega
function jd_twit_comment( $comment_id, $approved ) {	
	$_t = get_comment( $comment_id );
	$post_ID = $_t->comment_post_ID;
	$commenter = $_t->comment_author;
	$jd_tweet_this = get_post_meta( $post_ID, '_jd_tweet_this', TRUE );
	if ( $jd_tweet_this != 'no' && $_t->comment_approved == 1 ) { // comments only tweeted on posts which are tweeted
		$post_info = jd_post_info( $post_ID );
		$sentence = '';
		$sentence = stripcslashes( get_option( 'comment-published-text' ) );
		if ( $post_info['shortUrl'] != '' ) {
			$shrink = $post_info['shortUrl'];
		} else {
			$shrink = jd_shorten_link( $post_info['postLink'], $post_info['postTitle'], $post_ID );
			store_url( $post_ID, $shrink );
		}		
		$sentence = jd_truncate_tweet( $sentence, $post_info, $shrink, $post_ID );
		$sentence = str_replace("#commenter#",$commenter,$sentence);
		if ( $sentence != '' ) {
			$sendToTwitter = jd_doTwitterAPIPost( $sentence );
		}
	}
	return $post_ID;
}

add_action('admin_menu','jd_add_twitter_outer_box');

function store_url($post_ID, $url) {
	$shortener = get_option( 'jd_shortener' );
	switch ($shortener) {
		case 0:	case 1:	case 4: $ext = '_wp';break;
		case 2:	$ext = '_bitly';break;
		case 3:	$ext = '_url';break;
		case 5:	case 6:	$ext = '_yourls';break;
		case 7:	$ext = '_supr';	break;
		case 8:	$ext = '_goo';	break;
		default:$ext = '_ind';
	}
	if ( get_post_meta ( $post_ID, "_wp_jd$ext", TRUE ) != $url ) {
		update_post_meta ( $post_ID, "_wp_jd$ext", $url );
	}
	switch ( $shortener ) {
		case 0: case 1: case 2: case 7: case 8: $target = jd_expand_url( $url );break;
		case 5: case 6: $target = jd_expand_yourl( $url, $shortener );break;
		default: $target = $url;
	}
	update_post_meta( $post_ID, '_wp_jd_target', $target );
}

function generate_hash_tags( $post_ID ) {
	$hashtags = '';
	$max_tags = get_option( 'jd_max_tags' );
	$max_characters = get_option( 'jd_max_characters' );
	$max_characters = ( $max_characters == 0 || $max_characters == "" )?100:$max_characters + 1;
	if ($max_tags == 0 || $max_tags == "") { $max_tags = 100; }
		$tags = get_the_tags( $post_ID );
		if ( $tags > 0 ) {
		$i = 1;
			foreach ( $tags as $value ) {
			$tag = $value->name;
			$replace = get_option( 'jd_replace_character' );
			$strip = get_option( 'jd_strip_nonan' );
			$search = "/[^a-zA-Z0-9]/";
			if ($replace == "[ ]") { $replace = ""; }
			$tag = str_ireplace( " ",$replace,trim( $tag ) );
			if ($strip == '1') { $tag = preg_replace( $search, $replace, $tag ); }
			if ($replace == "" || !$replace) { $replace = "_"; }
				$newtag = "#$tag";
					if ( mb_strlen( $newtag ) > 2 && (mb_strlen( $newtag ) <= $max_characters) && ($i <= $max_tags) ) {
					$hashtags .= "$newtag ";
					$i++;
					}
			}
		}
	$hashtags = trim( $hashtags );
	if ( mb_strlen( $hashtags ) <= 1 ) { $hashtags = ""; }		
	return $hashtags;	
}

function jd_add_twitter_old_box() {
?>
<div class="dbx-b-ox-wrapper">
	<fieldset id="twitdiv" class="dbx-box">
		<div class="dbx-h-andle-wrapper">
		<h3 class="dbx-handle"><?php _e('WP Tweets', 'wp-to-twitter', 'wp-to-twitter') ?></h3>
		</div>
		<div class="dbx-c-ontent-wrapper">
			<div class="dbx-content">
			<?php jd_add_twitter_inner_box(); ?>
			</div>
		</div>
	</fieldset>
</div>
<?php
}

function jd_add_twitter_inner_box() {
global $post, $jd_plugin_url, $jd_donate_url;
	$post_length = 140;
	$wpt_settings = get_option('wpt_post_types');
	$post_id = $post;
	if ( is_object( $post_id ) ) {
		$type = $post_id->post_type;
		$status = $post_id->post_status;
		$post_id = $post_id->ID;
	} else {
		$post = get_post( $post_id );
		$type = $post->post_type;
		$status = $post->post_status;
	}
	if ( get_post_meta ( $post_id, "_jd_post_meta_fixed", true ) != 'true' ) {
		jd_fix_post_meta( $post_id );
	}
	$jd_twitter = esc_attr( stripcslashes( get_post_meta($post_id, '_jd_twitter', true ) ) );
	$jd_template = ( $status == 'publish' )?$wpt_settings[$type]['post-edited-text']:$wpt_settings[$type]['post-published-text'];
	$jd_tweet_this = get_post_meta( $post_id, '_jd_tweet_this', true );
	if ( $jd_tweet_this == '' ) { $jd_tweet_this = (get_option( 'jd_tweet_default' ) == '1' )?'no':'yes'; } // JCD TODO
	$jd_short = get_post_meta( $post_id, '_wp_jd_clig', true );
	$sht = "Cli.gs";
		if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_supr', true );	$sht = "Su.pr";	}
		if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_ind', true );	$sht = "other";	}		
		if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_bitly', true );$sht = "Bit.ly";}
		if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_wp', true );	$sht = "WordPress";}	
		if ( $jd_short == "" ) {$jd_short = get_post_meta( $post_id, '_wp_jd_yourls', true );$sht = "YOURLS";}
		if ( $jd_short == "" ) {$jd_direct = get_post_meta( $post_id, '_wp_jd_url', true );}
	$jd_expansion = get_post_meta( $post_id, '_wp_jd_target', true );
	$previous_tweets = get_post_meta ( $post_id, '_jd_wp_twitter', true );
	?>
<?php if ( !is_array( $previous_tweets ) && $previous_tweets != '' ) { $previous_tweets = array( 0=>$previous_tweets ); } ?>
<?php if ( ! empty( $previous_tweets ) ) { ?>

<p class='error'><strong><?php _e('Previous Tweets','wp-to-twitter'); ?>:</strong></p>
<ul>
<?php
$hidden_fields = '';
	foreach ( $previous_tweets as $previous_tweet ) {
		if ( $previous_tweet != '' ) {
			$hidden_fields .= "<input type='hidden' name='_jd_wp_twitter[]' value='".esc_attr($previous_tweet)."' />";
			echo "<li>$previous_tweet <a href='http://twitter.com/intent/tweet?text=$previous_tweet'>Retweet this</a></li>";
		}
	}
?>
</ul>
<?php echo "<div>".$hidden_fields."</div>"; } ?>
<?php if ( current_user_can('update_core') ) { ?> <strong><a target="__blank" href="<?php echo $jd_donate_url; ?>"><?php _e('You could do more! Take a look at WP Tweets Pro!', 'wp-to-twitter', 'wp-to-twitter') ?></a></strong> <?php } ?>
<?php if ( current_user_can( 'wpt_twitter_custom' ) || current_user_can('update_core') ) { ?>
<p class='jtw'>
<label for="jtw"><?php _e("Custom Twitter Post", 'wp-to-twitter', 'wp-to-twitter') ?></label><br /><textarea class="attachmentlinks" name="_jd_twitter" id="jtw" rows="2" cols="60"><?php echo esc_attr( $jd_twitter ); ?></textarea>
</p>
<p><?php _e('Your template:','wp-to-twitter'); ?> <code><?php echo stripcslashes( $jd_template ); ?></code></p>
<?php 
	if ( get_option('jd_keyword_format') == 2 ) {
		$custom_keyword = get_post_meta( $post_id, '_yourls_keyword', true );
		echo "<label for='yourls_keyword'>".__('YOURLS Custom Keyword','wp-to-twitter')."</label> <input type='text' name='_yourls_keyword' id='yourls_keyword' value='$custom_keyword' />";
	}
?>
<?php } ?>
<?php if ( current_user_can( 'wpt_twitter_custom' ) || current_user_can( 'wpt_twitter_switch' ) || current_user_can('update_core') ) { ?>
<?php
	// "no" means 'Don't Tweet' (is checked)
	$nochecked = ( $jd_tweet_this == 'no' )?' checked="checked"':'';
	$yeschecked = ( $jd_tweet_this == 'yes' )?' checked="checked"':'';
?>
<p><input type="radio" name="_jd_tweet_this" value="no" id="jtn"<?php echo $nochecked; ?> /> <label for="jtn"><?php _e("Don't Tweet this post.", 'wp-to-twitter'); ?></label> <input type="radio" name="_jd_tweet_this" value="yes" id="jty"<?php echo $yeschecked; ?> /> <label for="jty"><?php _e("Tweet this post.", 'wp-to-twitter'); ?></label></p>
<?php } ?>
<?php /* WPT PRO */ ?>
<?php 
if ( function_exists('wpt_pro_exists') ) { 
	wpt_schedule_values( $post_id ); 
} ?>
<?php /* WPT PRO */ ?>
<?php if ( !current_user_can( 'wpt_twitter_custom' ) || !current_user_can( 'wpt_twitter_switch' ) ) { ?>
<div>
<p><?php _e('Access to customizing WP to Twitter values is not allowed for your user role.','wp-to-twitter'); ?></p>
<?php if ( !current_user_can( 'wpt_twitter_switch' ) ) { ?>
<input type="hidden" name='_jd_tweet_this' value='<?php echo $jd_tweet_this; ?>' />
<?php } ?>
<input type="hidden" name='_jd_twitter' value='' />
<?php 
if ( function_exists('wpt_pro_exists') ) { 
	wpt_schedule_values( $post_id, 'hidden' ); 
} ?>
</div>
<?php } ?>
<p>
<?php
$this_post = get_post($post_id);
$post_status = $this_post->post_status;
if ($post_status == 'publish') {
	if ( $jd_short != "" ) {
		_e("The previously-posted $sht URL for this post is <code>$jd_short</code>, which points to <code>$jd_expansion</code>.", 'wp-to-twitter');
	} else {
		_e("This URL is direct and has not been shortened: ","wp-to-twitter"); echo "<code>$jd_direct</code>";
	}
}
?>
</p>
<p>
<?php _e("Twitter posts are a maximum of 140 characters; Twitter counts URLs as 19 characters. Template tags: <code>#url#</code>, <code>#title#</code>, <code>#post#</code>, <code>#category#</code>, <code>#date#</code>, <code>#modified#</code>, <code>#author#</code>, <code>#account#</code>, <code>#tags#</code>, or <code>#blog#</code>.", 'wp-to-twitter') ?> 
</p>
<p>
<?php if ( !function_exists( 'wpt_pro_exists' ) ) { ?>
<a target="_blank" href="<?php echo admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php'); ?>#get-support"><?php _e('Get Support', 'wp-to-twitter', 'wp-to-twitter') ?></a> &bull; <strong><a target="__blank" href="<?php echo $jd_donate_url; ?>"><?php _e('Upgrade to WP Tweets Pro', 'wp-to-twitter', 'wp-to-twitter') ?></a></strong> &raquo;
<?php } else { ?>
<a target="_blank" href="<?php echo admin_url('admin.php?page=wp-tweets-pro'); ?>#get-support"><?php _e('Get Support', 'wp-to-twitter', 'wp-to-twitter') ?></a> &raquo;
<?php } ?>
</p>
<?php } 
function jd_add_twitter_outer_box() {
	wpt_check_version();
	$wpt_post_types = get_option('wpt_post_types');
	if ( function_exists( 'add_meta_box' )) {
		if ( is_array( $wpt_post_types ) ) {
			foreach ($wpt_post_types as $key=>$value) {
				if ( $value['post-published-update'] == 1 || $value['post-edited-update'] == 1 ) {
					add_meta_box( 'wptotwitter_div','WP to Twitter', 'jd_add_twitter_inner_box', $key, 'advanced' );
				}
			}
		}
	}
}

function jd_fix_post_meta( $post_id ) {
	$oldmeta = array('jd_tweet_this','jd_twitter','wp_jd_clig','wp_jd_bitly','wp_jd_wp','wp_jd_yourls','wp_jd_url','wp_jd_target','jd_wp_twitter');
	foreach ($oldmeta as $value) {
		$old_value = get_post_meta($post_id,$value,true);
		update_post_meta( $post_id, "_$value", $old_value );
		delete_post_meta( $post_id, $value );
	}
	if ( $post_id != 0 ) {
	add_post_meta( $post_id, "_jd_post_meta_fixed",'true' );
	}
}

function wpt_admin_scripts( $hook ) {
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		wp_enqueue_script(  'charCount', plugins_url( 'wp-to-twitter/js/jquery.charcount.js'), array('jquery') );
    }
}
add_action( 'admin_enqueue_scripts', 'wpt_admin_scripts', 10, 1 );

function wpt_admin_script( $hook ) {
global $current_screen;
if ( $current_screen->base == 'post' ) {
echo "
<script type='text/javascript'>
	jQuery(document).ready(function(\$){	
		//default usage
		\$('#jtw').charCount( { counterText: '".__('Characters left: ','wp-to-twitter')."' } );
	});
</script>
<style type='text/css'>
#wptotwitter_div .jtw{ position: relative; padding-bottom: 1.4em;}
#wptotwitter_div .counter{
	position:absolute;right:4%;bottom:0;
	font-size:1.3em;font-weight:700;color:#666;
}
#wptotwitter_div .warning{color:#700;}	
#wptotwitter_div .exceeded{color:#e00;}	
</style>";
	}
}
add_action( 'admin_head', 'wpt_admin_script' );

// Post the Custom Tweet into the post meta table
function post_jd_twitter( $id ) {
	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) { return $id; }
	if ( isset($_POST['_inline_edit']) ) { return $id; }
	// update meta data to new format
	if ( get_post_meta ( $id, "_jd_post_meta_fixed", true ) != 'true' ) {
		jd_fix_post_meta( $id );
	}
	if ( isset( $_POST['_yourls_keyword'] ) ) {
		$yourls = $_POST[ '_yourls_keyword' ];
		update_post_meta( $id, '_yourls_keyword', $yourls );			
	}
	if ( isset( $_POST[ '_jd_twitter' ] ) && $_POST['_jd_twitter'] != '' ) {
		$jd_twitter = $_POST[ '_jd_twitter' ];
		update_post_meta( $id, '_jd_twitter', $jd_twitter );
	} 
	if ( isset( $_POST[ '_jd_wp_twitter' ] ) && $_POST['_jd_wp_twitter'] != '' ) {
		$jd_wp_twitter = $_POST[ '_jd_wp_twitter' ];
		update_post_meta( $id, '_jd_wp_twitter', $jd_wp_twitter );
	}
	if ( isset( $_POST[ '_jd_tweet_this' ] ) ) {
		$jd_tweet_this = ( $_POST[ '_jd_tweet_this' ] == 'no')?'no':'yes';
		update_post_meta( $id, '_jd_tweet_this', $jd_tweet_this );
	} else {
		if ( isset($_POST['_wpnonce'] ) ) {
			$jd_tweet_default = ( get_option( 'jd_tweet_default' ) == 1 )?'no':'yes';
			update_post_meta( $id, '_jd_tweet_this', $jd_tweet_default );
		}
	}
	// WPT PRO //
	apply_filters( 'wpt_insert_post', $_POST, $id );
	// WPT PRO //	
}

function jd_twitter_profile() {
	global $user_ID;
	get_currentuserinfo();
	if ( current_user_can( 'wpt_twitter_oauth' ) || current_user_can('update_core') ) {
		$user_edit = ( isset($_GET['user_id']) )?(int) $_GET['user_id']:$user_ID; 

		$is_enabled = get_user_meta( $user_edit, 'wp-to-twitter-enable-user',true );
		$twitter_username = get_user_meta( $user_edit, 'wp-to-twitter-user-username',true );
		?>
		<h3><?php _e('WP Tweets User Settings', 'wp-to-twitter'); ?></h3>
		<?php if ( function_exists('wpt_connect_oauth_message') ) { wpt_connect_oauth_message( $user_edit ); } ?>
		<table class="form-table">
		<tr>
			<th scope="row"><?php _e("Use My Twitter Username", 'wp-to-twitter'); ?></th>
			<td><input type="radio" name="wp-to-twitter-enable-user" id="wp-to-twitter-enable-user-3" value="mainAtTwitter"<?php if ($is_enabled == "mainAtTwitter") { echo " checked='checked'"; } ?> /> <label for="wp-to-twitter-enable-user-3"><?php _e("Tweet my posts with an @ reference to my username.", 'wp-to-twitter'); ?></label><br />
			<input type="radio" name="wp-to-twitter-enable-user" id="wp-to-twitter-enable-user-4" value="mainAtTwitterPlus"<?php if ($is_enabled == "mainAtTwitterPlus") { echo " checked='checked'"; } ?> /> <label for="wp-to-twitter-enable-user-3"><?php _e("Tweet my posts with an @ reference to both my username and to the main site username.", 'wp-to-twitter'); ?></label>
			</td>
		</tr>
		<tr>
			<th scope="row"><label for="wp-to-twitter-user-username"><?php _e("Your Twitter Username", 'wp-to-twitter'); ?></label></th>
			<td><input type="text" name="wp-to-twitter-user-username" id="wp-to-twitter-user-username" value="<?php echo esc_attr( $twitter_username ); ?>" /> <?php _e('Enter your own Twitter username.', 'wp-to-twitter'); ?></td>
		</tr>
		</table>
		<?php if ( function_exists('wpt_schedule_tweet') ) { ?>
		<?php if ( function_exists('wtt_connect_oauth') ) { wtt_connect_oauth( $user_edit ); } ?>
		<?php if ( user_can( $user_edit, 'update_core' ) ) { echo "<p><em>".__('Note: if all site administrators have set-up their own Twitter accounts, the primary site account (as set on the settings page) is not required, and won\'t be used.','wp-to-twitter').'</em></p>'; } ?>
		<?php } ?>

<?php
	}
}

function custom_shortcodes( $sentence, $post_ID ) {
	$pattern = '/([([\[\]?)([A-Za-z0-9-_])*(\]\]]?)+/';
	$params = array(0=>"[[",1=>"]]");
	preg_match_all($pattern,$sentence, $matches);
	if ($matches && is_array($matches[0])) {
		foreach ($matches[0] as $value) {
			$shortcode = "$value";
			$field = str_replace($params, "", $shortcode);
			$custom = strip_tags(get_post_meta( $post_ID, $field, TRUE ));
			$sentence = str_replace( $shortcode, $custom, $sentence );
		}
		return $sentence;
	} else {
		return $sentence;
	}
}
	
function jd_twitter_save_profile(){
	global $user_ID;
	get_currentuserinfo();
	if ( isset($_POST['user_id']) ) {
		$edit_id = (int) $_POST['user_id']; 
	} else {
		$edit_id = $user_ID;
	}
	update_user_meta($edit_id ,'wp-to-twitter-enable-user' , $_POST['wp-to-twitter-enable-user'] );
	update_user_meta($edit_id ,'wp-to-twitter-user-username' , $_POST['wp-to-twitter-user-username'] );
	//WPT PRO
	apply_filters( 'wpt_save_user', $edit_id, $_POST );
}
function jd_list_categories() {
	$selected = "";
	$categories = get_categories('hide_empty=0');
	$nonce = wp_nonce_field('wp-to-twitter-nonce', '_wpnonce', true, false).wp_referer_field(false);
	$input = "<form action=\"\" method=\"post\">
	<div>$nonce</div>
	<fieldset><legend>".__('Check off categories to tweet','wp-to-twitter')."</legend>";
	$input .= '
	<p>
	<input type="checkbox" name="jd_twit_cats" id="jd_twit_cats" value="1"'.jd_checkCheckbox('jd_twit_cats').' />
	<label for="jd_twit_cats">'.__("Do not tweet posts in checked categories (Reverses default behavior)", 'wp-to-twitter').'</label>
	</p>';
	$input .= "
	<ul>\n";
	$tweet_categories =  get_option( 'tweet_categories' );
		foreach ($categories AS $cat) {
			if (is_array($tweet_categories)) {
				if (in_array($cat->term_id,$tweet_categories)) {
					$selected = " checked=\"checked\"";
				} else {
					$selected = "";
				}
			}
			$input .= '		<li><input'.$selected.' type="checkbox" name="categories[]" value="'.$cat->term_id.'" id="'.$cat->category_nicename.'" /> <label for="'.$cat->category_nicename.'">'.$cat->name."</label></li>\n";
		}
	$input .= "	</ul>
	</fieldset>
	<p>".__('Limits are exclusive. If a post is in one category which should be posted and one category that should not, it will not be posted.','wp-to-twitter')."</p>
	<div>
	<input type=\"hidden\" name=\"submit-type\" value=\"setcategories\" />
	<input type=\"submit\" name=\"submit\" class=\"button-primary\" value=\"".__('Set Categories','wp-to-twitter')."\" />
	</div>
	</form>";
	echo $input;
}

// Add the administrative settings to the "Settings" menu.
function jd_addTwitterAdminPages() {
    if ( function_exists( 'add_options_page' ) && !function_exists( 'wpt_pro_functions') ) {
		 $plugin_page = add_options_page( 'WP to Twitter', 'WP to Twitter', 'manage_options', __FILE__, 'wpt_update_settings' );
		 add_action( 'admin_head-'. $plugin_page, 'jd_addTwitterAdminStyles' );
    }
}

function jd_addTwitterAdminStyles() {
global $wp_plugin_url, $wp_plugin_dir;
	if ( $_GET['page'] == "wp-to-twitter" || $_GET['page'] == "wp-to-twitter/wp-to-twitter.php" || $_GET['page'] == "wp-tweets-pro" ) {
		echo '<link type="text/css" rel="stylesheet" href="'.$wp_plugin_url.'/wp-to-twitter/styles.css" />';
	}
}

function jd_plugin_action($links, $file) {
	if ( $file == plugin_basename(dirname(__FILE__).'/wp-to-twitter.php') ) {
		$admin_url = ( is_plugin_active('wp-tweets-pro/wpt-pro-functions.php') )?admin_url('admin.php?page=wp-tweets-pro'):admin_url('options-general.php?page=wp-to-twitter/wp-to-twitter.php');
		$links[] = "<a href='$admin_url'>" . __('Settings', 'wp-to-twitter', 'wp-to-twitter') . "</a>";
	}
	return $links;
}
//Add Plugin Actions to WordPress
add_filter('plugin_action_links', 'jd_plugin_action', -10, 2);

if ( get_option( 'jd_individual_twitter_users')=='1') {
	add_action( 'show_user_profile', 'jd_twitter_profile' );
	add_action( 'edit_user_profile', 'jd_twitter_profile' );
	add_action( 'profile_update', 'jd_twitter_save_profile');
}

if ( get_option( 'disable_url_failure' ) != '1' ) {
	if ( get_option( 'wp_url_failure' ) == '1' ) {
		add_action('admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } echo '<div class=\"error\"><p>';_e('There\'s been an error shortening your URL! <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=wp-to-twitter/wp-to-twitter.php\">Visit your WP to Twitter settings page</a> to get more information and to clear this error message.','wp-to-twitter'); echo '</p></div>';" ) );
	}
}
if ( get_option( 'disable_twitter_failure' ) != '1' ) {
	if ( get_option( 'wp_twitter_failure' ) == '1' ) {
		add_action('admin_notices', create_function( '', "if ( ! current_user_can( 'manage_options' ) ) { return; } echo '<div class=\"error\"><p>';_e('There\'s been an error posting your Twitter status! <a href=\"".get_bloginfo('wpurl')."/wp-admin/options-general.php?page=wp-to-twitter/wp-to-twitter.php\">Visit your WP to Twitter settings page</a> to get more information and to clear this error message.','wp-to-twitter'); echo '</p></div>';" ) );
	}
}

add_action( 'in_plugin_update_message-wp-to-twitter/wp-to-twitter.php', 'wpt_plugin_update_message' );
function wpt_plugin_update_message() {
	global $wpt_version;
	$note = '';
	define('WPT_PLUGIN_README_URL',  'http://svn.wp-plugins.org/wp-to-twitter/trunk/readme.txt');
	$response = wp_remote_get( WPT_PLUGIN_README_URL, array ('user-agent' => 'WordPress/WP to Twitter' . $wpt_version . '; ' . get_bloginfo( 'url' ) ) );
	if ( ! is_wp_error( $response ) || is_array( $response ) ) {
		$data = $response['body'];
		$bits=explode('== Upgrade Notice ==',$data);
		$note = '<div id="wpt-upgrade"><p><strong style="color:#c22;">Upgrade Notes:</strong> '.nl2br(trim($bits[1])).'</p></div>';
	} else {
		printf(__('<br /><strong>Note:</strong> Please review the <a class="thickbox" href="%1$s">changelog</a> before upgrading.','wp-to-twitter'),'plugin-install.php?tab=plugin-information&amp;plugin=wp-to-twitter&amp;TB_iframe=true&amp;width=640&amp;height=594');
	}
	echo $note;
}

add_action( 'save_post','post_jd_twitter', 10 );

if ( get_option( 'jd_twit_blogroll' ) == '1' ) {
	add_action( 'add_link', 'jd_twit_link' );
}
	$post_type_settings = get_option('wpt_post_types');
	if ( is_array( $post_type_settings ) ) {
		$post_types = array_keys($post_type_settings);
		foreach ($post_types as $value ) {
			add_action( 'publish_'.$value, 'jd_twit', 16 );		
		}
	}

if ( get_option( 'jd_twit_remote' ) == '1' ) {
	add_action( 'xmlrpc_publish_post', 'jd_twit_xmlrpc' ); 
	add_action( 'app_publish_post', 'jd_twit_xmlrpc' ); 
	add_action( 'publish_phone', 'jd_twit_xmlrpc' ); // to add later
}
if ( get_option('comment-published-update') == 1 ) {
	add_action( 'comment_post', 'jd_twit_comment', 10, 2 );
}
add_action( 'admin_menu', 'jd_addTwitterAdminPages' );