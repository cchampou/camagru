<?php
session_start();
$available_controllers = array('home', 'post', 'user');
if ($_GET && array_key_exists('route', $_GET)) {
	$route_array = explode("/", $_GET['route']);
	if (array_key_exists(2, $route_array)) {
		$action = $route_array[2];
	} else {
		$action = "index";
	}
	if (array_key_exists(1, $route_array)) {
		$controller = $route_array[1];
	} else {
		$controller = "home";
	}
} else {
	$controller = "home";
	$action = "index";
}
if (in_array($controller, $available_controllers)) {
	require('./controllers/'.$controller.'.php');
} else {
	require("./views/header.php");
	require("./views/perdu.php");
	require("./views/footer.php");
}
