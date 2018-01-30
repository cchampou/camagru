<?php

require('./models/user.php');
require('./models/post.php');

$usermodel = new UserModel();
$postmodel = new PostModel();

switch ($action) {
	case 'login':
		$message = NULL;
		if ($_GET && array_key_exists('prompt', $_GET) && $_GET['prompt'] == "true") {
			$message = '<p class="message fail">Vous devez être connecté pour faire ceci</p>';
		}
		if ($_POST && $_POST['email'] && $_POST['password']) {
			try {
				$message = $usermodel->login($_POST['email'], $_POST['password']);
				header("Location:/");
			} catch (Exception $e) {
				$message = '<p class="message fail">'.$e->getMessage().'</p>';
			}
		}
		require("./views/header.php");
		require("./views/login.php");
		require("./views/footer.php");
		break;

	case 'logout':
		session_unset();
		session_destroy();
		header("Location:/");
		break;

	case 'signup':
		if ($_POST && $_POST['email'] && $_POST['pseudo'] && $_POST['password'] && $_POST['confirmation']) {
			try {
				$usermodel->signup($_POST['pseudo'], $_POST['email'], $_POST['password'], $_POST['confirmation']);
				header("Location:/user/login");
			} catch (Exception $e) {
				$message = '<p class="message fail">'.$e->getMessage().'</p>';
			}
		} else if ($_POST) {
			$message = '<p class="message fail">Veuillez renseigner tous les champs</p>';
		}
		require("./views/header.php");
		require("./views/signup.php");
		require("./views/footer.php");
		break;

	case "account":
		if ($usermodel->checkLoggedIn()) {
			if ($_POST) {
				if (array_key_exists('changePseudo', $_POST)) {
					if (array_key_exists('pseudo', $_POST) && $_POST['pseudo']) {
						try {
							$usermodel->changePseudo($_POST['pseudo']);
							unset($_POST['pseudo']);
							$message1 = '<p class="message success">Votre peudo a été modifié avec succès</p>';
						} catch (Exception $e) {
							$message1 = '<p class="message fail">'.$e->getMessage().'</p>';
						}
					} else {
						$message1 = '<p class="message fail">Veuillez renseigner tous les champs</p>';
					}
				}
				if (array_key_exists('changeEmail', $_POST)) {
					if (array_key_exists('email', $_POST) && $_POST['email']) {
						try {
							$usermodel->changeEmail($_POST['email']);
							unset($_POST['email']);
							$message2 = '<p class="message success">Votre adresse email a été modifiée avec succès</p>';
						} catch (Exception $e) {
							$message2 = '<p class="message fail">'.$e->getMessage().'</p>';
						}
					} else {
						$message2 = '<p class="message fail">Veuillez renseigner tous les champs</p>';
					}
				}
				if (array_key_exists('changePass', $_POST)) {
					if (array_key_exists('oldpassword', $_POST) && array_key_exists('password', $_POST) && array_key_exists('confirmation', $_POST)
						&& $_POST['oldpassword'] && $_POST['password'] && $_POST['confirmation']) {
						try {
							$usermodel->changePass($_POST['oldpassword'], $_POST['password'], $_POST['confirmation']);
							unset($_POST['oldpassword']);
							unset($_POST['password']);
							unset($_POST['confirmation']);
							$message2 = '<p class="message success">Votre mot de passe a été modifié avec succès</p>';
						} catch (Exception $e) {
							$message3 = '<p class="message fail">'.$e->getMessage().'</p>';
						}
					} else {
						$message3 = '<p class="message fail">Veuillez renseigner tous les champs</p>';
					}
				}
			}
			$user = $usermodel->getUser($_SESSION['id']);
			require("./views/header.php");
			require("./views/account.php");
			require("./views/footer.php");
		} else {
			header("Location: /user/login?prompt=true");
		}
		break;

	case "shot":
		if ($usermodel->checkLoggedIn()) {
			$message = NULL;
			if ($_POST) {
				switch ($_POST['overlay']) {
					case 1:
						$overlay = imagecreatefrompng("cool.png");
						break;
					case 2:
						$overlay = imagecreatefrompng("idc.png");
						break;
					case 3:
						$overlay = imagecreatefrompng("dude.png");
						break;
					default:
						break;
				}
				$overlayx = imagesx($overlay);
				$overlayy = imagesy($overlay);
				if (array_key_exists('imgdata', $_POST) && $_POST['imgdata']) {
					$res = imagecreatefrompng($_POST['imgdata']);
					$resx = imagesx($res);
					$resy = imagesy($res);
					$dest_hash = md5(uniqid(rand(), true));
					$dest = "uploads/".$dest_hash.".jpg";
					imagecopyresampled($res, $overlay, 0, 0, 0, 0, $resx, $resy, $overlayx, $overlayy);
					imagejpeg($res, $dest);
					$postmodel->create($dest);
					$message = '<p class="message success">Image enregistrée.</p>';
				} else if (array_key_exists('shot', $_FILES) && $_FILES['shot']['tmp_name']) {
					$valid_ext = array('jpg', 'jpeg', 'png');
					$ext = strtolower(substr(strrchr($_FILES['shot']['name'], '.'), 1));
					if (in_array($ext, $valid_ext)) {
						$dest_hash = md5(uniqid(rand(), true));
						$dest = "uploads/".$dest_hash.".".$ext;
						if (move_uploaded_file($_FILES['shot']['tmp_name'], $dest)) {
							if ($ext == 'jpg' || $ext == 'jpeg') {
								$res = imagecreatefromjpeg($dest);
							} else if ($ext == 'png') {
								$res = imagecreatefrompng($dest);
								unlink($dest);
							}
							$resx = imagesx($res);
							$resy = imagesy($res);
							$overlayx = imagesx($overlay);
							$overlayy = imagesy($overlay);
							imagecopyresampled($res, $overlay, 0, 0, 0, 0, $resx, $resy, $overlayx, $overlayy);
							imagejpeg($res, "uploads/".$dest_hash.".jpg");
							$postmodel->create("uploads/".$dest_hash.".jpg");
							$message = '<p class="message success">Image enregistrée.</p>';
						} else {
							$message = '<p class="message fail">Erreur lors de l\'envoi de l\'image.</p>';
						}
					} else {
						$message = '<p class="message fail">Extension de fichier invalide, seules les images en .jpg, .jpeg et .png sont acceptées.';
					}
				} else {
					$message = '<p class="message fail">Vous n\'avez pas sélectionné d\'image.';
				}
			}
			$previous = $postmodel->getMine();
			require("./views/header.php");
			require("./views/shot.php");
			require("./views/footer.php");
		} else {
			header("Location: /user/login?prompt=true");
		}
		break;

	default:
		require("./views/header.php");
		require("./views/perdu.php");
		require("./views/footer.php");
		break;
}
