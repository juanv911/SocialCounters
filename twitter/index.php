<?php
    header('Access-Control-Allow-Origin: *'); 
    header('Content-type: application/json');
    require_once('TwitterAPIExchange.php'); //get it from https://github.com/J7mbo/twitter-api-php

    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
    'oauth_access_token' => "place_token_here",
    'oauth_access_token_secret' => "place_secret_here",
    'consumer_key' => "place_key_here",
    'consumer_secret' => "place_consumer_key_here"
    );
    $twitter_username = $_GET['user'];
    $ta_url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
    $getfield = '?screen_name='.$twitter_username;
    $requestMethod = 'GET';
    $twitter = new TwitterAPIExchange($settings);
    $follow_count=$twitter->setGetfield($getfield)
    ->buildOauth($ta_url, $requestMethod)
    ->performRequest();
    $data = json_decode($follow_count, true);
    $followers_count=$data[0]['user']['followers_count'];
    $json_array = array('followers'=>$followers_count);
    echo json_encode($json_array);
