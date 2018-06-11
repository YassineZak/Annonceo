
<?php
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";



$id = $_GET['id'];


$delete = $GLOBALS['bdd']->query("DELETE FROM membre WHERE id_membre = $id");
$deleteannonce = $GLOBALS['bdd']->query("DELETE FROM annonces LEFT JOIN photo ON annonces.id_annonce = photo.id_annonce WHERE annonces.id_membre = $id");
$deletecommentaire = $GLOBALS['bdd']->query("DELETE FROM commentaire WHERE id_membre = $id");
$deletenote = $GLOBALS['bdd']->query("DELETE FROM note WHERE id_membre_deposant = $id");




header('Location: membre.php');
?>
