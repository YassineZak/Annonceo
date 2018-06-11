<?php
try
  {
    $bdd = new PDO('mysql:host=cl1-sql23.phpnet.org;dbname=shp77291', 'shp77291', 'SQteSQY6uSLL', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
  }
  catch (Exception $e)
  {
          die('Erreur : ' . $e->getMessage());
  }
///////////////////////////////////////////
function verifEmail($email)
{
	global $message;
	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$message .= '<p style="color: red;" >Email non valide*</p>';
	}

	return trim(strip_tags($email));
}
//       function afficher toutes les regions                 //
  function afficherregion(){
    try
      {
        $bdd = new PDO('mysql:host=cl1-sql23.phpnet.org;dbname=shp77291', 'shp77291', 'SQteSQY6uSLL', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      }
      catch (Exception $e)
      {
              die('Erreur : ' . $e->getMessage());
      }
$reponse = $bdd->query('SELECT DISTINCT regionName FROM regions');
while ($donnees = $reponse->fetch()){
  echo '<option class="tri" value="third">' . $donnees['regionName'] . '</option>';
  }
  $reponse->closeCursor();
}
//////////////////////////////////////////////////
function champValide($champ, $integrite, $numeric=null)
{
	global $message;
	$nombre = strlen($champ);
	if ($nombre > $integrite) {
		$message .= "Le champ " . $champ . " doit contenir moins de " . $integrite;
	}

	// cp
	if (!is_null($numeric) && !is_numeric($champ)) {
		$message .= '<p style="color: red;" > Format' . $champ . 'incorrect !</p>';
	}

	return trim(strip_tags($champ));
}
/////////////////////////////////////////////////////////////////

function inscription($post)
{
	// Récupérer les données
	$prenom = trim(strip_tags($post["prenom"]));
	$nom = trim(strip_tags($post["nom"]));
	$pseudo = trim(strip_tags($post["pseudo"]));
	$email = $post["email"];
	$passe = trim(strip_tags($post["mdp"]));
  $passe2 = trim(strip_tags($post["mdp2"]));
	$civilite = trim(strip_tags($post["civilite"]));
	$cp = trim(strip_tags($post["cp"]));
	$ville = trim(strip_tags($post["ville"]));
	$adresse = trim(strip_tags($post["adresse"]));
  $telephone = trim(strip_tags($post["telephone"]));
  $id_membre = '';


	// Vérifier les données
	if (in_array("", $post)) {

		return '<p style="color: red;" >Informations Manquantes !*</p>';

	} else {

		// Si OK, insérer dans la base de données
		// Nous pourrions également utiliser exec sans requêtes préparées
		$result = $GLOBALS["bdd"]->prepare("INSERT INTO membre (pseudo, mdp, nom, telephone, prenom, email, civilite, ville, cp, adresse_membre, statut) VALUES (:pseudo, :passe, :nom, :telephone, :prenom, :email, :civilite, :ville, :cp, :adresse, 0)");

		$result->bindParam(':pseudo', $pseudo);
		$result->bindParam(':passe', $passe);
		$result->bindParam(':nom', $nom);
		$result->bindParam(':prenom', $prenom);
		$result->bindParam(':email', $email);
		$result->bindParam(':civilite', $civilite);
		$result->bindParam(':ville', $ville);
    $result->bindParam(':telephone', $telephone);
		$result->bindParam(':cp', $cp);
		$result->bindParam(':adresse', $adresse);
		$result->execute();

		// Retourne un résultat (étape 3)
  		$nombre = $result->RowCount();
      $result->closeCursor();


		// Affiche message si non trouvé ou récupère message, session et redirection
		if ($nombre < 1) {

			return  '<p style="color: red;" >Erreur Lors de la Creation de votre compte*</p>';

		} else {
      $result = $GLOBALS["bdd"]->query("SELECT id_membre, date_enregistrement_membre FROM membre WHERE id_membre = LAST_INSERT_ID()");
      $donnees = $result->fetch();

			session_start();
			$_SESSION["pseudo"] = $pseudo;
			$_SESSION["nom"] = $nom;
			$_SESSION["prenom"] = $prenom;
			$_SESSION["email"] = $email;
      $_SESSION["ville"] = $ville;
      $_SESSION["cp"] = $cp;
      $_SESSION["statut"] = $statut;
      $_SESSION["civilite"] = $civilite;
      $_SESSION["telephone"] = $telephone;
      $_SESSION["adresse"] = $adresse;
      $_SESSION['id_membre'] = $donnees['id_membre'];
      $_SESSION['date_enregistrement_membre'] = $donnees['date_enregistrement_membre'];

			header("Location: index.php");
		}

		//Ferme le curseur, permettant à la requête d'être de nouveau exécutée

	}
}
///////////////////////////////////////////
function verifconnexion()
{
	if (isset($_SESSION["pseudo"]) || !empty($_SESSION["pseudo"])) {
      include_once './inc/nav_connecte.php';
	}
  else {
    header("Location: index.php");
    exit;
  }

}
function connexion()
{
  if ((isset($_POST['pseudo1']) && !empty($_POST['pseudo1'])) && (isset($_POST['mdp1']) && !empty($_POST['mdp1'])) ) {
  $pseudo = $_POST['pseudo1'];
  $mdp = $_POST['mdp1'];
  $req = $GLOBALS['bdd']->prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp");
  $req->bindParam(':pseudo', $pseudo);
  $req->bindParam(':mdp', $mdp);
  $req->execute();
  $donnees = $req->fetch();
  $resultat = $req->RowCount();
  $req->closeCursor();
  if ($resultat == 1 ) {
    session_start();
    $_SESSION['pseudo'] = $pseudo;
    $_SESSION['mdp'] = $mdp;
    $_SESSION['id_membre'] = $donnees['id_membre'];
    $_SESSION['civilite'] = $donnees['civilite'];
    $_SESSION['prenom'] = $donnees['prenom'];
    $_SESSION['nom'] = $donnees['nom'];
    $_SESSION['email'] = $donnees['email'];
    $_SESSION['telephone'] = $donnees['telephone'];
    $_SESSION['adresse'] = $donnees['adresse_membre'];
    $_SESSION['cp'] = $donnees['cp'];
    $_SESSION['ville'] = $donnees['ville'];
    $_SESSION['statut'] = $donnees['statut'];
    $_SESSION['date_enregistrement_membre'] = $donnees['date_enregistrement_membre'];

   header('Location: ./index.php');
  }
  else {
    echo '<div id="alert" class="alert alert-danger">
        <span class="">Pseudo ou Mot de passe incorrect</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
  }
}
}
///////////// depot annonce ////////////////////
function depotAnnonce(){

if (isset($_POST['titre']) && !empty($_POST['titre'])) {
  if(isset($_FILES['photo1']) && !empty($_FILES['photo1'])|| isset($_FILES['photo2']) || isset($_FILES['photo3'])|| isset($_FILES['photo4']) || isset($_FILES['photo5']))

	$dossier = './upload/';
	$taille_maxi = 2000000;
	$taillePhoto1 = filesize($_FILES['photo1']['tmp_name']);
  $taillePhoto2 = filesize($_FILES['photo2']['tmp_name']);
  $taillePhoto3 = filesize($_FILES['photo3']['tmp_name']);
  $taillePhoto4 = filesize($_FILES['photo4']['tmp_name']);
  $taillePhoto5 = filesize($_FILES['photo5']['tmp_name']);
	$extensions = array('.png', '.gif', '.jpg', '.jpeg');
	$extensionPhoto1 = strrchr($_FILES['photo1']['name'], '.');
  $extensionPhoto2 = strrchr($_FILES['photo2']['name'], '.');
  $extensionPhoto3 = strrchr($_FILES['photo3']['name'], '.');
  $extensionPhoto4 = strrchr($_FILES['photo4']['name'], '.');
  $extensionPhoto5 = strrchr($_FILES['photo5']['name'], '.');


	//Début des vérifications de sécurité...
	if(!(in_array($extensionPhoto1,$extensions) || in_array($extensionPhoto2,$extensions) || in_array($extensionPhoto3,$extensions) || in_array($extensionPhoto4,$extensions) || in_array($extensionPhoto5,$extensions))) //Si l'extension n'est pas dans le tableau
	{
		 $erreur = '<div id="alert" class="alert alert-danger">
        <span class="">Vous devez uploader un fichier de type png, gif, jpg, jpeg</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
	}
	if(($taillePhoto1>$taille_maxi) ||($taillePhoto2>$taille_maxi)||($taillePhoto3>$taille_maxi)||($taillePhoto4>$taille_maxi)||($taillePhoto5>$taille_maxi))
	{
		 $erreur = '<div id="alert" class="alert alert-danger">
        <span class="">Le fichier est trop volumineux.</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
	}
	if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
	{
     $extension_upload = strtolower(  substr(  strrchr($_FILES['photo1']['name'], '.')  ,1)  );
     $randomName1 = md5(uniqid(rand(), true));
     $randomName2 = md5(uniqid(rand(), true));
     $randomName3 = md5(uniqid(rand(), true));
     $randomName4 = md5(uniqid(rand(), true));
     $randomName5 = md5(uniqid(rand(), true));
		 if(move_uploaded_file($_FILES['photo1']['tmp_name'], $dossier . $randomName1 . '.' . $extension_upload)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
		 {
			   echo '<div id="alert" class="alert alert-success">
            <span class="">Votre annonce a été postée</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
        move_uploaded_file($_FILES['photo2']['tmp_name'], $dossier . $randomName2 . '.' . $extension_upload);
        move_uploaded_file($_FILES['photo3']['tmp_name'], $dossier . $randomName3 . '.' . $extension_upload);
        move_uploaded_file($_FILES['photo4']['tmp_name'], $dossier . $randomName4 . '.' . $extension_upload);
        move_uploaded_file($_FILES['photo5']['tmp_name'], $dossier . $randomName5 . '.' . $extension_upload);
        $titre = trim(strip_tags($_POST['titre']));
        $prix2 = trim(strip_tags($_POST['prix']));
        $prix1 = filter_var($prix2, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $prix = str_replace(".", "", $prix1);
        $categorie = trim(strip_tags($_POST['categorie']));
        $description1 = trim(strip_tags($_POST['description']));
        $description = raccourcirChaine($description1, 350);
        $photo1 = trim(strip_tags($dossier . $randomName1 . '.' . $extension_upload));
        $photo2 = trim(strip_tags($dossier . $randomName2 . '.' . $extension_upload));
        $photo3 = trim(strip_tags($dossier . $randomName3 . '.' . $extension_upload));
        $photo4 = trim(strip_tags($dossier . $randomName4 . '.' . $extension_upload));
        $photo5 = trim(strip_tags($dossier . $randomName5 . '.' . $extension_upload));
        $adresse = trim(strip_tags($_POST['adresse']));
        $cp = trim(strip_tags($_POST['cp']));
        $ville = trim(strip_tags($_POST['ville']));
        $id_membre = $_SESSION['id_membre'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $result = $GLOBALS["bdd"]->prepare('INSERT INTO annonces (titre, description, prix, ville, adresse, cp, latitude, longitude, id_membre) VALUES (:titre, :description, :prix, :ville, :adresse, :cp, :latitude, :longitude, :id_membre)');
        $result->bindParam(':titre', $titre);
        $result->bindParam(':description', $description);
        $result->bindParam(':prix', $prix);
        $result->bindParam(':ville', $ville);
        $result->bindParam(':adresse', $adresse);
        $result->bindParam(':cp', $cp);
        $result->bindParam(':latitude', $latitude);
        $result->bindParam(':longitude', $longitude);
        $result->bindParam(':id_membre', $id_membre);
        $result->execute();
        $nombre = $result->RowCount();
        $result->closeCursor();
        $result1 = $GLOBALS["bdd"]->query('SELECT id_annonce FROM annonces WHERE id_annonce=LAST_INSERT_ID()');
        $donnees1 = $result1->fetch();
        if (isset($_FILES['photo1']) && !empty($_FILES['photo1'])) {
          $result2 = $GLOBALS["bdd"]->prepare('INSERT INTO photo (photo1, photo2, photo3, photo4, photo5, id_annonce, id_membre) VALUES (:photo1, :photo2, :photo3, :photo4, :photo5, :id_annonce, :id_membre)');
          $result2->bindParam(':photo1', $photo1);
          $result2->bindParam(':photo2', $photo2);
          $result2->bindParam(':photo3', $photo3);
          $result2->bindParam(':photo4', $photo4);
          $result2->bindParam(':photo5', $photo5);
          $result2->bindParam(':id_annonce', $donnees1['id_annonce']);
          $result2->bindParam(':id_membre', $id_membre);
          $result2->execute();
        }
        $nombre2 = $result2->RowCount();
        $result3 = $GLOBALS["bdd"]->prepare('INSERT INTO categorie (titre_categorie, id_annonce) VALUES (:categorie, :id_annonce)');
        $result3->bindParam(':categorie', $categorie);
        $result3->bindParam(':id_annonce', $donnees1['id_annonce']);
        $result3->execute();
        $nombre3 = $result3->RowCount();
		 }
		 else //Sinon (la fonction renvoie FALSE).
		 {
       echo '<div id="alert" class="alert alert-danger">
           <span class="">Votre annonce n\'a pas pu être postée.</span>
           <button type="button" class="close" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button></div>';
		 }
	}
	else
	{
		 echo $erreur;
	}
}
}
function raccourcirChaine($chaine, $tailleMax)
  {
    // Variable locale
    $positionDernierEspace = 0;
    if( strlen($chaine) >= $tailleMax )
    {
      $chaine = substr($chaine,0,$tailleMax);
      $positionDernierEspace = strrpos($chaine,' ');
      $chaine = substr($chaine,0,$positionDernierEspace).'...';
    }
    return $chaine;
  }
//////////////////////// fonction etoile basé sur note ////////////////////////
function etoileNote($moyenneNote){
  if ($moyenneNote == 0) {
    $userAvg = '<i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
  }
  elseif ($moyenneNote == 1) {
    $userAvg = ' <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>';
  }
  elseif ($moyenneNote== 2) {
    $userAvg = ' <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
';
  }
  elseif ($moyenneNote== 3) {
    $userAvg = ' <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
';
  }
  elseif ($moyenneNote == 4) {
    $userAvg = ' <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star-o" aria-hidden="true"></i>
';
  }
  elseif ($moyenneNote == 5 ) {
    $userAvg = ' <i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i>';
  }
  $GLOBALS['etoile'] = $userAvg;

}








///// afficher que les 3 premieres div et cacher les autres ///////
