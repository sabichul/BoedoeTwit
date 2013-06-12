<?php 

menu_register(array( 


   'notfollback' => array(
      'hidden'   => true,
      'security' => true,
      'callback' => 'twitter_notfollback_page',
   ),
)); 


function twitter_notfollback_page($query){
    $user = $query[1];
    if (!$user) {
        user_ensure_authenticated();
        $user = user_current_username();
    }
    $request = API_URL."followers/ids.xml?screen_name={$user}";
    $tla = twitter_process($request); //This is the curl Oauth and all that.

    $requestf = API_URL."friends/ids.xml?screen_name={$user}";
    $tlaf = twitter_process($requestf);
    
    $tla = iterator_to_array(simplexml_load_string($tla),false);
    $tla_arr = (array) $tla[0];
    $tlaf = iterator_to_array(simplexml_load_string($tlaf),false);
    $tlaf_arr = (array) $tlaf[0];
    $val = array_diff($tlaf_arr['id'],$tla_arr['id']);
    $content="";
    foreach($val as $user)
    {
        $requestlook = API_URL."users/lookup.xml?user_id={$user}";
        $tplookup = twitter_process($requestlook);
        $xml = simplexml_load_string(utf8_encode($tplookup));
        $us = $xml->user->screen_name;
        $avatar = $xml->user->profile_image_url;
	$bio = $xml->user->description;
	$content .= "<div class='well container'>";
	$content .= "<div class='lead'>";
	$content .= "<span class='avatar'><img src='{$avatar}'/></span>";
	$content .= "<span class='status shift'><b><a href='user/{$us}'>@{$us}</a></b>
			<br/><small>{$bio}</small></span>
			<hr/><a href='user/{$us}' class='btn'>Mention @{$us}</a> <a href='unfollow/{$us}' class='btn'>Unfollow @{$us}</a> <a href='direct/create/{$us}' class='btn'>DM @{$us}</a>";
	$content .= "</div>";
	$content .= "</div>";
    }

    if($content == null){
        $content.="<br/><p class='well container' style='padding-left:5px;'>Nobody. . . Everyone is following you back</p><br/>";
    }

    theme('page', "Not FollBack", $content);
}  

?>