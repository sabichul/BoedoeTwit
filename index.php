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

menu_register(array (
	'about' => array (
		'callback' => 'about_page',
	),
	'logout' => array (
		'security' => true,
		'callback' => 'logout_page',
	),
));

function logout_page() {
	user_logout();
	header("Location: " . BASE_URL); /* Redirect browser */
	exit;
}

function about_page() {
	$content = '
<div id="about" >

<h3>What is '.CLIENT_NAME.'?</h3>

<ul>
	<li>A mobile web interface to Twitter\'s API</li>
  <li>Using dabr source code by <a href="user/davidcarrington">@davidcarrington</a> with inspirations from <a href="user/whatleydude">@whatleydude</a> and awesome contributions from <a href="http://shkspr.mobi/blog/index.php/tag/dabr/">Terence Eden</a></li>
	<li>Secure, storing your Twitter login details in an encrypted cookie on your machine, and <em>never</em> stored on the website</li>
	<li>A twitter client with beautifull designs and future applications</li>
	<li>An started project by <a href="user/BirdStreetInc">@BirdStreetInc</a></li>
	<li>BoedoeTwit was founded at 2010 July and running on public at 2010 October</li>
</ul>

<p>If you have any comments, suggestions or questions then feel free to get in touch.</p>

</div>';
	theme('page', 'About', $content);
}

browser_detect();
menu_execute_active_handler();
