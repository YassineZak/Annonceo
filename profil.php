<?php

// Initialise la session
session_start();
if (!(isset($_SESSION["pseudo"]) || !empty($_SESSION["pseudo"]))) {
	header("Location: index.php");
	exit;
}


// Connexion BDD et fonctions
include_once "fonctions.php";

$message = "";
$pseudoEntrant = $_SESSION["pseudo"];
// vérifier si use a essayé de supprimer son compte
if (isset($_GET["suppression"]) && $_GET["suppression"] == 0) {
	$message = '<div id="alert" class="alert alert-danger">
  <span class="">Erreur lors de la modification de votre profil</span>
  <button type="button" class="close" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button></div>';
}
$id_membre = $_SESSION['id_membre'];
$pseudo = $_SESSION["pseudo"];
$nom = $_SESSION["nom"];
$prenom = $_SESSION["prenom"];
$email = $_SESSION["email"];
$civilite = $_SESSION["civilite"];
$telephone = $_SESSION["telephone"];
$adresse = $_SESSION["adresse"];
$cp = $_SESSION["cp"];
$ville = $_SESSION["ville"];

$result = $bdd->query("SELECT note, moyenne_note FROM note WHERE id_membre = $id_membre ORDER BY id_note DESC");
$nombre = $result->RowCount();
$donnees = $result->fetch();
$moyenneNote =$donnees['moyenne_note'];
$result->closeCursor();
etoileNote($moyenneNote);
///////////////////////////////////////////////
if (isset($_POST["prenom"])) {
  $prenom = champValide($_POST["prenom"], 255);
  $nom = champValide($_POST["nom"], 20);
  $pseudoSortant = champValide($_POST["pseudo"], 20);
  $email = verifEmail($_POST["email"]);
  $passe = champValide($_POST["mdp"], 32);
  $passe2 = champValide($_POST["mdp2"], 32);
  $civilite = $_POST["civilite"];
  $cp = champValide($_POST["cp"], 5, 1);
  $ville = champValide($_POST["ville"], 20);
  $adresse = champValide($_POST["adresse"], 50);
  $telephone = champValide($_POST["telephone"], 50);
  $nombrePseudo = 0;
  if ($passe2 === $passe) {
    # code...

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
			$result = $GLOBALS["bdd"]->prepare("UPDATE membre SET pseudo = :pseudo, mdp = :passe, nom = :nom, prenom = :prenom, email = :email, telephone = :telephone, civilite = :civilite, ville = :ville, cp = :cp, adresse_membre = :adresse WHERE id_membre = $id_membre");

			$result->bindParam(':pseudo', $pseudoSortant);
			$result->bindParam(':passe', $passe);
			$result->bindParam(':nom', $nom);
			$result->bindParam(':prenom', $prenom);
			$result->bindParam(':email', $email);
      $result->bindParam(':telephone', $telephone);
			$result->bindParam(':civilite', $civilite);
			$result->bindParam(':ville', $ville);
			$result->bindParam(':cp', $cp);
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
				$message = '<div id="alert" class="alert alert-success">
        <span class="">Modification effectuée !</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
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
//////////////////// recuperer les annonces du membre ///////////////
$recupAnnonce = $GLOBALS["bdd"]->query("SELECT * FROM annonces LEFT JOIN photo
  ON photo.id_annonce = annonces.id_annonce  WHERE annonces.id_membre = $id_membre");
	$recupAnnonce1 = $GLOBALS["bdd"]->query("SELECT * FROM annonces LEFT JOIN photo
	  ON photo.id_annonce = annonces.id_annonce  WHERE annonces.id_membre = $id_membre");
	$recupMembreCom = $GLOBALS["bdd"]->query("SELECT * FROM commentaire LEFT JOIN membre ON membre.id_membre = commentaire.id_membre LEFT JOIN annonces ON commentaire.id_annonce = annonces.id_annonce  WHERE annonces.id_membre = $id_membre");

?>
<!doctype html>
<html lang="fr">
  <head>
    <title>Annonceo</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css">
		<link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">

  </head>
<body>

	<?php


	 if ((isset($_SESSION['pseudo'])) && !empty($_SESSION['pseudo'])) {
		if ($_SESSION['statut'] == 1) {
			include_once './inc/nav_admin.php';
		}
		else {
			include_once './inc/nav_connecte.php';
		}
	}
	else {
		header("Location: index.php");
    exit;
	} ?>
  <p>
		<?=$message?>
	</p>

	<h1 id="titreProfil">Bienvenue <?=$pseudo?></h1>
  <table id="tableProfil" class="table table-bordered table-inverse">
  <thead>
    <tr>
      <th>#</th>
      <th colspan="2">informations</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Pseudo</th>
      <td><?=$pseudo ?></td>
    </tr>
    <tr>
      <th scope="row">Moyenne note sur le site</th>
      <td><?=$GLOBALS['etoile'] ?> basé sur le vote de <?=$nombre?> membres.</td>
    </tr>
    <tr>
      <th scope="row">Nom</th>
      <td><?=$nom ?></td>
    </tr>
    <tr>
      <th scope="row">Prénom</th>
      <td><?=$prenom ?></td>
    </tr>
    <tr>
      <th scope="row">Email</th>
      <td ><?=$email ?></td>
    </tr>
    <tr>
      <th scope="row">Téléphone</th>
      <td >0<?=$telephone ?></td>
    </tr>
    <tr>
      <th scope="row">Adresse</th>
      <td ><?=$_SESSION["adresse"] ?></td>
    </tr>
    <tr>
      <th scope="row">Ville</th>
      <td ><?=$_SESSION["ville"] ?></td>
    </tr>
    <tr>
      <th scope="row">Code Postal</th>
      <td ><?=$_SESSION["cp"] ?></td>
    </tr>
		<tr>
		<th scope="row">Date création du compte</th>
		<td ><?=substr($_SESSION["date_enregistrement_membre"],0, -9 );?></td>
		</tr>
  </tbody>
</table>

<div id="connexionOverlay">

</div>
<div class="modif_profil">
  <span id="modif"><a href="#">Modifier mon profil</a></span>
  <span><a href="suppression_compte.php" class="delete" data-type="post">Supprimer mon compte</a></span>

</div>
<div class="vosAnnonces">
    <h3>Historique de vos annonces</h3>
    <table id="tableannonce" class="table table-bordered table-inverse">
    <thead>
      <tr>
        <th>Titre de vos annonces</th>
        <th >Date de depot</th>
        <th >Action</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php

        while ($donneesAnnonces = $recupAnnonce->fetch()) {
          echo '<th scope="row">' . $donneesAnnonces['titre'] . '</th>
          <td>' . $donneesAnnonces['date_enregistrement'] . '</td>
          <td><a href="page_annonce.php?id=' . $donneesAnnonces['id_annonce'] . '"><i class="fa fa-search" aria-hidden="true"></i> </a> <a class="delete" href="delete_annonce.php?id=' . $donneesAnnonces['id_annonce'] . '"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
        </tr>
        <tr>';
        }

         ?>

    </tbody>
  </table>
</div>
<div class="commentaireMembre">
	<h3>Les commentaire de vos annonces</h3>
	<table id="" class="table table-bordered table-inverse">
	<thead>
		<tr>
			<th>Titre de l'annonce</th>
			<th >commentaire</th>
			<th >membre</th>
			<th >Date du commentaire</th>
		</tr>
	</thead>
	<tbody>
		<tr>
		<?php
		while ($donneesCommentaires = $recupMembreCom->fetch()) {
			echo '<th scope="row">' . $donneesCommentaires['titre'] . '</th>
			<td>' . $donneesCommentaires['commentaire'] . '</td>
			<td>' . $donneesCommentaires['pseudo'] . '</td>
			<td>' . $donneesCommentaires['date_enregistrement_com'] . '</td>
			</tr>';
		}
		 ?>
	</tbody>
</table>
</div>

  <div id="modificationProfil">
    <h3>Modification profil</h3>
  <form class="" action="" method="post" required>
  <input type="text" placeholder="Votre pseudo" name="pseudo" value="<?=$pseudo?>" class="form-control" required>
  <input type="password" placeholder="Nouveau mot de passe" name="mdp" value="" class="form-control" required>
  <input type="password" placeholder="Ressaisissez votre mot de passe" name="mdp2" value="" class="form-control" required>
  <input type="text" placeholder="Votre prénom" name="prenom" value="<?=$prenom?>" class="form-control" required>
  <input type="text" placeholder="Votre nom" name="nom" value="<?=$nom?>" class="form-control" required>
  <?php verifEmail($email); ?>
  <input type="text" placeholder="Votre adresse email" name="email" value="<?=$email?>" class="form-control">
  <input type="text" name="telephone" placeholder="Votre téléphone" value="<?=$telephone?>" class="form-control">
  <select name="civilite" class="form-control">
  <option value="m"> Homme</option>
  <option value="f"> Femme</option>
  </select>
  <input id="user_input_autocomplete_address1" type="text" name="adresse" value="<?=$adresse?>"placeholder="Saisissez votre adresse complete" class="form-control">
  <input id="postal_code1" name="cp" placeholder="Votre code postal" value="<?=$cp?>" class="taskOption form-control">
  <input type="text" id="locality1" name="ville" placeholder="Votre ville" value="<?=$ville?>" class="form-control">
  <input type="hidden" name="statut" value='0' class="form-control">
  <input type="submit" name="inscription" value="modifier votre Profil" class="btn btn-primary form-control">
  </form>
  </div>
	<div class="footer">
		<ul>
			<li><a href="#">Mentions légales</a></li>
			<li><a href="#">Conditions Générales de ventes</a></li>
			<li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i>
					ANNONCEO - 300 Boulevard de Vaugirard - 75015 Paris - FRANCE</a></li>
		</ul>
	</div>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type="text/javascript" src="./js/jquery-ias.min.js">
	</script>
	<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDL7hlhkmmtu3maLOHUIx90UWWpkwKS3tg"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	<script type="text/javascript" src="./js/bootstrap-confirm-delete.js"></script>
	<script type="text/javascript" src="./js/script.js"></script>
	<script type="text/javascript">
	$( document ).ready( function( )
	{
			$( '.delete' ).bootstrap_confirm_delete( );
	} );

	</script>
</body>
</html>
