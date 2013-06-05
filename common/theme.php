<?php
require_once ("common/advert.php");

$current_theme = false;

function theme() {
	global $current_theme;
	$args = func_get_args();
	$function = array_shift($args);
	$function = 'theme_'.$function;

	if ($current_theme) {
		$custom_function = $current_theme.'_'.$function;
		if (function_exists($custom_function))
		$function = $custom_function;
	} else {
		if (!function_exists($function))
		return "<p class='well container'>Error: theme function <b>$function</b> not found.</p>";
	}
	return call_user_func_array($function, $args);
}

function theme_csv($headers, $rows) {
	$out = implode(',', $headers)."\n";
	foreach ($rows as $row) {
		$out .= implode(',', $row)."\n";
	}
	return $out;
}

function theme_list($items, $attributes) {
	if (!is_array($items) || count($items) == 0) {
		return '';
	}
	$output = '<ul'.theme_attributes($attributes).'>';
	foreach ($items as $item) {
		$output .= "<li>$item</li>\n";
	}
	$output .= "</ul>\n";
	return $output;
}

function theme_options($options, $selected = NULL) {
	if (count($options) == 0) return '';
	$output = '';
	foreach($options as $value => $name) {
		if (is_array($name)) {
			$output .= '<optgroup label="'.$value.'">';
			$output .= theme('options', $name, $selected);
			$output .= '</optgroup>';
		} else {
			$output .= '<option value="'.$value.'"'.($selected == $value ? ' selected="selected"' : '').'>'.$name."</option>\n";
		}
	}
	return $output;
}

function theme_info($info) {
	$rows = array();
	foreach ($info as $name => $value) {
		$rows[] = array($name, $value);
	}
	return theme('table', array(), $rows);
}

function theme_table($headers, $rows, $attributes = NULL) {
	$out = '<div'.theme_attributes($attributes).'>';
	if (count($headers) > 0) {
		$out .= '<thead><tr>';
		foreach ($headers as $cell) {
			$out .= theme_table_cell($cell, TRUE);
		}
		$out .= '</tr></thead>';
	}
	if (count($rows) > 0) {
		$out .= theme('table_rows', $rows);
	}
	$out .= '</div>';
	return $out;
}

function theme_table_rows($rows) {
	$i = 0;
	foreach ($rows as $row) {
		if ($row['data']) {
			$cells = $row['data'];
			unset($row['data']);
			$attributes = $row;
		} else {
			$cells = $row;
			$attributes = FALSE;
		}
		$attributes['class'] .= ($attributes['class'] ? ' ' : '') . ($i++ %2 ? 'even' : 'odd');
		$out .= '<div'.theme_attributes($attributes).'>';
		foreach ($cells as $cell) {
			$out .= theme_table_cell($cell);
		}
		$out .= "</div>\n";
	}
	return $out;
}

function theme_attributes($attributes) {
	if (!$attributes) return;
	foreach ($attributes as $name => $value) {
		$out .= " $name=\"$value\"";
	}
	return $out;
}

function theme_table_cell($contents, $header = FALSE) {
	$celltype = $header ? 'th' : 'td';
	if (is_array($contents)) {
		$value = $contents['data'];
		unset($contents['data']);
		$attributes = $contents;
	} else {
		$value = $contents;
		$attributes = false;
	}
	return "<span".theme_attributes($attributes).">$value</span>";
}


function theme_error($message) {
	$content .= '<div class="well container">'.$message.'</div>';
	theme_page('Error', $content);
}

