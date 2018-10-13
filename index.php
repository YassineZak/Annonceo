<?php

  session_start();
    include_once 'fonctions.php';
    $email = '';
    $message = '';
    $pseudo = '';
    $prenom = '';
    $nom = '';
    $telephone = '';
    $cp = '';
    $ville = '';
    $mdp = '';
    $mdp2 = '';
    $selecVille1 = '';
    $selecMembre1 = '';
    $selecPrice1 = '';
    connexion();
    if (isset($_POST['pseudo']) && !empty($_POST['pseudo'])) {
      $req = $bdd->prepare('SELECT count(id_membre) AS nbre_occurences FROM membre WHERE pseudo = :pseudo');
      $req->execute(array('pseudo' => $_POST['pseudo']));
      $donnees = $req->fetch();
      $nbre_occurences = $donnees['nbre_occurences'];
      $req->closeCursor();
      if ($nbre_occurences != 0) {
        echo ' <div id="alert" class="alert alert-danger">
            <span class="">Pseudo déja enregistré veuillez en sélectionner un autre</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
      elseif ($_POST['mdp'] != $_POST['mdp2'] ) {
        echo ' <div id="alert" class="alert alert-danger">
            <span class="">Le mot de passe doit être identique.</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
      elseif (strlen($_POST['pseudo'])> 30 || strlen($_POST['pseudo'])< 6 ) {
        echo ' <div id="alert" class="alert alert-danger">
            <span class="">Le pseudo doit contenir entre 8 et 30 Caractéres</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
      elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        echo '<div id="alert" class="alert alert-danger">
            <span class="">Format Email invalide</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
      elseif (strlen($_POST['nom'])> 30 || strlen($_POST['nom'])< 4 ) {
        echo ' <div id="alert" class="alert alert-danger">
            <span class="">Le Nom doit contenir entre 4 et 30 Caractéres</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
      elseif (strlen($_POST['prenom'])> 30 || strlen($_POST['prenom'])< 4 ) {
        echo ' <div id="alert" class="alert alert-danger">
            <span class="">Le prenom doit contenir entre 4 et 30 Caractéres</span>
            <button type="button" class="close" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button></div>';
      }
        else {
          $email = $_POST['email'];
          $message .= inscription($_POST);
            }
          }


/////////////////////////////////////////////////////////////////

 ?>
<!doctype html>
<html lang="fr">
  <head>
    <title>Annonceo</title>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-112435852-1"></script>
    <link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">

  </head>
  <body onload=alert('Hacked_By_An0n_J#')>
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
          include_once './inc/nav_nonconnecte.php';
        }
        ?>
        <?php
        $rechercheForm = '';
        $selecCat = '';
        $selecMembre = '';
        $selecVille = '';
        $selecPrice = '';
        $selection = ' ORDER BY annonces.date_enregistrement DESC';
        if ((!empty($_GET['rechercheForm'])) && (isset($_GET['rechercheForm']))) {
          $rechercheForm1 = $_GET['rechercheForm'];
          $rechercheForm = " AND annonces.titre LIKE '%$rechercheForm1%'";
          if (empty($_POST['selecCat'])){
          $rechercheForm1 = $_GET['rechercheForm'];
          $rechercheForm = " WHERE annonces.titre LIKE '%$rechercheForm1%'";
          }
        }
        if ((!empty($_POST['select'])) && (isset($_POST['select'])))
        {
          $selection = $_POST['select'];
        }
        if ((!empty($_POST['selecCat'])) && (isset($_POST['selecCat'])))
        {
          $selecCat = $_POST['selecCat'];

        }
        if ((!empty($_POST['selecVille'])) && (isset($_POST['selecVille'])))
        {
          $selecVille1 = ucfirst(strtolower($_POST['selecVille']));
          $selecVille = " AND annonces.ville = '$selecVille1'";
          if (empty($_POST['selecCat']) && empty($_GET['rechercheForm'])) {
            $selecVille1 = ucfirst(strtolower($_POST['selecVille']));
            $selecVille = " WHERE annonces.ville = '$selecVille1'";
          }
        }

        if ((!empty($_POST['selecMembre'])) && (isset($_POST['selecMembre']))) {
          $selecMembre1 = $_POST['selecMembre'];
          $selecMembre = " AND membre.pseudo = '$selecMembre1'";

          if (empty($_POST['selecVille']) && empty($_POST['selecCat']) && empty($_GET['rechercheForm'])) {
            $selecMembre1 = $_POST['selecMembre'];
            $selecMembre = " WHERE membre.pseudo = '$selecMembre1'";
          }

        }
        if ((!empty($_POST['selecPrice'])) && isset($_POST['selecPrice']))
        {
          $selecPrice1 = $_POST['selecPrice'];
          $selecPrice = " AND annonces.prix <= $selecPrice1";
          if (empty($_POST['selecVille']) && empty($_POST['selecCat']) && empty($_POST['selecMembre']) && empty($_GET['rechercheForm'])) {
            $selecPrice1 = $_POST['selecPrice'];
            $selecPrice = " WHERE annonces.prix <= $selecPrice1";
          }
        }
        $reponse = $bdd->prepare("SELECT *
          FROM annonces
          LEFT JOIN photo
          ON photo.id_annonce = annonces.id_annonce
          LEFT JOIN membre
          ON membre.id_membre = annonces.id_membre
          LEFT JOIN categorie
          ON categorie.id_annonce = annonces.id_annonce
          $selecCat
          $rechercheForm
          $selecVille
          $selecMembre
          $selecPrice
          $selection
          ");
          $reponse->execute();


          //$reponse ->BindParam(':selection', $selection);
          /*$requete->execute(array('rechercheForm' => '%'.$rechercheForm1.'%'));*/
          ?>
    <main>
      <h1 class="col-md-1 offset-md-6 titre ">Annonceo</h1>
      <div class="conteneur-annonce">
        <form class="formAnnonce" action="index.php" method="post">
        <select id='select' name='select' class='taskOption1' onchange="submit()">
        <option value="">Seléctionnez votre option de tri</option>
        <option for="select" value=" ORDER BY prix DESC"<?php if($selection == " ORDER BY prix DESC"){echo "selected";}?>>Trier par prix (Du plus cher au moins cher)</option>
        <option for="select" value=" ORDER BY prix ASC"<?php if($selection == " ORDER BY prix ASC"){echo "selected";}?>>Trier par prix (Du moins cher au plus cher)</option>
        <option value=" ORDER BY annonces.date_enregistrement ASC"<?php if($selection == " ORDER BY annonces.date_enregistrement ASC"){echo "selected";}?>>Trier par date (De la plus ancienne à la plus récente)</option>
        <option value=" ORDER BY annonces.date_enregistrement DESC"<?php if($selection == " ORDER BY annonces.date_enregistrement DESC"){echo "selected";}?>>Trier par date (De la plus récente à la plus ancienne)</option>
      </select>
        <div id="annonceShow" class="annonceShow">
          <?php
        $i = 1;

          while ($donnees = $reponse->fetch()){
            $id_membre = $donnees['id_membre'];
            $reponse1 = $bdd->query("SELECT * FROM note WHERE id_membre = $id_membre ORDER BY id_note DESC");
            $donnees1 = $reponse1->fetch();
            $reponse1->closeCursor();
            $moyenneNote =$donnees1['moyenne_note'];
            etoileNote($moyenneNote);
            $class = ($i < 5) ? "open" : "hide";
            echo '
            <div class="' . $class . '">
            <hr>
            <a href="page_annonce.php?id=' . $donnees['id_annonce'] . '">
            <div id="conteneurAnonnce" class="conteneurAnonnce">
            <div class="conteneurImg">
            <img class="annonceImg" src="' . $donnees['photo1'] . '" alt="annonce acceuil">
            </div>
            <a href="page_annonce.php?id=' . $donnees['id_annonce'] . '" >
            <div class="annoncedescription">
              <span class="annonceTitre">' . $donnees['titre'] . '</span>
              <p>' . raccourcirChaine($donnees['description'], 150) . '</p>
              <div class="pseudoPrix"><span class="annonceUser"> '. $donnees['pseudo'] . ' ' . $GLOBALS['etoile'] . '
              </span><span class="prix">' . $donnees['prix'] .'€ </span></div>
            </div>
            </a>
            </div></a></div>';
            $i++;
          }
            ?>
               <div class="plus" id="plus">
                 <a class="btn btn-secondary" href="index.php#plus">voir plus <i class="fa fa-caret-down" aria-hidden="true"></i></a>
               </div>
            </div>
      </div>

      <div class=" conteneur-recherche col-md-2 offset-md-1">
      <label class="categorie">Catégorie</label>
      <select onchange="submit()" class="taskOption" name="selecCat" value=''>
      <option value="">Toutes les catégories </option>
      <option value="WHERE titre_categorie = 'vehicule' " <?php if($selecCat == "WHERE titre_categorie = 'vehicule' "){echo "selected";}?>>Vehicule </option>
      <option value="WHERE titre_categorie = 'immobilier' "<?php if($selecCat == "WHERE titre_categorie = 'immobilier' "){echo "selected";}?>>Immobilier </option>
      <option value="WHERE titre_categorie = 'multimedia' "<?php if($selecCat == "WHERE titre_categorie = 'multimedia' "){echo "selected";}?>>Multimédia </option>
      <option value="WHERE titre_categorie = 'materiel' "<?php if($selecCat == "WHERE titre_categorie = 'materiel' "){echo "selected";}?>>Matériel </option>
      <option value="WHERE titre_categorie = 'maison' "<?php if($selecCat == "WHERE titre_categorie = 'maison"){echo "selected";}?>>Maison </option>
      <option value="WHERE titre_categorie = 'vetements' "<?php if($selecCat == "WHERE titre_categorie = 'vetements' "){echo "selected";}?>>Vetements </option>
      <option value="WHERE titre_categorie = 'autres' " <?php if($selecCat == "WHERE titre_categorie = 'autres' "){echo "selected";}?>>Autres </option>
      </select>
      <label class="categorie">Ville</label>
      <input type="text" placeholder="Votre Ville" name="selecVille" value="<?=$selecVille1?>"class="taskOption">
      <label class="categorie">Membres</label>
      <input type="text" placeholder="Nom du membre" name="selecMembre" value="<?=$selecMembre1?>" class="taskOption">
      <label class="categorie">Prix <span id="demo"></span> €</label>
      <input onchange="submit()" type="range" min="1" max="50000" value="<?=$selecPrice1?>" class="taskOption" id="myRange" name="selecPrice">
      <input type="submit" name="Affiner votre recherche" value="Affiner votre recherche" id="affiner" class= "taskOption btn btn-primary" >
      </div>
      </form>
    </main>
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
    <script type="text/javascript" src="./js/jquery-ias.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDL7hlhkmmtu3maLOHUIx90UWWpkwKS3tg"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script type="text/javascript" src="./js/script.js"></script>
    <script type="text/javascript">
    var slider = document.getElementById("myRange");
    var output = document.getElementById("demo");
    output.innerHTML = slider.value;

    slider.oninput = function() {
      output.innerHTML = this.value;
    }
    </script>
  </body>
</html>
