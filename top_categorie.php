<?php
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";
if ($_SESSION['statut'] != 1) {
  header('Location : index.php');
}

/******************
  Tableau membre
*******************/

$visuMembre ="";
$visumenbre = '';
$insert = '';






$membreResult = $GLOBALS['bdd']->prepare("SELECT titre_categorie, COUNT(categorie.id_annonce) FROM annonces, categorie WHERE annonces.id_annonce = categorie.id_annonce GROUP BY titre_categorie ORDER BY COUNT(categorie.id_annonce) DESC LIMIT 0,5");

$membreResult->execute();

 $result = $membreResult->RowCount();

$i = 0;

while($donnes_commentaire = $membreResult->fetch()){
  $i++;
  $visumenbre .= "<p>". $i . " - " .$donnes_commentaire['titre_categorie'];
  $visumenbre .= "<span style='background:lightblue;border-radius:15px;padding:2px;margin-left:10px;'> Nombre d'annonce postée : " .$donnes_commentaire['COUNT(categorie.id_annonce)'] . "</span></p><hr>";
}



 ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>SB Admin - Start Bootstrap Template</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <!-- Fontawesome-->
  <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <?php include_once('aside.php')?>
  <div class="content-wrapper">

    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Tables</li>
      </ol>

      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Data Table Example</div>
        <div class="card-body">


                <h1><?=$insert?></h1>

                <div class="affichageCom container">
                <div style='text-align:center'>

                  <?=$visumenbre?>

               </div>
              </div>
        </div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
      </div>
    </div>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © annonceo 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Etes-vous sûr?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Cliquez sur deconnexion pour confirmer</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">annuler</button>
            <a class="btn btn-primary" href="deconnexion.php">Deconnexion</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
  </div>
</body>

</html>
