<?php
session_start();

// Connexion BDD
include_once "fonctions.php";

if (!isset($_SESSION["pseudo"]) || empty($_SESSION["pseudo"])) {
	$_SESSION = array();
	header("Location: connexion.php");
	exit;
}

$id = $_SESSION["id_membre"];

$result = $GLOBALS["bdd"]->prepare("DELETE FROM membre WHERE id_membre = :id LIMIT 1");
$result->bindParam(':id', $id);
$result->execute();

// Retourne le nombre d'insertion (0 ou 1)
$nombre = $result->RowCount();

if ($nombre == 1) {

	header("Location: deconnexion.php");
	exit;

} else {

	header("Location: profil.php?suppression=0");
	exit;

}

//Ferme le curseur, permettant à la requête d'être de nouveau exécutée
$result->closeCursor();

// Envoi mail

// Message de réussite

?>
