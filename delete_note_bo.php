
<?php
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";



$id = $_GET['id'];


$delete = $GLOBALS['bdd']->query("DELETE FROM note WHERE id_note = $id");




header('Location: gestion_note.php');
?>
