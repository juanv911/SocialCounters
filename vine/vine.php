<?php
header('Access-Control-Allow-Origin: *'); 
header('Content-type: application/json');
$vine_id = $_GET['user'];
$json = file_get_contents('https://api.vineapp.com/users/profiles/'.$vine_id);
$obj = json_decode($json,true);
$followers_count = $obj['data']['followerCount'];
$json_array = array('followers'=>$followers_count);
echo json_encode($json_array);
?>