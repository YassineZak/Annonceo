
<?php
session_start();


// Connexion BDD et fonctions
include_once "fonctions.php";
if ($_SESSION['statut'] != 1) {
  header('Location : index.php');
}

$categorie = "";
$cat = $GLOBALS['bdd']->query('SELECT id_categorie, titre_categorie from categorie');

//$Cat = $cat->fetchall(PDO::FETCH_ASSOC);
//$Cat = $cat->fetchAll();

  foreach ($cat as $value)  {
    $categorie .= "<option value='" . $value["id_categorie"] . "'>" . $value['titre_categorie'] . "</option>";
  }






/******************
    MODIFICATION
********************/

$messagesParPage=3; //Nous allons afficher 5 messages par page.

//Une connexion SQL doit être ouverte avant cette ligne...
$retour_total = $GLOBALS['bdd']->query("SELECT COUNT(*) AS total FROM membre"); //Nous récupérons le contenu de la requête dans $retour_total
$donnees_total= $retour_total->fetch(); //On range retour sous la forme d'un tableau.
$total=$donnees_total['total']; //On récupère le total pour le placer dans la variable $total.

//Nous allons maintenant compter le nombre de pages.
$nombreDePages=ceil($total/$messagesParPage);

if(isset($_GET['page'])) // Si la variable $_GET['page'] existe...
{
     $pageActuelle=intval($_GET['page']);

     if($pageActuelle>$nombreDePages) // Si la valeur de $pageActuelle (le numéro de la page) est plus grande que $nombreDePages...
     {
          $pageActuelle=$nombreDePages;
     }
}
else // Sinon
{
     $pageActuelle=1; // La page actuelle est la n°1
}


$membreParPage=10;
$premiereEntree=($pageActuelle-1)*$membreParPage; // On calcul la première entrée à lire


/******************
  Tableau membre
*******************/

$visuMembre ="";




$id = $_GET['id'];


$modif = $GLOBALS['bdd']->query("SELECT * FROM membre as m, photo as p, annonces as a, categorie as c
  WHERE m.id_membre = a.id_membre AND a.id_annonce = p.id_annonce AND c.id_annonce = a.id_annonce
  AND a.id_annonce = $id");


$modif_annonce = $modif->fetch();


$titre = $_POST['titre'];
$description = $_POST['description'];
$prix = $_POST['prix'];
$ville = $_POST['ville'];
$adresse = $_POST['adresse'];
$cp = $_POST['cp'];
$categories = $_POST['categorie'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];

var_dump($titre);

if (isset($titre)) {

  $modification = $GLOBALS['bdd']->query("UPDATE annonces SET titre = '$titre', prix = '$prix', ville = '$ville', adresse = '$adresse', cp = '$cp', longitude = '$longitude', latitude= '$latitude'  WHERE id_annonce = $id");
  $modificationCat = $GLOBALS['bdd']->query("UPDATE categorie SET titre_categorie = '$categorie'  WHERE id_annonce = $id");

if(isset($description) && !empty($description)){
  $modificationdescription = $GLOBALS['bdd']->query("UPDATE annonces SET description = '$description' WHERE id_annonce = $id");
  }
  header('Location: annonce.php');
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
  <link rel="stylesheet" href="./css/style.css">

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
          <form class="taskOption" action="" method="post" >
          <input type="text" placeholder="Titre" name="titre" value="<?=$modif_annonce['titre']?>" class="modifMembre" >
          <input type="text" placeholder="prix" name="prix" value="<?=$modif_annonce['prix']?>" class=" modifMembre" >
          <select name="categorie" class="modifMembre">
          <option value="">Toutes les catégories </option>
          <option value="vehicule"<?php if($modif_annonce['titre_categorie'] == "vehicule"){echo "selected";} ?>>Vehicule </option>
          <option value="immobilier"<?php if($modif_annonce['titre_categorie'] == "immobilier"){echo "selected";}?>>Immobilier </option>
          <option value="vacances"<?php if($modif_annonce['titre_categorie'] == "vacances"){echo "selected";}?>>Vacances </option>
          <option value="multimedia"<?php if($modif_annonce['titre_categorie'] == "multimedia"){echo "selected";}?>>Multimédia </option>
          <option value="loisirs"<?php if($modif_annonce['titre_categorie'] == "loisirs"){echo "selected";}?>>Loisirs </option>
          <option value="materiel"<?php if($modif_annonce['titre_categorie'] == "materiel"){echo "selected";}?>>Matériel </option>
          <option value="services"<?php if($modif_annonce['titre_categorie'] == "services"){echo "selected";}?>>Services </option>
          <option value="vetements"<?php if($modif_annonce['titre_categorie'] == "vetements"){echo "selected";}?>>Vetements </option>
          <option value="autres"<?php if($modif_annonce['titre_categorie'] == "autres"){echo "selected";}?>>Autres </option>
          <option class="emploi" value="emploi"<?php if($modif_annonce['titre_categorie'] == "emploi"){echo "selected";}?>>Emploi </option>
          </select>
          <label id="descriptionUpdate">Description</label>
          <textarea class="modifMembre " name="description" rows="3" cols="30"></textarea>
          <input id="user_input_autocomplete_address" type="text" name="adresse" value="<?=$modif_annonce['adresse']?>"placeholder="Saisissez votre adresse complete" class="modifMembre">
          <input id="postal_code" name="cp" placeholder="Votre code postal" value="<?=$modif_annonce['cp']?>" class="modifMembre">
          <input type="text" id="locality" name="ville" placeholder="Votre ville" value="<?=$modif_annonce['ville']?>" class="modifMembre">
          <input type="hidden" id="latitude" value="<?=$modif_annonce['latitude']?>" name="latitude">
          <input type="hidden" id="longitude" value="<?=$modif_annonce['longitude']?>" name="longitude">
          <input type="submit" name="inscription" value="modifier le Profil" class="modifMembre btn btn-primary ">
          </form>

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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDL7hlhkmmtu3maLOHUIx90UWWpkwKS3tg"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="./js/jquery-ias.min.js"></script>
    <script type="text/javascript" src="./js/script.js"></script>
    </script>
  </div>
</body>

</html>
