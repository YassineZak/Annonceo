<?php
session_start();



// Connexion BDD et fonctions
include_once "fonctions.php";
if ($_SESSION['statut'] != 1) {
  header('Location : index.php');
}
$email = '';
$message = '';
$pseudo = '';
$prenom = '';
$nom = '';
$telephone = '';
$cp = '';
$ville = '';
$mdp = '';
$statut = '';
$adresse = '';
$message = "";
$pseudoEntrant = $_SESSION["pseudo"];







/******************
    MODIFICATION
********************/

$id = $_GET['id'];


$modif = $GLOBALS['bdd']->query("SELECT * from membre WHERE id_membre = $id");



$modif_membres = $modif->fetch(); // On lit les entrées une à une grâce à une boucle

$pseudoEntrant = $modif_membres["pseudo"];

$statut = $_POST['statut'];

if (isset($_POST["prenom"])) {
  $prenom = champValide($_POST["prenom"], 255);
  $nom = champValide($_POST["nom"], 20);
  $pseudoSortant = champValide($_POST["pseudo"], 20);
  $email = verifEmail($_POST["email"]);
  $passe = champValide($_POST["mdp"], 32);
  $passe2 = champValide($_POST["mdp2"], 32);
  $civilite = $_POST["civilite"];
  $statut = $_POST["statut"];
  $cp = champValide($_POST["cp"], 5, 1);
  $ville = champValide($_POST["ville"], 20);
  $adresse = champValide($_POST["adresse"], 50);
  $telephone = champValide($_POST["telephone"], 50);
  $statut = $_POST['statut'];
  $nombrePseudo = 0;
  if ($passe2 === $passe) {

  if ($pseudoEntrant != $pseudoSortant) {

		$verifPseudo = $GLOBALS["bdd"]->prepare("SELECT pseudo FROM membre WHERE pseudo = :pseudo");
		$verifPseudo->bindParam(':pseudo', $pseudoSortant);
		$verifPseudo->execute();

		$nombrePseudo = $verifPseudo->RowCount();
	}
	if ($nombrePseudo == 0) {

		if (empty($message)) {

			// Si OK, mettre à jour dans la base de données
			// Nous pourrions également utiliser exec sans requêtes préparées
			$result = $GLOBALS["bdd"]->prepare("UPDATE membre SET pseudo = :pseudo, mdp = :passe, nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, civilite = :civilite, ville = :ville, cp = :cp, adresse_membre = :adresse, statut = :statut WHERE id_membre = $id");

			$result->bindParam(':pseudo', $pseudoSortant);
			$result->bindParam(':passe', $passe);
			$result->bindParam(':nom', $nom);
			$result->bindParam(':prenom', $prenom);
			$result->bindParam(':email', $email);
      $result->bindParam(':telephone', $telephone);
			$result->bindParam(':civilite', $civilite);
			$result->bindParam(':ville', $ville);
			$result->bindParam(':cp', $cp);
      $result->bindParam(':statut', $statut);
			$result->bindParam(':adresse', $adresse);
			$result->execute();

			$nombre2 = $result->RowCount();

			if ($nombre2 == 1) {
				$_SESSION["pseudo"] = $pseudoSortant;
				$_SESSION["nom"] = $nom;
				$_SESSION["prenom"] = $prenom;
				$_SESSION["email"] = $email;
        $_SESSION["telephone"] = $telephone;
        $_SESSION["civilite"] = $civilite;
        $_SESSION["ville"] = $ville;
        $_SESSION["cp"] = $cp;
        $_SESSION["adresse"] = $adresse;
				header('Location: membre.php');
			} else {
				$message = '<div id="alert" class="alert alert-danger">
        <span class="">Erreur lors de la modification de votre profil</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
			}
			//Ferme le curseur, permettant à la requête d'être de nouveau exécutée
			$result->closeCursor();
		}
	} else {
		$message = '<div id="alert" class="alert alert-danger">
    <span class="">Pseudo existant</span>
    <button type="button" class="close" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button></div>';
	}
}
else {
  $message = '<div id="alert" class="alert alert-danger">
  <span class="">Veuillez saisir le meme mot de passe sur le champs de verification</span>
  <button type="button" class="close" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button></div>';
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


          <form class="taskOption" action="" method="post" required>
          <input type="text" placeholder="Votre pseudo" name="pseudo" value="<?=$modif_membres['pseudo']?>" class="modifMembre" required>
          <input type="password" placeholder="Nouveau mot de passe" name="mdp" value="<?=$modif_membres['mdp']?>" class=" modifMembre" required>
          <input type="password" placeholder="Ressaisissez votre mot de passe" name="mdp2" value="" class=" modifMembre" required>
          <input type="text" placeholder="Votre prénom" name="prenom" value="<?=$modif_membres['prenom']?>" class="modifMembre" required>
          <input type="text" placeholder="Votre nom" name="nom" value="<?=$modif_membres['nom']?>" class="modifMembre" required>
          <input type="text" placeholder="Votre adresse email" name="email" value="<?=$modif_membres['email']?>" class="modifMembre">
          <input type="text" name="telephone" placeholder="Votre téléphone" value="<?=$modif_membres['telephone']?>" class="modifMembre">
          <select name="civilite" class="modifMembre ">
          <option value="m"> Homme</option>
          <option value="f"> Femme</option>
          </select>
          <select name="statut" class="modifMembre ">
          <option value="">statut</option>
          <option value="1"> 0</option>
          <option value="1"> 1</option>
          </select>
          <input id="user_input_autocomplete_address" type="text" name="adresse" value="<?=$modif_membres['adresse']?>"placeholder="Saisissez votre adresse complete" class="modifMembre">
          <input id="postal_code" name="cp" placeholder="Votre code postal" value="<?=$modif_membres['cp']?>" class="modifMembre">
          <input type="text" id="locality" name="ville" placeholder="Votre ville" value="<?=$modif_membres['ville']?>" class="modifMembre">
          <input type="hidden" name="statut" value="<?=$modif_membres['statut']?>" class="modifMembre ">
          <input type="submit" name="inscription" value="modifier le Profil" class="modifMembre btn btn-primary ">
          </form>


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
