<?php

error_reporting(E_ALL ^ E_NOTICE);

// Twitter's API URL - you can also use https://api.twitter.com/1/ if you want a secure connection to Twitter
define('API_URL','https://api.twitter.com/1/');

// Image Proxy URL
// Use http://src.sencha.io/ for regular connections
// Use https://tinysrc.appspot.com/ for SSL connections
define('IMAGE_PROXY_URL', 'http://src.sencha.io/');

// Cookie encryption key. Max 52 characters
define('ENCRYPTION_KEY', 'BoedoeTwit by Bird Street Inc');

// OAuth consumer and secret keys. Available from http://twitter.com/oauth_clients
define('OAUTH_CONSUMER_KEY', '====================');
define('OAUTH_CONSUMER_SECRET', '====================');

// Basic Information
define('CLIENT_NAME', '====================');
define('CLIENT_URL','http://====================');
// If you not have 2 client, remove it here and in ./common/user.php
define('CLIENT2_URL','http://====================');
define('TWITTER_URL', 'http://twitter.com/====================');
define('TWITTER_NAME', '====================');
define('FACEBOOK_URL', 'http://facebook.com/====================');
define('LOGO_URL', $base_url.'/images/logo.png');

// Facebook Connect
define('FB_APPID', '====================');
define('FB_APPSECRET', '====================');

// This is for long tweet database
// host,user,pass,dbname
// Before use this, create a table inside your database and give it a name 'shortener'
// Inside table create 2 columns (tweet_key and tweet_text)
define('LONG_TWEET', 'ON');
define('DATABASE', 'localhost');
define('DBUSER', '====================');
define('DBPASS', '====================');
define('DBNAME', '====================');

// Optional: Enable to add advertisement
define('ADS_MODE', 'ON');
define('ADS_CODE', '<iframe scrolling="no" style="border: 0; width: 468px; height: 60px;" src="http://coinurl.com/get.php?id=3161"></iframe>');

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
$GA_ACCOUNT = "MO-32707247-1";
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