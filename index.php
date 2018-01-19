<?php
session_start();

if ($_GET && array_key_exists('route', $_GET)) {
	$route_array = explode("/", $_GET['route']);
	if (array_key_exists(2, $route_array)) {
		$action = $route_array[2];
	}
	if (array_key_exists(1, $route_array)) {
		$controller = $route_array[1];
		require('./controllers/'.$controller.'.php');
	} else {
		include("./views/header.php");
		include("./views/footer.php");
	}
} else {
	include("./views/header.php");
	include("./views/footer.php");
}
