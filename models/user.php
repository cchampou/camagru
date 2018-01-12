<?php

class UserModel {

	public function __construct() {
		$this->db = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'b8gt5k98c');
	}

	private $db;

	public function signin($pseudo, $email, $password) {
		$existing = $this->db->prepare('SELECT * FROM users WHERE email = ?');
		$existing->execute(array($email));
		if (count($existing->fetchAll()) > 0) {
			throw new Exception("Cet email est déjà associé à un compte");
		}
		$create = $this->db->prepare('INSERT INTO users VALUES (null, ?, ?, ?)');
		$create->execute(array($pseudo, $email, password_hash($password, PASSWORD_BCRYPT)));
		return "Votre compte a été créé avec succès";
	}

	public function login($email, $password) {
		$user = $this->db->prepare("SELECT * FROM users WHERE email = ?");
		$user->execute(array($email));
		$userdata = $user->fetch();
		if (password_verify($password, $userdata['hash'])) {
			$_SESSION['id'] = $userdata['id'];
		} else {
			throw new Exception("Informations de connexion invalides");
		}
	}

	public function getUser($id) {
		$user = $this->db->prepare("SELECT * FROM users WHERE id = ?");
		$user->execute(array($id));
		return $user->fetch();
	}
}

?>
