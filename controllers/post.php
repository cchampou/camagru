<?php

require('./models/user.php');
require('./models/post.php');

$usermodel = new UserModel();
$postmodel = new PostModel();

switch ($action) {

	case "delete":
		if ($usermodel->checkLoggedIn()) {
			if ($_GET && array_key_exists('id', $_GET)) {
				$postmodel->delete($_GET['id']);
			}
			header("Location: /user/shot");
		} else {
			header("Location: /user/login");
		}
		break;

	case "like":
		if ($usermodel->checkLoggedIn()) {
			if ($_GET && array_key_exists('id', $_GET)) {
				$postmodel->toggleLike($_GET['id']);
			}
			header("Location: /home/index");
		} else {
			header("Location: /user/login");
		}
		break;

	case "get":
		if ($_GET && array_key_exists('id', $_GET)) {
			echo json_encode($postmodel->getOne($_GET['id']));
		}
		break;

	case "comment":
		if ($usermodel->checkLoggedIn()) {
			if ($_POST && array_key_exists('id', $_POST) && array_key_exists('content', $_POST)) {
				$postmodel->comment($_POST['id'], $_POST['content']);
			}
			header("Location: /home/index");
		} else {
			header("Location: /user/login");
		}
		break;

	default:
		require("./views/header.php");
		require("./views/perdu.php");
		require("./views/footer.php");
		break;
}
