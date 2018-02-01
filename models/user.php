<?php

require('config/database.php');

class UserModel {

	public function checkLoggedIn() {
		if ($_SESSION && $_SESSION['id']) {
			return true;
		} else {
			return false;
		}
	}

	public function reset($email) {
		global $db;
		$checkmail = $db->prepare("SELECT * FROM users WHERE email = ?");
		$checkmail->execute(array($email));
		$existing = $checkmail->fetch();
		if (!$existing) {
			throw new Exception("Cet email n'existe pas");
		}

		// envoi mail

	}

	public function resetPass($password, $confirmation, $token) {
		global $db;
		if ($password != $confirmation) {
			throw new Exception("Le mot de passe et sa confirmation ne correspondent pas");
		}
		if (strlen($password) < 8) {
			throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
		}
		$checkToken = $db->prepare("SELECT * FROM users WHERE activation_hash = ?");
		$checkToken->execute(array($token));
		$user = $checkToken->fetch();
		if (!$user['id']) {
			throw new Exception("Le token est invalide");
		}
		$setNew = $db->prepare("UPDATE users SET hash = ? WHERE id = ?");
		$setNew->execute(array(password_hash($password, PASSWORD_BCRYPT), $user['id']));
	}

	public function signup($pseudo, $email, $password, $confirmation) {
		global $db;
		if (strlen($pseudo) < 3 || !preg_match("/^[a-z_ \-0-9]*$/i", $pseudo)) {
			throw new Exception("Votre pseudo doit contenir au moins 3 caractères, alphanumériques uniquement (les espaces et les tirets sont égalements valides)");
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Cette adresse email n'est pas valide");
		}
		if (strlen($password) < 8) {
			throw new Exception("Le mot de passe doit contenir au moins 8 caractères");
		}
		if ($password != $confirmation) {
			throw new Exception("Le mot de passe et sa confirmation ne correspondent pas");
		}
		$activation_hash = md5(uniqid());
		$existing = $db->prepare('SELECT * FROM users WHERE email = ?');
		$existing->execute(array($email));
		if (count($existing->fetchAll()) > 0) {
			throw new Exception("Cet email est déjà associé à un compte");
		}
		$create = $db->prepare('INSERT INTO users (pseudo, email, hash, activation_hash) VALUES (?, ?, ?, ?)');
		if (!$create->execute(array($pseudo, $email, password_hash($password, PASSWORD_BCRYPT), $activation_hash))) {
			throw new Exception("Une erreur inconnue est survenue lors de la création du compte ".$pseudo.' '.$email);
		}
		echo mail($email, "Activation de votre compte Camagru", "test");
	}

	public function login($email, $password) {
		global $db;
		$user = $db->prepare("SELECT * FROM users WHERE email = ?");
		$user->execute(array($email));
		$userdata = $user->fetch();
		if ($userdata['active'] != 1) {
			throw new Exception("Veuillez valider votre compte pour y accéder");
		}
		if (password_verify($password, $userdata['hash'])) {
			$_SESSION['id'] = $userdata['id'];
		} else {
			throw new Exception("Informations de connexion invalides");
		}
	}

	public function activate($token) {
		global $db;
		$user = $db->prepare("UPDATE users SET active = 1 WHERE activation_hash = ?");
		$user->execute(array($token));
	}

	public function changePseudo($pseudo) {
		global $db;
		if (!$_SESSION['id']) {
			throw new Exception("Vous devez être connecté pour effectuer cette action");
		}
		if (strlen($pseudo) < 3 || !preg_match("/^[a-z_ \-0-9]*$/i", $pseudo)) {
			throw new Exception("Votre pseudo doit contenir au moins 3 caractères, alphanumériques uniquement (les espaces et les tirets sont égalements valides)");
		}
		$change = $db->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
		if (!$change->execute(array($pseudo, $_SESSION['id']))) {
			throw new Exception("Une erreur inconnue s'est produite, veuillez réesayer");
		}
	}

	public function changeEmail($email) {
		global $db;
		if (!$_SESSION['id']) {
			throw new Exception("Vous devez être connecté pour effectuer cette action");
		}
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw new Exception("Cette adresse email n'est pas valide");
		}
		$change = $db->prepare("UPDATE users SET email = ? WHERE id = ?");
		if (!$change->execute(array($email, $_SESSION['id']))) {
			throw new Exception("Une erreur inconnue s'est produite, veuillez réesayer");
		}
	}

	public function changePass($password, $new, $confirm) {
		global $db;
		if (!$_SESSION['id']) {
			throw new Exception("Vous devez être connecté pour effectuer cette action");
		}
		if (strlen($new) < 8) {
			throw new Exception("Le nouveau mot de passe doit contenir au moins 8 caractères");
		}
		if ($new != $confirmation) {
			throw new Exception("Le nouveau mot de passe et sa confirmation ne correspondent pas");
		}
		$user = $this->getUser($_SESSION['id']);
	}

	public function getUser($id) {
		global $db;
		$user = $db->prepare("SELECT * FROM users WHERE id = ?");
		$user->execute(array($id));
		return $user->fetch();
	}
}
