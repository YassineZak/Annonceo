<?php
session_start();
include_once "fonctions.php";
if (isset($_SESSION["pseudo"]) || !empty($_SESSION["pseudo"])) {
}
else {
  header("Location: index.php");
  exit;
}



$id = $_GET['id'];


$delete = $GLOBALS['bdd']->query("DELETE FROM annonces WHERE id_annonce = $id");
$delete = $GLOBALS['bdd']->query("DELETE FROM photo WHERE id_annonce = $id");




header('Location: profil.php');
?>
