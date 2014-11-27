<?php
require 'tmhOAuth.php'; // Get it from: https://github.com/themattharris/tmhOAuth

// Use the data from http://dev.twitter.com/apps to fill out this info
// notice the slight name difference in the last two items)

define('CONSUMER_KEY', '6WRzQSWJQn40FDFAvuJA34c2d');
define('CONSUMER_SECRET', 'J3VaoeoL6btZek1h6jbucLe06WpGbIBtgE1TyA7uOiTwnLeent');
define('ACCESS_TOKEN', '2732477607-2Z0GSIUhoN8W6YBa9OPbau2k7LIr6llzH30Mdz3');
define('ACCESS_TOKEN_SECRET', 'rlVk4ik3KV1J4dbng8jP911xCf7wTZpFMc07W8i3jScR3');

$connection = new tmhOAuth(array(
  'consumer_key' => CONSUMER_KEY,
	'consumer_secret' => CONSUMER_SECRET,
	'user_token' => ACCESS_TOKEN, //access token
	'user_secret' => ACCESS_TOKEN_SECRET //access token secret
));

// set up parameters to pass
$parameters = array();

if ($_GET['count']) {
	$parameters['count'] = strip_tags($_GET['count']);
}

if ($_GET['screen_name']) {
	$parameters['screen_name'] = strip_tags($_GET['screen_name']);
}

if ($_GET['twitter_path']) { $twitter_path = $_GET['twitter_path']; }  else {
	$twitter_path = '1.1/statuses/user_timeline.json';
}

$http_code = $connection->request('GET', $connection->url($twitter_path), $parameters );

if ($http_code === 200) { // if everything's good
	$response = strip_tags($connection->response['response']);

	if ($_GET['callback']) { // if we ask for a jsonp callback function
		echo $_GET['callback'],'(', $response,');';
	} else {
		echo $response;	
	}
} else {
	echo "Error ID: ",$http_code, "\n";
	echo "Error: ",$connection->response['error'], "\n";
}

// You may have to download and copy http://curl.haxx.se/ca/cacert.pem