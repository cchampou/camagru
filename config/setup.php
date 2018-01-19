<?php
echo "Connexion au serveur MySQL...<br />";
require("database.php");
echo "Récupération des requêtes d'initialisation...<br />";
$init_query = file_get_contents("./init.sql");
echo "Création de la base et des tables...<br />";
$init = $db->prepare($init_query);
if ($init->execute()) {
	echo "Initialisation terminée";
} else {
	echo "Erreur";
}
