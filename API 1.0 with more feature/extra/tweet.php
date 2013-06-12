<?php
 
menu_register(array( 
   'show' => array(
      'hidden'   => true,
      'security' => true,
      'callback' => 'show_page',
   ),
)); 

function show_page($query){

	$db = DATABASE;
	$dbuser = DBUSER;
	$dbpass = DBPASS;
	$dbname = DBNAME;

mysql_connect("$db", "$dbuser", "$dbpass");
mysql_select_db("$dbname");
 
$tweet_key = @$_GET['long'];
 
$query = "SELECT * FROM shortener WHERE tweet_key = '$tweet_key'";
$hasil = mysql_query($query);
$data  = mysql_fetch_array($hasil);
$data = str_replace("@".user_current_username(), user_current_username(), $data);
$user = twitter_user_info($user->screen_name);

    $content = "<div class='hero-unit container lead'>";
                /*<img src='http://api.twitter.com/1/users/profile_image?screen_name=".$user->screen_name."&size=normal' class='avatar'/>"
    $content .= "<p class='status shift'>";
    $content .= "<p>";*/
    $content .= twitter_parse_tags($data['tweet_text']);
    $content .= "</p></div>";
    $content .= '<div class="well container">';
    $content .= '<form method="post" action="update">
                <textarea name="status" class="span12" rows="5">RT '.$data['tweet_text'].'</textarea>
                <br><input name="in_reply_to_id" value="'.$in_reply_to_id.'" type="hidden" />
                <input type="submit" value="Retweet" class="btn" />';
    $content .= '&nbsp;<a href="http://www.facebook.com/sharer/sharer.php?u='.BASE_URL.'show?long='.$data['tweet_key'].'" class="btn btn-primary">Share</a>';
    $content .= '&nbsp;<a href="https://twitter.com/intent/tweet?text='.$data['tweet_text'].'" class="btn btn-info">Tweet</a>';
    $content .= '</form>';
    $content .= '</div>';

    theme('page', "Tweet Long", $content);
}  
 
?>