<?php
$_SESSION['id_membre'] = '';
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
if(isset($_SESSION['id_membre']) && !empty($_SESSION['id_membre'])){
  $id_membre_deposant = $_SESSION['id_membre'];
}



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
  elseif (strlen($_POST['nom'])> 30 || strlen($_POST['nom'])< 6 ) {
    echo ' <div id="alert" class="alert alert-danger">
        <span class="">Le Nom doit contenir entre 8 et 30 Caractéres</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
  }
  elseif (strlen($_POST['prenom'])> 30 || strlen($_POST['prenom'])< 6 ) {
    echo ' <div id="alert" class="alert alert-danger">
        <span class="">Le prenom doit contenir entre 8 et 30 Caractéres</span>
        <button type="button" class="close" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button></div>';
  }
    else {
      $email = $_POST['email'];
      $message .= inscription($_POST);
        }
      }
      if (isset($_GET['id']) && !empty($_GET['id'])) {
         $id_annonce = intval($_GET['id']);
         if ($id_annonce > 0){
           $reponse = $bdd->prepare("SELECT *
                                     FROM annonces
                                     LEFT JOIN photo
                                     ON photo.id_annonce = annonces.id_annonce
                                     LEFT JOIN membre
                                     ON membre.id_membre = annonces.id_membre
                                     WHERE annonces.id_annonce = $id_annonce");
           //$reponse ->BindParam(':selection', $selection);
           $reponse->execute();

           $nombre = $reponse->RowCount();
           $donnees = $reponse->fetch();
           $reponse->closeCursor();
           $id_membre = $donnees['id_membre'];
           $reponse1 = $bdd->prepare("SELECT * FROM note WHERE id_membre = $id_membre ORDER BY id_note DESC");
           $reponse1->execute();
           $donnees1 = $reponse1->fetch();
           $reponse1->closeCursor();
           $Note = $donnees1['moyenne_note'];
           etoileNote($Note);
         }
        else {
          header('Location : index.php');
        }
      }
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
    <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans" rel="stylesheet">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./dist/slippry.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" href="./font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.12/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slippry/1.4.0/images/arrows.svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slippry/1.4.0/images/sy-loader.gif">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slippry/1.4.0/slippry.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slippry/1.4.0/slippry.min.css">
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
    <link rel="icon" href="./img/favicon.ico" type="image/x-icon">
  </head>
  <body>
    <header>
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
        </header>
        <main>
          <h1 class="titre">Annonceo</h1>
          <div class="titreContainer">

            <ul class="listModal">
              <li class="nav-item dropdown">
                <a href="#insurance-head-section" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">contacter <?=$donnees['pseudo']?></a>
                <div class="dropdown-menu">
                  <a href="#response" class="dropdown-item" data-toggle="modal" data-target="#response">Par téléphone</a>
                  <a href="#response1" class="dropdown-item" data-toggle="modal" data-target="#response1">Par email</a>
              </li>
            </ul>
            <div class="modal" id="response">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <div class="modal-body">
                    <div class="list-group">
                      <div class="d-flex w-100 justify-content-between">
                        <h6>+(33)<?=$donnees['telephone']?></h6>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button class="btn btn-primary" data-dismiss="modal">Fermer</button>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        <div class="modal" id="response1">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="list-group">
                  <div class="d-flex w-100 justify-content-between">
                    <div class="container">
                      <div>
                        <div class="form-area">
                          <form role="form" method="post">
                            <br style="clear:both">
                            <h3 style="margin-bottom: 25px; text-align: center;">Formulaire de Contact</h3>
    				                    <div class="form-group">
						                      <input type="text" class="form-control" id="name" name="nomForm" placeholder="Nom" required>
					                      </div>
					                      <div class="form-group">
						                      <input type="text" class="form-control" id="email" name="emailForm" placeholder="email" required>
					                      </div>
					                      <div class="form-group">
						                      <input type="text" class="form-control" id="mobile" name="mobileForm" placeholder="Numéro de contact" required>
					                      </div>
                                <div class="form-group">
                                  <input type="text" class="form-control" id="destinataire" name="destinataireForm" value="Destinataire : <?=$donnees['email']?>" disabled>
                                </div>
					                      <div class="form-group">
						                      <input type="text" class="form-control" id="subject" name="subject" placeholder="Objet" required>
					                      </div>
                                <div class="form-group">
                                  <textarea class="form-control" name="messageForm" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7"></textarea>
                                </div>
                                <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Envoie Formulaire</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
          </div>
          <?php
           if (isset($_POST['nomForm']) && !empty($_POST['nomForm'])) {
             if (empty($_POST['emailForm']) || empty($_POST['mobileForm']) || empty($_POST['subject']) || empty($_POST['subject'])){
               echo '<div id="alert" class="alert alert-danger">
                  <span class="">Tous les Champs du Formulaire de contact doivent être renseignés</span>
                  <button type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button></div>';
             }
             else {
               $nomForm = stripslashes(trim($_POST['nomForm']));
               $emailForm = stripslashes(trim($_POST['emailForm']));
               $mobileForm = stripslashes(trim($_POST['mobileForm']));
               $to = $donnees['email'];
               $objetForm = stripslashes(trim($_POST['subject']));
               $messageForm = stripslashes(trim($_POST['messageForm']));
               $msg = 'message recu de : "<strong>' . $nomForm . '</strong>"<br/>';
               $msg .= 'mail de contact : "<strong> ' . $emailForm . '</strong>"<br/>';
               $msg .= 'numéro de contact : "<strong>' . $mobileForm . '</strong>"<br/>';
               $msg .= $messageForm . '<br/>';
               $encoding = "utf-8";
               $subject_preferences = array("input-charset" => $encoding,"output-charset" => $encoding,"line-length" => 76,"line-break-chars" => "\r\n");
               $header = "Content-type: text/html; charset=".$encoding." \r\n";
               $header .= "From: \"Annonceo.fr\" <noreply@annonceo.fr> \r\n";
               $header .= "Reply-to: \"Annonceo.fr\"<noreply@annonceo.fr> \r\n";
               $header .= "MIME-Version: 1.0 \r\n";
               $header .= "Content-Transfer-Encoding: 8bit \r\n";
               $header .= "Date: ".date("r (T)")." \r\n";
               $header .= iconv_mime_encode("Subject", $mail_subject, $subject_preferences);
               if (mail($to, $objetForm, $msg, $header)) {
                 echo '<div id="alert" class="alert alert-success">
                    <span class="">Votre message a été transmis</span>
                    <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
               }
               else{
                 echo '<div id="alert" class="alert alert-danger">
                    <span class="">Votre message n\'a pas pu être transmis.</span>
                    <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button></div>';
               }
             }
           }
           ?>
          <div class="descriptionContainer">

          <div class="carouselContainer">
            <ul id="thumbnails">
 <li>
    <a href="#slide1">
      <img src="<?=$donnees['photo1']?>" alt="">
    </a>
  </li>
  <li>
    <a href="#slide2">
      <img src="<?=$donnees['photo2']?>"  alt="">
    </a>
  </li>
  <li>
    <a href="#slide3">
      <img src="<?=$donnees['photo3']?>" alt="">
    </a>
  </li>
  <li>
    <a href="#slide4">
      <img src="<?=$donnees['photo4']?>" alt="">
    </a>
  </li>
  <li>
    <a href="#slide5">
      <img src="<?=$donnees['photo5']?>" alt="">
    </a>
  </li>
</ul>
</div>
<div class="separation">
  <h2 class="titrePageAnnonce"><?php echo $donnees['titre']; ?></h2>


    <p><?=$donnees['description']?></p>
  <div class="thumb-box">
    <ul class="thumbs">
      <li><a href="#1" data-slide="1"><img src="<?=$donnees['photo1']?>" alt=""></a></li>
      <li><a href="#2" data-slide="2"><img src="<?=$donnees['photo2']?>"  alt=""></a></li>
      <li><a href="#3" data-slide="3"><img src="<?=$donnees['photo3']?>" alt=""></a></li>
      <li><a href="#4" data-slide="4"><img src="<?=$donnees['photo4']?>" alt=""></a></li>
      <li><a href="#5" data-slide="5"><img src="<?=$donnees['photo5']?>" alt=""></a></li>
    </ul>
  </div>
  </div>
  </div>

  <div class="coordonneesContainer">
    <ul class="coordonnees">
      <li><i class="fa fa-calendar-o" aria-hidden="true"></i> Date de publication <?=$donnees['date_enregistrement']?></li>
      <li><i class="fa fa-user" aria-hidden="true"></i> <?=$donnees['pseudo'] . ' ' .  $GLOBALS['etoile']?></li>
        <li><i class="fa fa-usd" aria-hidden="true"></i>
          Prix <?=$donnees['prix']?> €</li>
        <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?=$donnees['adresse']?></li>
    </ul>
  </div>
  <div class="mapContainer">
    <div id="map-wrapper">
	<ul id="places">
		<li data-coords="<?=$donnees['latitude']?>,<?=$donnees['longitude']?>" data-zoom="15">New York</li>
	</ul>
	<div id="map"></div>
</div>
</div>
<div class="depotcom">
  <ul class="listModal">
    <li class="nav-item dropdown">
      <a href="#insurance-head-section" class="dropdown-toggle" data-toggle="dropdown">Déposer un commentaire ou une note</a>
      <div class="dropdown-menu">
        <a href="#responsecom" class="dropdown-item" data-toggle="modal" data-target="#responsecom">Déposer un commentaire</a>
        <a href="#responsenote" class="dropdown-item" data-toggle="modal" data-target="#responsenote">Déposer une note</a>
    </li>
  </ul>
    <?php if ((!isset($_SESSION['pseudo'])) || (empty($_SESSION['pseudo']))) {
      echo '<div class="modal" id="responsecom">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                  <h6>Vous devez vous connecter pour déposer un commentaire.</h6>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
    </div>';
    }
    else {
      echo '<div class="modal" id="responsecom">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                  <form class="depotcommentaire" role="form" method="post">
                  <div class="form-group">
                    <textarea class="form-control" name="messageCom" type="textarea" id="message" placeholder="Message" maxlength="140" rows="7" required></textarea>
                  </div>
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Poster votre commentaire</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>';
    }
    if (isset($_POST['messageCom']) && !empty($_POST['messageCom'])) {
      $commentaire = trim(strip_tags($_POST['messageCom']));
      $id_membre = $_SESSION['id_membre'];
      $result = $bdd->prepare("INSERT INTO commentaire (commentaire, id_annonce, id_membre) VALUES (:commentaire, :id_annonce, :id_membre)");
      $result->bindParam(':commentaire', $commentaire);
  		$result->bindParam(':id_annonce', $id_annonce);
  		$result->bindParam(':id_membre', $id_membre);
      $result->execute();
      $nombre = $result->RowCount();
      $result->closeCursor();
      if ($nombre < 1 ) {
        echo '<div id="alert" class="alert alert-danger">
           <span class="">Impossible de poster votre commentaire.</span>
           <button type="button" class="close" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button></div>';
      }
      else {
        echo '<div id="alert" class="alert alert-success">
           <span class="">Votre commentaire a été posté.</span>
           <button type="button" class="close" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button></div>';
      }
    }

    ?>
    <?php  if ((!isset($_SESSION['pseudo'])) || (empty($_SESSION['pseudo']))) {
      echo '<div class="modal" id="responsenote">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                  <h6>Vous devez vous connecter pour déposer une note</h6>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
    </div>';
    }
    elseif ($id_membre == $id_membre_deposant) {
      echo '<div class="modal" id="responsenote">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title"></h5>
              <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                  <h6>Vous ne pouvez vous attribuer une note à vous même !</h6>
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Fermer</button>
              </div>
            </div>
          </div>
        </div>
    </div>';
    }
    else {
      echo '<div class="modal" id="responsenote">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="list-group">
                <div class="d-flex w-100 justify-content-between">
                  <form class="depotnote" role="form" method="post">
                  <label for="depotNote"> Saisissez une note de 1 à 5</label>
                  <div class="form-group">
                    <input class="form-control bfh-number" name="depotNote" type="number" min="1" max="5"  placeholder="Votre note" required></input>
                  </div>
                  <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Poster votre note au vendeur</button>
                  </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>';
    }
    if (isset($_POST['depotNote']) && !empty($_POST['depotNote'])) {
      $note = trim(strip_tags($_POST['depotNote']));
      $id_membre = $donnees['id_membre'];
      $result1 = $bdd->query("SELECT note, AVG(note) as moyenne FROM note WHERE id_membre = $id_membre");
      $nombre1 = $result1->RowCount();
      $sommeNote = $result1->fetch();
      $moyenne = round($sommeNote['moyenne']);
      $result1->closeCursor();
      $result3 = $bdd->query("INSERT INTO note (note, id_membre, id_membre_deposant, moyenne_note) VALUES ($note, $id_membre, $id_membre_deposant, $moyenne)");
      $nombre = $result3->RowCount();
      $result3->closeCursor();
      if ($nombre < 1 ) {
        echo '<div id="alert" class="alert alert-danger">
           <span class="">Impossible de poster note.</span>
           <button type="button" class="close" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button></div>';
      }
      else {
        echo '<div id="alert" class="alert alert-success">
           <span class="">Votre note a été pris en compte.</span>
           <button type="button" class="close" aria-label="Close">
           <span aria-hidden="true">&times;</span>
           </button></div>';
      }
    }
     ?>
     <a href="index.php" >Retour vers les annonces</a>
  </div>


</div>
    </li>
  </ul>
</div>
</div>
<div class="affichageCom">
  <?php
  $result5 = $bdd->query("SELECT *
                          FROM commentaire
                          LEFT JOIN membre
                          ON commentaire.id_membre = membre.id_membre
                          WHERE commentaire.id_annonce = $id_annonce
                          ORDER BY date_enregistrement_com
                          DESC");
  while ($donnees5 = $result5->fetch()) {
    echo $donnees5['date_enregistrement_com'] . '<br/>' . 'Déposé par : ' . $donnees5['pseudo'] . '<br/>' .
          $donnees5['commentaire'] . '<br/><hr/>';
  }

  ?>

</div>

  <div id="autreAnnonceTitre">Autres Annonces</div>
    <ul class="autreAnnonce">
      <?php
      $reponse1 = $bdd->query("SELECT titre_categorie FROM categorie WHERE id_annonce != $id_annonce");
      $donnees1 = $reponse1->fetch();
      $categorie = $donnees1['titre_categorie'];
      $reponse2 = $bdd->query("SELECT DISTINCT *
                                FROM photo
                                WHERE id_annonce != $id_annonce
                                ORDER BY RAND()
                                LIMIT 0,4");
      $nombre2 = $reponse2->RowCount();
      while ($donnees2 =$reponse2->fetch()){
        echo '<li><a href="page_annonce.php?id=' . $donnees2['id_annonce'] . '"><img src="' . $donnees2['photo1'] . '" alt="autre photo"></a></li>';
        }

        $reponse1->closeCursor();
       ?>
    </ul>



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
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  <script type="text/javascript" src="./js/jquery-ias.min.js">
  </script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=places&amp;key=AIzaSyDL7hlhkmmtu3maLOHUIx90UWWpkwKS3tg"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <script type="text/javascript" src="./js/script.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slippry/1.4.0/slippry.js"></script>
  <script type="text/javascript">
  var thumbs = jQuery('#thumbnails').slippry({
    // general elements & wrapper
    slippryWrapper: '<div class="slippry_box thumbnails" />',
    // options
    transition: 'horizontal',
    pager: false,
    auto: false,
    onSlideBefore: function (el, index_old, index_new) {
      jQuery('.thumbs a img').removeClass('active');
      jQuery('img', jQuery('.thumbs a')[index_new]).addClass('active');
    }
  });

  jQuery('.thumbs a').click(function () {
    thumbs.goToSlide($(this).data('slide'));
    return false;
  });
</script>
  </body>
  </html>
