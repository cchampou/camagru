<?php

try {
	$db = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'b8gt5k98c');
} catch (Exception $e) {
	try {
		$db = new PDO('mysql:host=localhost', 'root', 'b8gt5k98c');
	} catch (Exception $e) {
		die("Impossible de se connecter à la base de données");
	}
}

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
