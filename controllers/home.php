<?php

require('./models/user.php');
require('./models/post.php');

$usermodel = new UserModel();
$postmodel = new PostModel();

switch ($action) {

	case "index":
		$nb_pages = $postmodel->getPages();
		$posts = $postmodel->getAll((array_key_exists('page', $_GET))?$_GET['page']:1);
		require("./views/header.php");
		require("./views/home.php");
		require("./views/footer.php");
		break;

	default:
		require("./views/header.php");
		require("./views/perdu.php");
		require("./views/footer.php");
		break;
}
