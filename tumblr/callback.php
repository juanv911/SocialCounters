<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-type: application/json');

include ("lib/tumblrPHP.php");

// Check if username parameter is sent
if(isset($_GET['user']) && $_GET['user'] != ''){
    // Tumblr Username
    $username = $_GET['user'];
    // Enter your Consumer / Secret Key:
    $consumer = "CONSUMER_KEY";
    $secret = "COMSUMER_SECRET";
    $oauth_token = "OAUTH_TOKEN";
    $oauth_token_secret = "OAUTH_TOKEN_SECRET";

    // Create Instance of Tumblr class
    $tumblr = new Tumblr($consumer, $secret, $oauth_token, $oauth_token_secret);

    // Grab the followers by using the oauth_get method.
    $followers = $tumblr->oauth_get("/blog/".$username.".tumblr.com/followers");
    
    // Retrieve number of followers
    $data = array('followers'=>$followers->response->total_users);

    // Print JSON Response
    echo json_encode($data, JSON_NUMERIC_CHECK);
}
?>
