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
			header("Location: /user/login?prompt=true");
		}
		break;

	case "like":
		if ($usermodel->checkLoggedIn()) {
			if ($_GET && array_key_exists('id', $_GET)) {
				$postmodel->toggleLike($_GET['id']);
			}
			if (array_key_exists('X-Async-Agent', getallheaders())) {
				http_response_code(200);
			} else {
				header("Location: /home/index");
			}
		} else {
			if (array_key_exists('X-Async-Agent', getallheaders())) {
				http_response_code(202);
			} else {
				header("Location: /user/login?prompt=true");
			}
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
			if (array_key_exists('X-Async-Agent', getallheaders())) {
				http_response_code(200);
			} else {
				header("Location: /home/index");
			}
		} else {
			if (array_key_exists('X-Async-Agent', getallheaders())) {
				http_response_code(202);
			} else {
				header("Location: /user/login?prompt=true");
			}
		}
		break;

	default:
		require("./views/header.php");
		require("./views/perdu.php");
		require("./views/footer.php");
		break;
}
