All about BoedoeTwit?
=====================

- A mobile web interface to Twitter's API
- Using dabr source code by @davidcarrington with inspirations from @whatleydude and awesome contributions from Terence Eden
- Secure, storing your Twitter login details in an encrypted cookie on your machine, and never stored on the website
- A twitter client with beautifull designs and future applications
- An started project by @BirdStreetInc
- BoedoeTwit was founded at 2010 July and running on public at 2010 October

README TO INSTALL
=================


// Basic Information
====================

define('CLIENT_NAME', '====================');

define('CLIENT_URL','http://====================');

// If you not have 2 client, remove it here and in ./common/user.php

define('CLIENT2_URL','http://====================');

define('TWITTER_URL', 'http://twitter.com/====================');

define('TWITTER_NAME', '====================');

define('FACEBOOK_URL', 'http://facebook.com/====================');

define('LOGO_URL', $base_url.'/images/logo.png');


// Facebook Connect
===================

define('FB_APPID', '====================');

define('FB_APPSECRET', '====================');


// This is for long tweet database
==================================

// host,user,pass,dbname

// Before use this, create a table inside your database and give it a name 'shortener'

// Inside table create 2 columns (tweet_key and tweet_text)

define('LONG_TWEET', 'ON');

define('DATABASE', 'localhost');

define('DBUSER', '====================');

define('DBPASS', '====================');

define('DBNAME', '====================');


// Optional: Enable to add advertisement
========================================

define('ADS_MODE', 'ON');

define('ADS_CODE', '<iframe scrolling="no" style="border: 0; width: 468px; height: 60px;" src="http://coinurl.com/get.php?id=3161"></iframe>');