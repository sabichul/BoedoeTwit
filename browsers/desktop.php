<?php
function desktop_theme_status_form($text = '', $in_reply_to_id = NULL) {
	if (user_is_authenticated()) {

/*FBConnect*/
require './extra/facebook.php'; 
require './extra/fbconfig.php'; 

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
$fbc="<span class='inline btn' title='Post to FB'><input type='checkbox' name='fb' value='1' checked='true'> <img src='images/postfb.png'></span>"; 
} 
else 
{ 
$loginUrl = $facebook->getLoginUrl(array( 
 'scope' => 'email,user_birthday,publish_stream', 
 'display' => 'touch'
)); 
$fbc="<a href='".$loginUrl."' class='btn' title='Post to FB'><img src='images/postfb.png'></a>"; 
}
/*End FBConnect*/

		$sapa = user_current_username();
		$icon = "images/twitter-bird-16x16.png";
		
		//	adding ?status=foo will automaticall add "foo" to the text area.
		if ($_GET['status'])
		{
			$text = $_GET['status'];
		}
		
		$output = '
		<form method="post" action="update" class="well container">
			<fieldset class="container">
				<legend><img src="'.$icon.'" width="16" height="16" /> What\'s going on, '.$sapa.'?</legend>
				<br>
				<textarea id="status" name="status" rows="4" class="span12" style="resize:none;" placeholder="What\'s going on, '.$sapa.'?">'.$text.'</textarea>
				<div>
					<input name="in_reply_to_id" value="'.$in_reply_to_id.'" type="hidden" />
<div class="btn-group pull-right">
  <button type="submit" class="btn btn-primary" title="Tweet"/><b class="icon-share icon-white"></b></button>
  '.$fbc.'
  <a href="./Upload Picture" class="btn" title="Upload Images"><b class="icon-camera"></b></a>
</div>
					<div class="form-inline pull-left"><span id="remaining">140</span>
					<span id="geo" style="display: none;">
						<label class="checkbox">
						<input onclick="goGeo()" type="checkbox" id="geoloc" name="location" />
						<span for="geoloc" id="lblGeo"></span>
						</label>
					</span></div>
				</div>
			</fieldset>
			<script type="text/javascript">
				started = false;
				chkbox = document.getElementById("geoloc");
				if (navigator.geolocation) {
					geoStatus("Tweet my location");
					if ("'.$_COOKIE['geo'].'"=="Y") {
						chkbox.checked = true;
						goGeo();
					}
				}
				function goGeo(node) {
					if (started) return;
					started = true;
					geoStatus("Locating...");
					navigator.geolocation.getCurrentPosition(geoSuccess, geoStatus , { enableHighAccuracy: true });
				}
				function geoStatus(msg) {
					document.getElementById("geo").style.display = "inline";
					document.getElementById("lblGeo").innerHTML = msg;
				}
				function geoSuccess(position) {
					geoStatus("Tweet my <a href=\'http://maps.google.co.uk/m?q=" + position.coords.latitude + "," + position.coords.longitude + "\' target=\'blank\'>location</a>");
					chkbox.value = position.coords.latitude + "," + position.coords.longitude;
				}
			</script>
		</form>';
		$output .= js_counter('status');
		return $output;
	}
}

function desktop_theme_search_form($query) {
	$query = stripslashes(htmlentities($query,ENT_QUOTES,"UTF-8"));

	return '
	<form action="search" method="get" class="well container"><input name="query" value="'. $query .'" />
		<input type="submit" value="Search" class="btn btn-primary"/>
		<br>
		<span id="geo" style="display: none;">
			<input onclick="goGeo()" type="checkbox" id="geoloc" name="location" /> 
			<label for="geoloc" id="lblGeo"></label>
			<select name="radius">
				<option value="1km">1 Km</option>
				<option value="5km">5 Km</option>
				<option value="10km">10 Km</option>
				<option value="50km">50 Km</option>
			</select>
		</span>
		<script type="text/javascript">
			started = false;
			chkbox = document.getElementById("geoloc");
			if (navigator.geolocation) {
				geoStatus("Search near my location");
				if ("'.$_COOKIE['geo'].'"=="Y") {
					chkbox.checked = true;
					goGeo();
				}
			}
			function goGeo(node) {
				if (started) return;
				started = true;
				geoStatus("Locating...");
				navigator.geolocation.getCurrentPosition(geoSuccess, geoStatus , { enableHighAccuracy: true });
			}
			function geoStatus(msg) {
				document.getElementById("geo").style.display = "inline";
				document.getElementById("lblGeo").innerHTML = msg;
			}
			function geoSuccess(position) {
				geoStatus("Search near my <a href=\'http://maps.google.co.uk/m?q=" + position.coords.latitude + "," + position.coords.longitude + "\' target=\'blank\'>location</a>");
				chkbox.value = position.coords.latitude + "," + position.coords.longitude;
			}
		</script>
	</form>';
}
?>