function theme_page($title, $content) {
	$body = theme('header');
	$body .= theme('iklan');
	$body .= $content;
	$body .= theme('footer');
	/*$body .= theme('menu_bottom');*/
	$body .= theme('google_analytics');
	if (DEBUG_MODE == 'ON') {
		global $dabr_start, $api_time, $services_time, $rate_limit;
		$time = microtime(1) - $dabr_start;
		$body .= '<p>Processed in '.round($time, 4).' seconds ('.round(($time - $api_time - $services_time) / $time * 100).'% Dabr, '.round($api_time / $time * 100).'% Twitter, '.round($services_time / $time * 100).'% other services). '.$rate_limit.'.</p>';
	}
	if ($title == 'Login') {
		$title = 'Twitter Client';
		$meta = '<meta name="description" content="'.CLIENT_NAME.' is Free alternative to mobile Twitter, bringing you the complete Twitter experience to your phone." />';
	}
	ob_start('ob_gzhandler');
	header('Content-Type: text/html; charset=utf-8');
	echo	'<!DOCTYPE html>
				<html>
					<head>
						<meta charset="utf-8" />
						<meta name="viewport" content="width=device-width; initial-scale=1.0;" />
						<title>' . $title . ' | '.CLIENT_NAME.'</title>
						<link rel="shortcut icon" href="'.LOGO_URL.'">
						<base href="',BASE_URL,'" />
						'.$meta.theme('css').'
					</head>
					<body id="thepage">';
	echo 				"<div id=\"advert\">" . show_advert() . "</div>";
	echo 				$body;
	echo '		</body>
				</html>';
	exit();
}

function theme_colours() {
	$info = $GLOBALS['colour_schemes'][setting_fetch('colours', 5)];
	list($name, $bits) = explode('|', $info);
	$colours = explode(',', $bits);
	return (object) array(
		'links'		=> $colours[0],
		'bodybg'		=> $colours[1],
		'bodyt'		=> $colours[2],
		'small'		=> $colours[3],
		'odd'			=> $colours[4],
		'even'		=> $colours[5],
		'replyodd'	=> $colours[6],
		'replyeven'	=> $colours[7],
		'menubg'		=> $colours[8],
		'menut'		=> $colours[9],
		'menua'		=> $colours[10],
	);
}

