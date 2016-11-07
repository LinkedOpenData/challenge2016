<?php
/*
 * Abraham Williams (abraham@abrah.am) http://abrah.am
 *
 * The first PHP Library to support WPOAuth for Twitter's REST API.
 *
 */

/* Load WPOAuth lib. You can find it at http://WPOAuth.net */
require_once('WP_OAuth.php');

if (!class_exists('jd_TwitterOAuth')) {

/**
 * Twitter WPOAuth class
 */
class jd_TwitterOAuth {
  /* Contains the last HTTP status code returned */
  public $http_code;
  /* Contains the last API call. */
  public $url;
  /* Set up the API root URL. */
  public $host = "http://api.twitter.com/1/";
  /* Set timeout default. */
  public $format = 'json';
  /* Decode returned json data. */
  public $decode_json = false;
  /* Contains the last API call */
  private $last_api_call;
  /* containe the header */
  public $http_header;

  /**
   * Set API URLS
   */
  function accessTokenURL()  { return "http://api.twitter.com/oauth/access_token"; }
  function authenticateURL() { return "http://api.twitter.com/oauth/authenticate"; }
  function authorizeURL()    { return "http://api.twitter.com/oauth/authorize"; }
  function requestTokenURL() { return "http://api.twitter.com/oauth/request_token"; }

  /**
   * Debug helpers
   */
  function lastStatusCode() { return $this->http_code; }
  function lastAPICall() { return $this->last_api_call; }

  /**
   * construct TwitterWPOAuth object
   */
  function __construct($consumer_key, $consumer_secret, $WPOAuth_token = NULL, $WPOAuth_token_secret = NULL) {
    $this->sha1_method = new WPOAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new WPOAuthConsumer($consumer_key, $consumer_secret);
    if (!empty($WPOAuth_token) && !empty($WPOAuth_token_secret)) {
      $this->token = new WPOAuthConsumer($WPOAuth_token, $WPOAuth_token_secret);
    } else {
      $this->token = NULL;
    }
  }


  /**
   * Get a request_token from Twitter
   *
   * @returns a key/value array containing WPOAuth_token and WPOAuth_token_secret
   */
  function getRequestToken() {
    $r = $this->WPOAuthRequest($this->requestTokenURL());
    $token = $this->WPOAuthParseResponse($r);
    $this->token = new WPOAuthConsumer($token['WPOAuth_token'], $token['WPOAuth_token_secret']);
    return $token;
  }

  /**
   * Parse a URL-encoded WPOAuth response
   *
   * @return a key/value array
   */
  function WPOAuthParseResponse($responseString) {
    $r = array();
    foreach (explode('&', $responseString) as $param) {
      $pair = explode('=', $param, 2);
      if (count($pair) != 2) continue;
      $r[urldecode($pair[0])] = urldecode($pair[1]);
    }
    return $r;
  }

  /**
   * Get the authorize URL
   *
   * @returns a string
   */
  function getAuthorizeURL($token) {
    if (is_array($token)) $token = $token['WPOAuth_token'];
    return $this->authorizeURL() . '?WPOAuth_token=' . $token;
  }


  /**
   * Get the authenticate URL
   *
   * @returns a string
   */
  function getAuthenticateURL($token) {
    if (is_array($token)) $token = $token['WPOAuth_token'];
    return $this->authenticateURL() . '?WPOAuth_token=' . $token;
  }
  
  /**
   * Exchange the request token and secret for an access token and
   * secret, to sign API calls.
   *
   * @returns array("WPOAuth_token" => the access token,
   *                "WPOAuth_token_secret" => the access secret)
   */
  function getAccessToken($token = NULL) {
    $r = $this->WPOAuthRequest($this->accessTokenURL());
    $token = $this->WPOAuthParseResponse($r);
    $this->token = new WPOAuthConsumer($token['WPOAuth_token'], $token['WPOAuth_token_secret']);
    return $token;
  }
/**
* Wrapper for POST requests
*/
    function post($url, $parameters = array()) {
    $response = $this->WPOAuthRequest( $url,$parameters,'POST' );
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }
/**
* Wrapper for GET requests
*/
    function get($url, $parameters = array()) {
    $response = $this->WPOAuthRequest( $url,$parameters,'GET' );
    if ($this->format === 'json' && $this->decode_json) {
      return json_decode($response);
    }
    return $response;
  }  
  /**
   * Format and sign an WPOAuth / API request
   */
  function WPOAuthRequest($url, $args = array(), $method = NULL) {
    if (empty($method)) $method = empty($args) ? "GET" : "POST";
    $req = WPOAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $args);
    $req->sign_request($this->sha1_method, $this->consumer, $this->token);
    
    $response = false;
    $url = null;
    
    switch ($method) {
    case 'GET': 
    	$url = $req->to_url();
       	$response = wp_remote_get( $url );
       	break;
	case 'POST':
		$url = $req->get_normalized_http_url();
		$args = wp_parse_args($req->to_postdata());
       	$response = wp_remote_post( $url, array('body'=>$args));
       	break;
    }

	if ( is_wp_error( $response ) )	return false;

    $this->http_code = $response['response']['code']; 
    $this->last_api_call = $url;
	$this->format = 'json'; 
	$this->http_header = $response['headers'];
	
	return $response['body'];	
  } 
}
}