<?php
echo "Connexion au serveur MySQL...<br />";
$setup_mode = true;
require("database.php");
echo "Récupération des requêtes d'initialisation...<br />";
$init_query = file_get_contents("./init.sql");
echo "Création de la base et des tables...<br />";
$init = $db->prepare($init_query);
if ($init->execute()) {
	echo 'Initialisation terminée <a href="/">Let\'s have fun</a>';
} else {
	echo "Erreur";
}