function theme_css() {
	$c = theme('colours');
	return "<link href='extra/css/bootstrap.css' rel='stylesheet' media='screen'>
<link href='extra/css/bootstrap-responsive.css' rel='stylesheet'>
<link href='extra/css/style.css' rel='stylesheet'>
<script src='extra/js/jquery.js'></script>
<script src='extra/js/bootstrap.js'></script>
<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-32707247-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<style type='text/css'>
	a{color:#{$c->links}}
	table{border-collapse:collapse}
	form{margin:.3em;}
	td{vertical-align:top;padding:0.3em}
	img{border:0}
	small,small a{color:#{$c->small}}
	body{background:#{$c->bodybg};color:#{$c->bodyt};margin:0;font:90% sans-serif;}
	.odd{background:#{$c->odd}}
	.even{background:#{$c->even}}
	.reply{background:#{$c->replyodd}}
	.reply.even{background: #{$c->replyeven}}
	.menu{color:#{$c->menut};background:#{$c->menubg};padding: 2px}
	.menu a{color:#{$c->menua};text-decoration: none}
	.tweet,.features{padding:5px}
	.date{padding:5px;font-size:0.8em;font-weight:bold;color:#{$c->small}}
	.about,.time{font-size:0.75em;color:#{$c->small}}
	.avatar{display:block; height:58px; width:58px; left:0.3em; margin:0; overflow:hidden; position:relative;}
	.status{display:block;word-wrap:break-word;}
	.shift{margin:-60px 0 0 70px;min-height:24px;}
	.from{font-size:0.75em;color:#{$c->small};font-family:serif;}
	.from a{color:#{$c->small};}
</style>";
}

function theme_header() {

	$cs = theme('custom_search');

	if (user_is_authenticated()) {
		$user = user_current_username();
	}
	$content = "<div class='navbar navbar-fixed-top navbar-inverse'>
			<div class='navbar-inner'>
				<div class='container'>

				<a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</a>

	<b class='brand'>".CLIENT_NAME."</b>

				<div class='nav-collapse collapse'>";

	if (user_is_authenticated()) {
	$content .= "<ul class='nav'>
					<li><a href='./'><b class='icon-home icon-white'></b></a></li>
					<li class='divider-vertical'></li>
					<li><a href='./replies'><b class='icon-retweet icon-white'></b></a></li>
					<li class='divider-vertical'></li>
					<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><b class='icon-envelope icon-white'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='./directs/create'>Create</a></li>
							<li><a href='./directs/inbox'>Inbox</a></li>
							<li><a href='./directs/sent'>Sent</a></li>
						</ul>
					</li>
					<li class='divider-vertical'></li>
					<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><b class='icon-user icon-white'></b></a>
						<ul class='dropdown-menu'>
							<li><a href='./user/".$user."'>".$user."</a></li>
							<li><a href='./Edit Profile'>Edit Profile</a></li>
							<li><a href='./settings'>Settings</a></li>
							<li><a href='./logout'>Logout</a></li>
						</ul>
					</li>
					<li class='divider-vertical'></li>
					<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><b class='icon-chevron-down icon-white'></b></a>
						<ul class='dropdown-menu'>
							<li>".$cs."</li>
							<li class='divider'></li>
							<li><a href='./favourites'>Favourites</a></li>
							<li><a href='./trends'>Trending Topics</a></li>
							<li><a href='./retweets'>Retweeted</a></li>
							<li><a href='./lists'>Lists</a></li>
							<li><a href='./notfollback'>Not Follow Back</a></li>
							<li><a href='./sms'>Free SMS</a></li>
						</ul>
					</li>
			</ul>";
	}else{
	$content .= "<ul class='nav'><li><a href='./'>Home</a></li></ul>
			<ul class='nav pull-right'><li><a href='./oauth'>Login</a></li></ul>";
	}
	$content .= "</div></div></div></div>";

	$content .= "<div style='height:50px'></div>";

	return $content;
}

function theme_footer() {
    $limit = ratelimit();
    $remaining = $limit->remaining_hits < 0 ? 0 : $limit->remaining_hits; 
    $hourly = $limit->hourly_limit; 
    $reset = intval((strtotime($limit->reset_time) - time())/60); 
        header('Content-Type: text/html');

	$content = "<div class='footer'><div class='container muted'>";

	$content .= '<p><a href="./about">About Us</a> - <a href="./about#tos">Terms</a> - <a href="./about#privacy">Privacy</a></p>
			<p>Designed and built with Dabr &amp; Bootstrap by <a href="'.TWITTER_URL.'">@'.TWITTER_NAME.'</a> developers</p>
			<p>Dabr code licensed under <a href="http://www.opensource.org/licenses/mit-license.php">MIT License</a> &amp; Bootstrap code licensed under <a href="http://www.apache.org/licenses/LICENSE-2.0">Apache License v2.0</a></p>
			<p><a href="https://twitter.com/intent/tweet?screen_name='.TWITTER_NAME.'" class="twitter-mention-button" data-related="'.TWITTER_NAME.'">Tweet to @'.TWITTER_NAME.'</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></p>
<p><b>API Limit Usage:</b> '.$remaining.'/'.$hourly.' - Reset in '.$reset.' min(s)</p>
			<p>&copy; 2010 - <script type="text/javascript">var d = new Date();
document.write(d.getFullYear());</script> '.CLIENT_NAME.'</p>';
	$content .= '</div></div>';

	return $content;
}

//RateLimit API
function ratelimit(){
$request = API_URL."account/rate_limit_status.json";
return twitter_process($request);
}

function theme_custom_search() {
	$query = stripslashes(htmlentities($query,ENT_QUOTES,"UTF-8"));

	$content = '
	<form action="search" method="get">
		<input name="query" value="'. $query .'" type="text" class="span2 search-query span" placeholder="Type to search"/>
	</form>';

	return $content;
}

function theme_google_analytics() {
	global $GA_ACCOUNT;
	if (!$GA_ACCOUNT) return '';
	$googleAnalyticsImageUrl = googleAnalyticsGetImageUrl();
	return "<img src='{$googleAnalyticsImageUrl}' />";
}

function theme_iklan(){

if (ADS_MODE == 'ON') {
if (user_is_authenticated()) {
	$content = '<center>'.ADS_CODE.'<br></center>';
	return $content;
	}
}
}

?>