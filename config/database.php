<?php

try {
	$db = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'b8gt5k98c');
} catch (Exception $e) {
	try {
		$db = new PDO('mysql:host=localhost', 'root', 'b8gt5k98c');
		if (!isset($setup_mode) || $setup_mode = false) {
			die("Connecté au serveur SQL mais DB 'camagru' inexistante, veuillez executer le setup. <a href=\"/config/setup.php\">Configurer maintenant</a><br />");
		}
	} catch (Exception $e) {
		die("Impossible de se connecter à la base de données");
	}
}

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
