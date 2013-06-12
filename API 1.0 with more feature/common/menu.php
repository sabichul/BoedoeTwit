<?php

$menu_registry = array();

function menu_register($items) {
	foreach ($items as $url => $item) {
		$GLOBALS['menu_registry'][$url] = $item;
	}
}

function menu_execute_active_handler() {
	$query = (array) explode('/', $_GET['q']);
	$GLOBALS['page'] = $query[0];
	$page = $GLOBALS['menu_registry'][$GLOBALS['page']];
	if (!$page) {
		header('HTTP/1.0 404 Not Found');
		die('404 - Page not found.');
	}

	if ($page['security'])
	user_ensure_authenticated();

	if (function_exists('config_log_request'))
	config_log_request();

	if (function_exists($page['callback']))
	return call_user_func($page['callback'], $query);

	return false;
}

function menu_current_page() {
	return $GLOBALS['page'];
}

function menu_visible_items() {
	static $items;
	if (!isset($items)) {
		$items = array();
		foreach ($GLOBALS['menu_registry'] as $url => $page) {
			if ($page['security'] && !user_is_authenticated()) continue;
			if ($page['hidden']) continue;
			$items[$url] = $page;
		}
	}
	return $items;
}

function theme_menu_top() {
	return theme('menu_both', 'top');
}

function theme_menu_bottom() {
	return theme('menu_both', 'bottom');
}

function theme_menu_both($menu) {
	$links = array();
	foreach (menu_visible_items() as $url => $page) {
		$title = $url ? $url : 'home';
		if (!$url) $url = BASE_URL; // Shouldn't be required, due to <base> element but some browsers are stupid.
		if ($menu == 'bottom' && isset($page['accesskey'])) {
			$links[] = "<li><a href='$url' accesskey='{$page['accesskey']}'>$title</a> {$page['accesskey']}</li>";
		} else {
			$links[] = "<li><a href='$url'>$title</a></li>";
		}
	}
	if (user_is_authenticated()) {
		$user = user_current_username();
		array_unshift($links, "<li><a href='user/$user'>$user</a></b></li>");
	}
	if ($menu == 'bottom') {
		$links[] = "<li><a href='{$_GET['q']}' accesskey='5'>refresh</a> 5</li>";
	}
	return "<div class='navbar navbar-static-top menu-$menu'>
			<div class='navbar-inner'>
				<div class='container'>
 
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class='btn btn-navbar' data-toggle='collapse' data-target='.nav-collapse'>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</a>
 
				<!-- Be sure to leave the brand out there if you want it shown -->
 
				<!-- Everything you want hidden at 940px or less, place within here -->
				<div class='nav-collapse collapse'>
					<!-- .nav, .navbar-search, .navbar-form, etc -->
					<ul class='nav'>
					".implode('', $links).'
					</ul>
				</div>
 
				</div>
			</div>
		</div>';
	}

?>