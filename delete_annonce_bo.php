
<?php
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";



$id = $_GET['id'];


$delete = $GLOBALS['bdd']->query("DELETE FROM annonces WHERE id_annonce = $id");
$delete = $GLOBALS['bdd']->query("DELETE FROM photo WHERE id_annonce = $id");




header('Location: annonce.php');
?>
