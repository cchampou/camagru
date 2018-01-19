<?php

require('./models/user.php');

$usermodel = new UserModel();


if ($action == "login") {
	if ($_POST && $_POST['email'] && $_POST['password']) {
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
	if ($_POST && $_POST['email'] && $_POST['pseudo'] && $_POST['password'] && $_POST['confirmation']) {
		try {
			$usermodel->signup($_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['confirmation']);
			header("Location:/user/login");
		} catch (Exception $e) {
			$message = $e->getMessage();
		}
	} else if ($_POST) {
		$message = "Veuillez renseigner tous les champs";
	}
	require("./views/header.php");
	require("./views/signup.php");
	require("./views/footer.php");
}

if ($action == "account") {
	if ($_POST) {
		if (array_key_exists('changePseudo', $_POST)) {
			if (array_key_exists('pseudo', $_POST) && $_POST['pseudo']) {
				try {
					$usermodel->changePseudo($_POST['pseudo']);
					unset($_POST['pseudo']);
				} catch (Exception $e) {
					$message1 = $e->getMessage();
				}
			} else {
				$message1 = "N'oubliez pas de remplir le champs";
			}
		}
		if (array_key_exists('changeEmail', $_POST)) {
			if (array_key_exists('email', $_POST) && $_POST['email']) {
				try {
					$usermodel->changeEmail($_POST['email']);
					unset($_POST['email']);
				} catch (Exception $e) {
					$message2 = $e->getMessage();
				}
			} else {
				$message2 = "N'oubliez pas de remplir le champs";
			}
		}
		if (array_key_exists('changePass', $_POST)) {
			if (array_key_exists('oldpassword', $_POST) && array_key_exists('password', $_POST) && array_key_exists('confirmation', $_POST)) {
				try {
					$usermodel->changeEmail($_POST['oldpassword'], $_POST['password'], $_POST['confirmation']);
					unset($_POST['password']);
				} catch (Exception $e) {
					$message3 = $e->getMessage();
				}
			} else {
				$message3 = "Veuillez renseigner tous les champs";
			}
		}
	}
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
