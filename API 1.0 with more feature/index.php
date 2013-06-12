<?php
$dabr_start = microtime(1);

header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

require 'config.php';
require 'common/browser.php';
require 'common/menu.php';
require 'common/user.php';
require 'common/theme.php';
require 'common/twitter.php';
require 'common/lists.php';
require 'common/settings.php';
require 'extra/notfollback.php';
require 'extra/tweet.php';
require 'extra/sms.php';

menu_register(array (
	'about' => array (
		'callback' => 'about_page',
		'hidden' => true,
	),
	'logout' => array (
		'security' => true,
		'hidden' => true,
		'callback' => 'logout_page',
	),
	'fb' => array( 
		'hidden' => true, 
		'security' => true, 
		'callback' => 'fb_connect', 
	), 
	'fblogout' => array( 
		'hidden' => true, 
		'security' => true, 
		'callback' => 'fblogout', 
	), 
));

function logout_page() {
	user_logout();
	header("Location: " . BASE_URL); /* Redirect browser */
	exit;
}

function about_page() {
	$content = file_get_contents('extra/about.php');
	theme('page', 'About', $content);
}

//FBConnect
function fblogout($fblogout) { 
session_start(); 
$user=''; 
$userdata=''; 
session_destroy(); 
header("Location: ".BASE_URL.""); 
} 

function fb_connect($fb) { 
require 'extra/facebook.php'; 
require 'extra/fbconfig.php'; 
$user = $facebook->getUser();              
if ($user) 
{ 
$logoutUrl = $facebook->getLogoutUrl(); 
try 
{ 
$userdata = $facebook->api('/me'); 
} 
catch (FacebookApiException $e) { 
error_log($e); 
$user = null; 
} 
$_SESSION['facebook']=$_SESSION; 
$_SESSION['userdata'] = $userdata; 
$_SESSION['logout'] = $logoutUrl; 
//Redirecting to home.php 
header("Location: ".BASE_URL.""); 
} 
else 
{ 
$loginUrl = $facebook->getLoginUrl(array( 
 'scope' => 'user_birthday,publish_stream'
)); 
$content = '<a href="'.$loginUrl.'"><img src="images/fb.png"></a>'; 
    theme('page', "Facebook", $content);
} 
}


browser_detect();
menu_execute_active_handler();
?>