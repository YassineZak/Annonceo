
<?php
session_start();

if ($_SESSION['statut'] != 1) {
  header('Location : index.php');
}
// Connexion BDD et fonctions
include_once "fonctions.php";

$message = '';
/******************
  Tableau membre
*******************/

$visuMembre ="";



if (isset($_POST["recherche"])) {
  $condition1 ="";
                  $recherche = "%" . $_POST["recherche"] . "%";
                  $condition1 = "AND titre LIKE '$recherche'";


                  $annonce = $GLOBALS['bdd']->query("SELECT * FROM membre as m, photo as p, annonces as a, categorie as c
                    WHERE m.id_membre = a.id_membre AND a.id_annonce = p.id_annonce AND c.id_annonce = a.id_annonce $condition1
                    ORDER BY a.date_enregistrement  DESC");
if (!empty($condition)) {
                  $annonce->BindParam(":titre", $recherche);
}
$annonce->execute();

 $result = $annonce->RowCount();

if ($result > 0){
  while($donnes_annonce = $annonce->fetch()) // On lit les entrées une à une grâce à une boucle
 {
   $descriptionAnnonce = raccourcirChaine($donnes_annonce['description'], 150);

   $visuMembre .= "<tr>";
   $visuMembre .= "<td>" . $donnes_annonce['id_annonce'] ."</td>";
   $visuMembre .= "<td>" . $donnes_annonce['titre'] ."</td>";
   $visuMembre .= "<td>" . $descriptionAnnonce . "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['prix'] . " €</td>";
   $visuMembre .= "<td><img src='../" . $donnes_annonce['photo1'] . "' style='height:80px;'></td>";
   $visuMembre .= "<td>" . $donnes_annonce['ville'] . "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['adresse'] . "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['cp'] . "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['pseudo'] .  "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['titre_categorie'] .  "</td>";
   $visuMembre .= "<td>" . $donnes_annonce['date_enregistrement'] .  "</td>";
   $visuMembre .= "<td> <a href='page_annonce.php?id=" . $donnes_annonce['id_annonce'] ."'><i class='fa fa-search' aria-hidden='true'></i></a> <a href='update_annonce.php?id=" . $donnes_annonce['id_annonce'] ."'>><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a href='delete_annonce.php?id=" . $donnes_annonce['id_annonce'] ."'><i class='fa fa-times' aria-hidden='true'></i></a> </td>";
   $visuMembre .= "</tr>";
 }
}
}else{

  $annonce = $GLOBALS['bdd']->query("SELECT * FROM membre as m, photo as p, annonces as a, categorie as c
    WHERE m.id_membre = a.id_membre AND a.id_annonce = p.id_annonce AND c.id_annonce = a.id_annonce
    ORDER BY a.date_enregistrement DESC");

  while($donnes_annonce = $annonce->fetch()) // On lit les entrées une à une grâce à une boucle
  {
    $descriptionAnnonce = raccourcirChaine($donnes_annonce['description'], 150);
    $visuMembre .= "<tr>";
    $visuMembre .= "<td>" . $donnes_annonce['id_annonce'] ."</td>";
    $visuMembre .= "<td>" . $donnes_annonce['titre'] ."</td>";
    $visuMembre .= "<td>" . $descriptionAnnonce . "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['prix'] . " €</td>";
    $visuMembre .= "<td><img src='../" . $donnes_annonce['photo1'] . "' style='height:80px;'></td>";
    $visuMembre .= "<td>" . $donnes_annonce['ville'] . "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['adresse'] . "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['cp'] . "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['pseudo'] .  "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['titre_categorie'] .  "</td>";
    $visuMembre .= "<td>" . $donnes_annonce['date_enregistrement'] .  "</td>";
    $visuMembre .= "<td> <a href='page_annonce.php?id=" . $donnes_annonce['id_annonce'] ."'><i class='fa fa-search' aria-hidden='true'></i></a> <a href='update_annonce.php?id=" . $donnes_annonce['id_annonce'] ."'>><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a href='delete_annonce_bo.php?id=" . $donnes_annonce['id_annonce'] ."'><i class='fa fa-times' aria-hidden='true'></i></a> </td>";
    $visuMembre .= "</tr>";
  }
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

          <div class="table-responsive">
            <table class="table table-bordered"  width="100%" cellspacing="0">
              <form class="navbar-form navbar-left" method="post">
                <div class="form-group">
                  <input type="text" class="form-control" name="recherche" placeholder="Rechercher...">
                </div>
                <button type="submit" class="btn btn-default">Rechercher</button>
              </form>
                <h1><?=$message?></h1>
              <thead>
                <tr>
                  <th>id annonce</th>
                  <th>titre</th>
                  <th>description</th>
                  <th>prix</th>
                  <th>photo</th>
                  <th>ville</th>
                  <th>adresse</th>
                  <th>code postal</th>
                  <th>membre</th>
                  <th>categorie</th>
                  <th>date enregistrement</th>
                  <th>action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>id annonce</th>
                  <th>titre</th>
                  <th>description</th>
                  <th>prix</th>
                  <th>photo</th>
                  <th>ville</th>
                  <th>adresse</th>
                  <th>code postal</th>
                  <th>membre</th>
                  <th>categorie</th>
                  <th>date enregistrement</th>
                  <th>action</th>
                </tr>
              </tfoot>
              <tbody>
                <?=$visuMembre?>
              </tbody>
            </table>

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
          <small>Copyright © Annonceo 2017</small>
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
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.html">Logout</a>
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
