<?php

  session_start();
    include_once 'fonctions.php';
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
          include_once './inc/nav_nonconnecte.php';
        }
        ?>

    <main class="about">
      <div class="intro">
        <h1 class="col-md-1 offset-md-5 titre ">Annonceo</h1>
        <p>1ER SITE DE PETITES ANNONCES EN LIGNE, <br> AUTOUR DE NOMBREUSES CATÉGORIES <br> POUR LE PLAISIR DE TOUS ! </p>
      </div>
      <article  class="motCle">
      <div class="col-md-3 ">
      <h2><a href="index.php">vehicule</a></h2>
    </div>
      <div class="col-md-3 ">
        <h2><a href="index.php">multimédia</a></h2>
      </div>
      <div class="col-md-3">
        <h2><a href="index.php">immobilier</a></h2>
      </div>
    </article>
    <article  class="motCle1">
    <div class="col-md-3 ">
    <h2><a href="index.php">vêtements</a></h2>
  </div>
    <div class="col-md-3 ">
      <h2><a href="index.php">maison</a></h2>
    </div>
    <div class="col-md-3">
      <h2><a href="index.php">matériel</a></h2>
    </div>
  </article>
  <div class="content">
    <p>Annonceo, c’est une histoire de proximité. C’est comme un village : on se retrouve sur la place centrale pour conclure une vente entre voisins. On partage avec un inconnu un moment de connivence autour d’une passion commune. Cette proximité, on la cultive au quotidien chez Annonceo.</p>
    <p>Chez annonceo, nous mettons en relation toutes personnes souhaitant vendre ou se débarasser d'un bien quelconque, avec toutes individus recherchant un objet en particulier et souhaitant se le procurer.</p>
    <p>Les vendeurs présentent leur bien à vendre sur le site Annonceo et les éventuels acheteurs ont la possibilité de visualiser ce dernier et de prendre contact directement avec le vendeur en cas d'intérêt.</p>
    <p>Annonceo, c'est une véritable communauté qui vit ensemble et prône l'échange entre particuliers. En effet, chaque objet peut avoir une deuxième vie.</p>
    <p>Echange, convivialité, esprit d'équipe, notre stratégie repose sur des valeurs clés. Nous nous efforçons ainsi à toujours proposer à nos utlisateurs de nouvelles fonctionnalités innovantes pour rapprocher toujours plus les membres de notre communauté.</p>
  </div>
  <div class="border">
  </div>
    </main>
    <div class="footer_about">
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
    <script type="text/javascript" src="./js/script.js"></script>
  </body>
</html>
