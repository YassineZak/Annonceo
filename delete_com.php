<?php
//initialise la séssion
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";

$id = $_GET['id'];


$delete = $GLOBALS['bdd']->query("DELETE FROM commentaire WHERE id_commentaire = $id");




header('Location: commentaire.php');
?>
