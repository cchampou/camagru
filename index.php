<?php
session_start();

$route_array = explode("/", $_GET['route']);
$controller = $route_array[1];
$action = $route_array[2];

if ($controller) {
	require('./controllers/'.$controller.'.php');
} else {
	include("./views/footer.php");
	include("./views/header.php");
}
?>
