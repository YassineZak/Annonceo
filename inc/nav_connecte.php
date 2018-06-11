<?php include_once './fonctions.php';

  $titre = '';
  $prix = '';
  $categorie = '';
  $description = '';
  $photo1 = '';
  $photo2 = '';
  $photo3 = '';
  $photo4 = '';
  $photo5 = '';
  $adresse = '';
  $cp = '';
  $ville = '';
  $latitude = '';
  $longitude = '';
  $rechercheForm1 = '';
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
      $to = 'yassine.zakari@hotmail.fr';
      $objetForm = stripslashes(trim($_POST['subject']));
      $messageForm = stripslashes(trim($_POST['messageForm']));
      $msg = 'message recu de : "<strong>' . $nomForm . '</strong>"<br/>';
      $msg .= 'mail de contact : "<strong> ' . $emailForm . '</strong>"<br/>';
      $msg .= 'numéro de contact : "<strong>' . $mobileForm . '</strong>"<br/>';
      $msg .= $messageForm . '<br/>';
      $encoding = "utf-8";
      $subject_preferences = array("input-charset" => $encoding,"output-charset" => $encoding,"line-length" => 76,"line-break-chars" => "\r\n");
      $header = "Content-type: text/html; charset=".$encoding." \r\n";
      $header .= "From: 'Annonceo.fr' <'noreply@annonceo.fr'> \r\n";
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


depotAnnonce()

?>
<div id="connexionOverlay">

</div>
<div id="contactForm">
  <form class="" action="" method="post">
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
        <input type="text" class="form-control" id="subject" name="subject" placeholder="Objet" required>
      </div>
      <div class="form-group">
        <textarea class="form-control" name="messageForm"  id="message" placeholder="Message" maxlength="140" rows="7"></textarea>
      </div>
      <div class="form-group">
      <button type="submit" id="submit" name="submit" class="btn btn-primary pull-right">Envoie Formulaire</button>
      </div>
</form>

</div>

<div id="depotAnnonce">
  <h5>Déposez votre annonce sur Annonceo</h5>
  <div class="annonceContainer">
  <div class="gaucheAnnonce">
  <form class="formAnnonce" action="" method="post" enctype="multipart/form-data">
  <label class="depotAnnonce">Titre</label>
  <input type="text" placeholder="Titre de l'annonce" name="titre" value="" class="form-control" required>
  <label class="depotAnnonce" >Prix</label>
  <div class="input-group">
      <input type="text" class="form-control" aria-label="Text input with radio button"placeholder="Prix" value="" name="prix" required>
      <span class="input-group-addon">€</span>
    </div>
  <label class="depotAnnonce">Catégorie</label>
  <select name="categorie" class="taskOption form-control" required>
  <option value="vehicule">Vehicule </option>
  <option value="immobilier">Immobilier </option>
  <option value="multimedia">Multimédia </option>
  <option value="materiel">Matériel </option>
  <option value="maison">Maison </option>
  <option value="vetements">Vetements </option>
  <option value="autres">Autres </option>
  <option value="" disabled>Toutes les catégories </option>
  </select>
  <label class="depotAnnonce">Description</label>
  <textarea class="form-control texteDescription" name="description" rows="3" cols="30" placeholder="Maximum 350 Caractéres"></textarea>
  </div>
  <div class="droiteAnnonce">
  <div class="image-upload">
  <label  for="file-input1"> <div>Photo1
  </div><img id="image1" src="./img/addpic.jpg" alt=""></label>
  <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
  <input id="file-input1" name="photo1" type="file"/>
  <label  for="file-input2"> <div>Photo2
  </div><img id="image2" src="./img/addpic.jpg" alt=""></label>
  <input id="file-input2" name="photo2" type="file"/>
  <label for="file-input3"> <div>Photo3
  </div><img  id="image3" src="./img/addpic.jpg" alt=""></label>
  <input id="file-input3" name="photo3" type="file"/>
  <label  for="file-input4"> <div>Photo4
  </div><img  id="image4" src="./img/addpic.jpg" alt=""></label>
  <input id="file-input4" name="photo4" type="file"/>
  <label  for="file-input5"> <div>Photo5
  </div><img id="image5" src="./img/addpic.jpg" alt=""></label>
  <input id="file-input5" name="photo5" type="file"/>
</div>
  <label class="depotAnnonce" for="">Adresse</label>
  <input id="user_input_autocomplete_address" name="adresse" placeholder="Saisissez votre adresse complete" class="taskOption form-control" required></input>
  <input type="hidden" id="latitude" name="latitude">
  <input type="hidden" id="longitude" name="longitude">
  <label class="depotAnnonce" for="">Code postal</label>
  <input id="postal_code" name="cp" placeholder="Votre code postal" class="taskOption form-control"></input>
  <label class="depotAnnonce">Ville</label>
  <input type="text" id="locality" name="ville" placeholder="Votre ville" value="" class="form-control">
</div>
</div>
<input type="submit" name="envoie" value="Poster votre annonce" class="btn btn-primary form-control" id="envoieAnnonce">
</form>

</div>
<header>

  <nav>
    <ul class="nav justify-content-center">
    <li class="nav-item ">
      <a class="nav-link active" href="./index.php">Annonceo</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="about.php">Qui Sommes Nous ?</a>
    </li>
    <li class="nav-item">
      <a class="nav-link deposer-annonce" href="#">Déposez Votre Annonce</a>
    </li>
    <div class="col-lg-5">
      <div class="input-group">
        <form class="input-group"  action="index.php" method="get">
        <input type="text" onchange="submit()" value="<?=$rechercheForm1?>" class="form-control" placeholder="Recherchez..." id="recherche" name="rechercheForm" aria-label="Search for...">
        <span class="input-group-btn">
    <button class="btn btn-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </span>
</div>
</div>
    <li class="nav-item">
      <a id="contact" class="nav-link" href="#">Contact</a>
    </li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i> <?php echo $_SESSION['pseudo'] ?></a>
<div class="dropdown-menu">
  <a class="dropdown-item membre" href="profil.php">votre profil</a>
  <a class="dropdown-item inscription" href="deconnexion.php">Deconnexion</a>
</li>
</ul>
</nav>
</header>
