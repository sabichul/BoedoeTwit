<?php

error_reporting(E_ALL ^ E_NOTICE);

// Twitter's API URL - you can also use https://api.twitter.com/1/ if you want a secure connection to Twitter
//define('API_URL','http://api.twitter.com/1/');

// Twitter's API URL.
define('API_NEW','http://api.twitter.com/1.1/');
define('API_OLD','http://api.twitter.com/1/');

// Image Proxy URL
// Use http://src.sencha.io/ for regular connections
// Use https://tinysrc.appspot.com/ for SSL connections (no longer appears to work)
define('IMAGE_PROXY_URL', 'http://src.sencha.io/');

// Cookie encryption key. Max 52 characters
define('ENCRYPTION_KEY', 'BoedoeTwit by Bird Street Inc');

// OAuth consumer and secret keys. Available from http://twitter.com/oauth_clients
define('OAUTH_CONSUMER_KEY', '==========');
define('OAUTH_CONSUMER_SECRET', '===========');

//Basic Information
define('CLIENT_NAME', '==========');
define('CLIENT_URL', '========');
define('CLIENT_LOGO', 'http://a0.twimg.com/profile_images/1584971999/80x80-curious.png');

// Embedly Key 
// Embed image previews in tweets
// Sign up at https://app.embed.ly/
define('EMBEDLY_KEY', '');

// API key for InMobi adverts - sign up at http://inmobi.com/
define('INMOBI_API_KEY', '');

// Optional: Allows you to turn shortened URLs into long URLs http://www.longurlplease.com/docs
// Uncomment to enable.
// define('LONGURL_KEY', 'true');

// Optional: Enable to view page processing and API time
define('DEBUG_MODE', 'OFF');

// Base URL, should point to your website, including a trailing slash
// Can be set manually but the following code tries to work it out automatically.
$base_url = 'http://'.$_SERVER['HTTP_HOST'];
if ($directory = trim(dirname($_SERVER['SCRIPT_NAME']), '/\,')) {
	$base_url .= '/'.$directory;
}
define('BASE_URL', $base_url.'/');



// MySQL storage of OAuth login details for users
define('MYSQL_USERS', 'OFF');
// mysql_connect('localhost', 'username', 'password');
// mysql_select_db('dabr');

/* The following table is needed to store user login details if you enable MYSQL_USERS:

CREATE TABLE IF NOT EXISTS `user` (
  `username` varchar(64) NOT NULL,
  `oauth_key` varchar(128) NOT NULL,
  `oauth_secret` varchar(128) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
)

*/

// Google Analytics Mobile tracking code
// You need to download ga.php from the Google Analytics website for this to work
// Copyright 2009 Google Inc. All Rights Reserved.
$GA_ACCOUNT = "";
$GA_PIXEL = "ga.php";

function googleAnalyticsGetImageUrl() {
	global $GA_ACCOUNT, $GA_PIXEL;
	$url = "";
	$url .= $GA_PIXEL . "?";
	$url .= "utmac=" . $GA_ACCOUNT;
	$url .= "&utmn=" . rand(0, 0x7fffffff);
	$referer = $_SERVER["HTTP_REFERER"];
	$query = $_SERVER["QUERY_STRING"];
	$path = $_SERVER["REQUEST_URI"];
	if (empty($referer)) {
		$referer = "-";
	}
	$url .= "&utmr=" . urlencode($referer);
	if (!empty($path)) {
		$url .= "&utmp=" . urlencode($path);
	}
	$url .= "&guid=ON";
	return str_replace("&", "&amp;", $url);
}

?>