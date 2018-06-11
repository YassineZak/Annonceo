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
$latitude = '';
$longitude = '';
$ville = '';
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


?>
<div id="connexionOverlay">

</div>
<div id="connexion">
  <h5>Se connecter</h5>
  <form action="" method="post">
    <input type="text" placeholder="Votre pseudo" value="" name="pseudo1" class="form-control">
    <input type="password" placeholder="Votre mot de passe" value="" name="mdp1" class="form-control">
    <input type="submit" name="connexion" value="Connexion" class="btn btn-primary form-control">
  </form>


</div>
<div id="inscription">
  <h5>Inscription</h5>
  <?=$message?>
  <form  action="" method="post" >
  <input type="text" placeholder="Votre pseudo" name="pseudo" value="<?=$pseudo?>" class="form-control" required>
  <input type="password" placeholder="Votre mot de passe" name="mdp" value="" class="form-control" required>
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
  <input id="user_input_autocomplete_address" type="text" name="adresse" placeholder="Saisissez votre adresse complete" class="form-control">
  <input id="postal_code" name="cp" placeholder="Votre code postal" value="<?=$cp?>" class="taskOption form-control">
  <input type="text" id="locality" name="ville" placeholder="Votre ville" value="<?=$ville?>" class="form-control">
  <input type="hidden" name="statut" value='0' class="form-control">
  <input type="submit" name="inscription" value="inscription" class="btn btn-primary form-control">

  </form>
</div>
<div id="contactForm">
  <form  action="" method="post">
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

<div id="depotAnnonceNonconnecte" class="alert alert-danger">

		 <span class="">Vous devez vous connecter pour poster une annonce.</span>
		 <button type="button" class="close" aria-label="Close">
		 <span aria-hidden="true">&times;</span>
	 </button>
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
    <li class="col-lg-5">
      <div class="input-group">

        <form class="input-group"  action="index.php" method="get">
        <input type="text" onchange="submit()" value="<?=$rechercheForm1?>" class="form-control" placeholder="Recherchez..." id="recherche" name="rechercheForm" aria-label="Search for...">
        <span class="input-group-btn">
    <button class="btn btn-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
    </form>
  </span>
</div>
</li>
    <li class="nav-item">
      <a id="contact"class="nav-link" href="#">Contact</a>
    </li>
<li class="nav-item dropdown">
<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Espace membre</a>
<div class="dropdown-menu">
  <a class="dropdown-item membre" href="#">Déja membre</a>
  <a class="dropdown-item inscription" href="#">Inscrivez vous</a>
</li>
</ul>
</nav>
</header>
