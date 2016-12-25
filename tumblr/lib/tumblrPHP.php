<?php

/*
TumblrPHP 1.0

By: Greg Avola (@gregavola)
Inspired By: https://github.com/abraham/twitteroauth

*/

require_once('OAuth.php');

class Tumblr {
	
	public $consumer_key;
	public $consumer_secret;
	
	public $client_key;
	public $client_secret;
	
	public $userAgent = "TumblrPHP 1.0";
	
	public $consumer;
	public $token;
	public $sha1_method;
	
	public $http_code;
			
	public $authorizeURL = "http://www.tumblr.com/oauth/authorize";
	public $requestURL = "http://www.tumblr.com/oauth/request_token";
	public $accessURL = "http://www.tumblr.com/oauth/access_token";
	public $apiBase = "http://api.tumblr.com/v2";
	
	// Construct for the Class. Consumer Key and Consumer Secret are required, however you can pass through the token if you already need them.
	
	public function __construct($consumer_key, $consumer_secret, $client_key = NULL, $client_secret = NULL) 
	{
		$this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
	    $this->consumer = new OAuthConsumer($consumer_key, $consumer_secret);
	
		$this->consumer_key = $consumer_key;
		$this->consumer_secret = $consumer_secret;
		
		$this->client_key = $client_key;
		$this->client_secret = $client_secret;
		
		if (!empty($client_key) && !empty($client_secret)) {
	      $this->token = new OAuthConsumer($client_key, $client_secret);
	    } else {
	      $this->token = NULL;
	    }

	}
	
	/**
	* Basic GET wrapper for non-oauth calls to the API
	*
	*/
	
	
	public function get($url, $params = array()) {
		
		if (sizeof($params) == 0) {
			$url = $this->apiBase . $url . "?api_key=".$this->consumer_key;
		}
		else {
			$url = $this->apiBase . $url . "?api_key=".$this->consumer_key . "&". http_build_query($params);
		}
	
		$response = $this->call($url, 'GET', $params);
		return json_decode($response);
	}
	
	/**
	* Basic GET wrapper for oauth calls to the API
	*
	*/
	
	public function oauth_get($url, $params = array()) {
		$url = $this->apiBase. $url;
		$response = $this->parseRequest($url, 'GET', $params);
		return json_decode($response);
	}
	
	/**
	* Basic POST wrapper for oauth calls to the API
	*
	*/
	
	public function oauth_post($url, $params = array()) {
		$url = $this->apiBase . $url;
		$response = $this->parseRequest($url, 'POST', $params);
		return json_decode($response);
	}
	
	/**
	* Get the authorize URL, you must pass in the $token paramater
	*
	* @returns a string
	*/
	
	function getAuthorizeURL($token) {
		
		return $this->authorizeURL . "?oauth_token=".$token;
	}
	
	/**
	* Get the Request Tokens for your request, then feed it to getAuthorizeURL
	*
	* @returns an array of request tokens
	*/
	
	function getRequestToken($oauth_callback = NULL) {
		$parameters = array();
	    if (!empty($oauth_callback)) {
	      $parameters['oauth_callback'] = $oauth_callback;
	    }
		
		$request = $this->parseRequest($this->requestURL, 'GET', $parameters);

		$token = OAuthUtil::parse_parameters($request);

		$this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
		
		return $token;
	}
	
	/**
	* Get the Access Tokens in exchange for your Request Tokens
	*
	* @returns an array of Access tokens
	*/
	
	function getAccessToken($oauth_verifier = FALSE) {
		$parameters = array();
	    if (!empty($oauth_verifier)) {
	      $parameters['oauth_verifier'] = $oauth_verifier;
	    }
	    $request = $this->parseRequest($this->accessURL, 'GET', $parameters);
	    $token = OAuthUtil::parse_parameters($request);
	    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']);
	    return $token;
	}
	
	/**
	* Simple function that returns array of access token for debug
	*
	* @returns an array of access tokens
	*/
	
	function getToken() {
		$myToken = array(
				"oauth_token" => $this->client_key,
				"oauth_token_secret" => client_secret
			);
		
		return $myToken;
	}
	
	/**
	* OAuth Parsing Request - turns the request in oAuth Request using the library. Inspired from: Inspired By: https://github.com/abraham/twitteroauth
	*
	* @returns results from the call function
	*/
		
	function parseRequest($url, $method, $parameters) {
		
		$request = OAuthRequest::from_consumer_and_token($this->consumer, $this->token, $method, $url, $parameters);

	    $request->sign_request($this->sha1_method, $this->consumer, $this->token);
		
	    switch ($method) {
	    case 'GET':
	      return $this->call($request->to_url(), 'GET', array());
	    default:
	      return $this->call($request->get_normalized_http_url(), $method, $request->to_postdata());
	    }
	}
	
	/**
	* Basic CURL request which connects to the Tumblr API URLs and returns the result
	*
	* @returns result from the URL call
	*/
	
	private function call($url, $method, $parameters) {
		
		$curl2 = curl_init();
		
		if ($method == "POST")
		{
			curl_setopt($curl2, CURLOPT_POST, true);
			curl_setopt($curl2, CURLOPT_POSTFIELDS, $parameters);
		}
		
		curl_setopt($curl2, CURLOPT_URL, $url);
		curl_setopt($curl2, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl2, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl2, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($curl2, CURLOPT_USERAGENT, $this->userAgent);

		$result = curl_exec($curl2);

		$HttpCode = curl_getinfo($curl2, CURLINFO_HTTP_CODE);
		
		$this->http_code = $HttpCode;
		
		return $result;
 	}

	
}


?>
