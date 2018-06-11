
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



if (isset($_POST["recherche"])) {
  $condition1 ="";
                  $recherche = "%" . $_POST["recherche"] . "%";
                  $condition1 = "WHERE pseudo LIKE '$recherche'";


$membreResult = $GLOBALS['bdd']->prepare("SELECT * from commentaire LEFT JOIN membre ON commentaire.id_membre = membre.id_membre
  LEFT JOIN annonces ON commentaire.id_annonce = annonces.id_annonce
   $condition1  ORDER BY date_enregistrement_com DESC ");
if (!empty($condition)) {
      $membreResult->BindParam(":pseudo", $recherche);
}
$membreResult->execute();

 $result = $membreResult->RowCount();


if ($result > 0){
  while($donnes_commentaire = $membreResult->fetch()) // On lit les entrées une à une grâce à une boucle
  {
    $visuMembre .= "<tr>";
    $visuMembre .= "<td>" . $donnes_commentaire['id_commentaire'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['membre.pseudo'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['id_annonce'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['commentaire'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['date_enregistrement_com'] .  "</td>";
    $visuMembre .= "<td> <a href='#'><i class='fa fa-search' aria-hidden='true'></i></a> <a href='modif_membre.php?id=" . $donnes_commentaire['id_membre'] ."'>><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a> <a href='delete.php?id=" . $donnes_membre['id_membre'] ."'><i class='fa fa-trash' aria-hidden='true'></i></a> </td>";
    $visuMembre .= "</tr>";
  }
}
}else{
  $membre = $GLOBALS['bdd']->query("SELECT * from commentaire LEFT JOIN membre ON commentaire.id_membre = membre.id_membre
    LEFT JOIN annonces ON commentaire.id_annonce = annonces.id_annonce
     $condition1  ORDER BY date_enregistrement_com DESC ");

  while($donnes_commentaire = $membre->fetch()) // On lit les entrées une à une grâce à une boucle
  {
    $visuMembre .= "<tr>";
    $visuMembre .= "<td>" . $donnes_commentaire['id_commentaire'] ."</td>";
  $visuMembre .= "<td>" . $donnes_commentaire['id_membre'] .  " - " . $donnes_commentaire['pseudo'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['titre'] ."</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['commentaire'] . "</td>";
    $visuMembre .= "<td>" . $donnes_commentaire['date_enregistrement_com'] .  "</td>";
    $visuMembre .= "<td> <a href='../annonce.php?id=" . $donnes_commentaire['id_annonce'] ."'><i class='fa fa-search' aria-hidden='true'></i> <a href='delete_com.php?id=" . $donnes_commentaire['id_commentaire'] ."'> <i class='fa fa-trash' aria-hidden='true'></i>
    </a> </td>";
    $visuMembre .= "</tr>";
  }
}

/******************
    Pagination
********************/


$pagination ="";
$pagination = '<ul class="pagination justify-content-center">'; //Pour l'affichage, on centre la liste des pages
for($i=1; $i<=$nombreDePages; $i++) //On fait notre boucle
{
     //On va faire notre condition
     if($i==$pageActuelle) //Si il s'agit de la page actuelle...
     {
       $pagination .= ' <li class="page-item"><a class="page-link" href="tables.php?page=' .$i.'"> '.$i. ' </a> </li> ';
     }
     else //Sinon...
     {
          $pagination .= '<li class="page-item"> <a class="page-link" href="tables.php?page='.$i.'">'.$i.'</a> </li>';
     }


}
$pagination .= '</ul>';



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
                <h1><?=$insert?></h1>
              <thead>
                <tr>
                  <th>id commentaire</th>
                  <th>Membre</th>
                  <th>Titre annonce</th>
                  <th>commentaire</th>
                  <th>Date de depot</th>
                  <th>action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>id commentaire</th>
                  <th>Membre</th>
                  <th>Titre annonce</th>
                  <th>commentaire</th>
                  <th>Date de depot</th>
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
      <?=$pagination?>
    </div>

    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2017</small>
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
