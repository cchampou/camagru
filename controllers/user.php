<?php

if ($action == "login") {
	require("./views/header.php");
	require("./views/login.php");
	require("./views/footer.php");
}

if ($action == "logout") {
	header("Location:/");
}

if ($action == "account") {
	require("./views/header.php");
	require("./views/account.php");
	require("./views/footer.php");
}
?>
