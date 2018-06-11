
<?php
session_start();
if ($_SESSION['statut'] != 1) {
  header('Location : index.php');
}

// Connexion BDD et fonctions
include_once "fonctions.php";


/******************
  Tableau membre
*******************/

$visuMembre ="";
$insert = '';


if (isset($_POST["recherche"])) {
  $condition1 ="";
                  $recherche = "%" . $_POST["recherche"] . "%";
                  $condition1 = "WHERE pseudo LIKE '$recherche'";


$membreResult = $GLOBALS['bdd']->prepare("SELECT * from membre  $condition1  ORDER BY date_enregistrement_membre DESC");
if (!empty($condition)) {
                  $membreResult->BindParam(":pseudo", $recherche);
}
$membreResult->execute();

 $result = $membreResult->RowCount();


if ($result > 0){
  while($donnes_membres = $membreResult->fetch()) // On lit les entrées une à une grâce à une boucle
 {
   $visuMembre .= "<tr>";
   $visuMembre .= "<td>" . $donnes_membres['id_membre'] ."</td>";
   $visuMembre .= "<td>" . $donnes_membres['pseudo'] ."</td>";
   $visuMembre .= "<td>" . $donnes_membres['nom'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['prenom'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['email'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['telephone'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['civilite'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['statut'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['adresse_membre'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['ville'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['cp'] . "</td>";
   $visuMembre .= "<td>" . $donnes_membres['date_enregistrement_membre'] .  "</td>";
   $visuMembre .= "<td>  <a href='#'> <i class='fa fa-search' aria-hidden='true'></i></a> <a href='modif_membre.php?id=" . $donnes_membre['id_membre'] ."'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a><a href='delete.php?id=" . $donnes_membre['id_membre'] ."'> <i class='fa fa-times' aria-hidden='true'></i></a> </td>";
   $visuMembre .= "</tr>";
 }
}
}else{
  $membre = $GLOBALS['bdd']->query("SELECT * FROM membre ORDER BY date_enregistrement_membre DESC");

  while($donnes_membre = $membre->fetch()) // On lit les entrées une à une grâce à une boucle
  {
    $visuMembre .= "<tr>";
    $visuMembre .= "<td>" . $donnes_membre['id_membre'] ."</td>";
    $visuMembre .= "<td>" . $donnes_membre['pseudo'] ."</td>";
    $visuMembre .= "<td>" . $donnes_membre['nom'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['prenom'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['email'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['telephone'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['civilite'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['statut'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['adresse_membre'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['ville'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['cp'] . "</td>";
    $visuMembre .= "<td>" . $donnes_membre['date_enregistrement_membre'] .  "</td>";
    $visuMembre .= '<td><a href="modif_membre.php?id=' . $donnes_membre['id_membre'] .'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a> <a href="delete.php?id=' . $donnes_membre['id_membre'] .'"><i class="fa fa-times" aria-hidden="true"></i></a> </td>';
    $visuMembre .= "</tr>";
  }
}


/******************
    INSCRIPTION
********************/

$prenom = "";
$nom = "";
$pseudo1 = "";
$email = "";
$passe = "";
$civilite = "";
$cp = "";
$ville = "";
$adresse = "";
$telephone = "";
$statut = "";
$ville = "";
$cp = "";


if (isset($_POST["prenom"])) {

  $prenom = $_POST["prenom"];
	$nom = $_POST["nom"];
	$pseudo1 = $_POST["pseudo1"];
	$email = $_POST["email"];
	$passe = $_POST["passe"];
	$civilite = $_POST["civilite"];
	$telephone = $_POST["telephone"];
	$statut = $_POST["statut"];
  $adresse = $_POST["adresse"];
  $ville = $_POST["ville"];
  $cp = $_POST["cp"];

	// Vérifier les données
	if (empty($_POST["prenom"]) || empty($_POST["nom"]) || empty($_POST["pseudo1"]) || empty($_POST["email"]) || empty($_POST["passe"]) || empty($_POST["civilite"]) || empty($_POST["telephone"]) || empty($_POST["adresse"]) || empty($_POST["ville"]) || empty($_POST["cp"])) {

		$message = "Remplir tous les champs";

	} else {

		// Si OK, insérer dans la base de données
		// Nous pourrions également utiliser exec sans requêtes préparées
		$result = $GLOBALS['bdd']->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, telephone, civilite, statut, adresse_membre, ville, cp) VALUES (:pseudo, :passe, :nom, :prenom, :email, :telephone, :civilite, :statut, :adresse, :ville, :cp)");

		$result->bindParam(':pseudo', $pseudo1);
		$result->bindParam(':passe', $passe);
		$result->bindParam(':nom', $nom);
		$result->bindParam(':prenom', $prenom);
		$result->bindParam(':email', $email);
		$result->bindParam(':civilite', $civilite);
		$result->bindParam(':telephone', $telephone);
		$result->bindParam(':statut', $statut);
    $result->bindParam(':adresse', $adresse);
    $result->bindParam(':ville', $ville);
    $result->bindParam(':cp', $cp);
		$result->execute();

		// Retourne un résultat (étape 3)
		$nombre = $result->RowCount();

		// Affiche message si non trouvé ou récupère message, session et redirection
		if ($nombre < 1) {

			$insert = "erreur insertion";

		} else {

      $insert = "L'insertion du membre à fonctionner";


		}
  }
}


 ?>

<!DOCTYPE html>
<html lang="fr">

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
          <a href="index.php">Acceuil</a>
        </li>
        <li class="breadcrumb-item active">Gestion</li>
      </ol>

      <!-- Example DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Gestion des Membres</div>
        <div class="card-body">

          <div class="table-responsive">
            <table   class="table table-bordered" cellspacing="0">
              <form class="navbar-form navbar-left" method="post">
                <div id='tableauMembre' class="form-group">
                  <input type="text" class="form-control" name="recherche" placeholder="Rechercher...">
                </div>
                <button type="submit" class="btn btn-default">Rechercher</button>
              </form>
                <h1><?=$insert?></h1>
              <thead>
                <tr>
                  <th>id membre</th>
                  <th>pseudo</th>
                  <th>nom</th>
                  <th>prenom</th>
                  <th>email</th>
                  <th>telephone</th>
                  <th>civilite</th>
                  <th>statut</th>
                  <th>adresse</th>
                  <th>Ville</th>
                  <th>Code Postal</th>
                  <th>date enregistrement</th>
                  <th>action</th>
                </tr>
              </thead>
              <tbody>
                <?=$visuMembre?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <form method="post">
      <div class="form-row justify-content-center">
        <div class="form-group col-md-4 ">
        <label for="pseudo1">Pseudo</label>
        <input type="text" class="form-control"  name="pseudo1" value="" placeholder="Pseudo">
      </div>
        <div class="form-group col-md-4 ">
          <label for="email">Email</label>
          <input type="email" class="form-control" id="inputEmail4" name="email" value="" placeholder="Email">
        </div>
      </div>
      <div class="form-row justify-content-center">
        <div class="form-group col-md-4">
          <label for="passe">Mot de passe</label>
          <input type="password" class="form-control" id="inputPassword4" name="passe" value="" placeholder="Mot de passe">
        </div>
        <div class="form-group col-md-4">
          <label for="nom">Nom</label>
          <input type="text" class="form-control"  name="nom" value="" placeholder="Nom">
        </div>
      </div>
    <div class="form-row justify-content-center">
      <div class="form-group col-md-4">
        <label for="prenom">Prenom</label>
        <input type="text" class="form-control"  name="prenom" value="" placeholder="Prenom">
      </div>
        <div class="form-group col-md-4">
          <label for="adresse">Adresse</label>
          <input id="user_input_autocomplete_address" name="adresse" placeholder="Saisissez votre adresse complete" value="" class=" form-control"></input>
        </div>
        </div>
        <div class="form-row justify-content-center">
        <div class="form-group col-md-4">
          <label for="adresse">Ville</label>
          <input type="text" id="locality" name="ville" placeholder="Ville" value="" class="form-control">
        </div>
        <div class="form-group col-md-4">
          <label for="adresse">Code Postal</label>
          <input type="text" id="postal_code" name="cp" placeholder="Code Postal" value="" class="form-control">
        </div>
        </div>
        <div class="form-row justify-content-center">
        <div class="form-group col-md-4">
        <label>Numéro de téléphone</label>
        <input type="telephone" class="form-control" pattern="^((\+\d{1,3}(-| )?\(?\d\)?(-| )?\d{1,5})|(\(?\d{2,6}\)?))(-| )?(\d{3,4})(-| )?(\d{4})(( x| ext)\d{1,5}){0,1}$" name="telephone" value="" placeholder="Votre numéro de téléphone">
      </div>
    </div>
  <div class="form-row justify-content-center">
    <div class="form-group col-md-4">
      <label for="civilite">Civilité : </label>
      Homme <input type="radio" name="civilite" placeholder="sexe" id="sexe" value="Homme" checked="">
      - Femme <input type="radio" name="civilite" placeholder="sexe" id="sexe" value="Femme">
    </div>
    <div class="form-group col-md-4">
      <label for="statut">Statut : </label>
      Non admin <input type="radio" name="statut"  id="statut" value="0" checked="">
      - Admin <input type="radio" name="statut" id="statut" value="1">
    </div>
  </div>
  <div class="modal-footer">
    <button type="submit" class="btn btn-primary" name="envoi">Ajouter membre</button>
  </div>
    </form>
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
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="./js/jquery-ias.min.js">
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDL7hlhkmmtu3maLOHUIx90UWWpkwKS3tg"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/script.js"></script>
  </div>
</body>

</html>
