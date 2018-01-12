<?php

require('./models/user.php');

$usermodel = new UserModel();

if ($action == "login") {
	if ($_POST['email'] && $_POST['password']) {
		try {
			$message = $usermodel->login($_POST['email'], $_POST['password']);
			header("Location:/");
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
	}
	require("./views/header.php");
	require("./views/login.php");
	require("./views/footer.php");
}

if ($action == "logout") {
	session_unset();
	session_destroy();
	header("Location:/");
}

if ($action == "signup") {
	if ($_POST['email'] && $_POST['pseudo'] && $_POST['password'] && $_POST['confirmation']) {
		try {
			$message = $usermodel->signin($_POST['pseudo'], $_POST['email'], $_POST['password']);
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
	} else if ($_POST['email'] || $_POST['pseudo'] || $_POST['password'] || $_POST['confirmation']) {
		$message = "Veuillez renseigner tous les champs";
	}
	require("./views/header.php");
	require("./views/signup.php");
	require("./views/footer.php");
}

if ($action == "account") {
	$user = $usermodel->getUser($_SESSION['id']);
	require("./views/header.php");
	require("./views/account.php");
	require("./views/footer.php");
}

if ($action == "shot") {
	require("./views/header.php");
	require("./views/shot.php");
	require("./views/footer.php");
}
?>
