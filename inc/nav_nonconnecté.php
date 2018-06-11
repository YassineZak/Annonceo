<?php include_once './fonctions.php'; ?>
<div id="connexionOverlay">

</div>
<div id="connexion">
  <h5>Se connecter</h5>
  <input type="text" placeholder="Votre pseudo" value="" class="form-control">
  <input type="text" placeholder="Votre mot de passe" value="" class="form-control">
  <input type="submit" name="" value="Connexion" class="btn btn-primary form-control">
</div>
<div id="inscription">
  <h5>Inscription</h5>
  <?=$message?>
  <form class="" action="index.php" method="post" required>
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

<div id="depotAnnonce">
  <h5>Déposez votre annonce sur Annonceo</h5>
  <div class="annonceContainer">
  <div class="gauche">
  <form class="" action="index.php" method="post">
  <label class="depotAnnonce">Titre</label>
  <input type="text" placeholder="Titre de l'annonce" value="" class="form-control">
  <label class="depotAnnonce">Prix</label>
  <input type="text" placeholder="Prix" value="" class="form-control">
  <label class="depotAnnonce">Catégorie</label>
  <select class="taskOption form-control">
  <option class="tri" value="third">Emploi </option>
  <option value="third">Vehicule </option>
  <option value="third">Immobilier </option>
  <option value="third">Vacances </option>
  <option value="third">Multimédia </option>
  <option value="third">Loisirs </option>
  <option value="third">Matériel </option>
  <option value="third">Services </option>
  <option value="third">Maison </option>
  <option value="third">Vetements </option>
  <option value="third">Autres </option>
  <option value="third">Toutes les catégories </option>
  </select>
  <label class="depotAnnonce">Description</label>
  <textarea class="form-control texteDescription" name="name" rows="3" cols="30"></textarea>
  </div>
  <div class="droite">
  <div class="image-upload">
  <label  for="file-input"> <div>Photo1
  </div><img src="./img/addpic.jpg" alt=""></label>
  <input id="file-input" type="file"/>
  <label  for="file-input"> <div>Photo2
  </div><img src="./img/addpic.jpg" alt=""></label>
  <input id="file-input" type="file"/>
  <label for="file-input"> <div>Photo3
  </div><img src="./img/addpic.jpg" alt=""></label>
  <input id="file-input" type="file"/>
  <label  for="file-input"> <div>Photo4
  </div><img src="./img/addpic.jpg" alt=""></label>
  <input id="file-input" type="file"/>
  <label  for="file-input"> <div>Photo5
  </div><img src="./img/addpic.jpg" alt=""></label>
  <input id="file-input" type="file"/>
</div>
  <label class="depotAnnonce" for="">Adresse</label>
  <input id="user_input_autocomplete_address" placeholder="Saisissez votre adresse complete" class="taskOption form-control"></input>
  <label class="depotAnnonce" for="">Code postal</label>
  <input id="postal_code" name="postal_code" placeholder="Votre code postal" class="taskOption form-control"></input>
  <label class="depotAnnonce">Ville</label>
  <input type="text" id="locality" name="locality" placeholder="Votre ville" value="" class="form-control">
</div>
</div>
<input type="submit" name="" value="Poster votre annonce" class="btn btn-primary form-control" id="envoieAnnonce">
</form>
</div>
<header>
  <nav>
    <ul class="nav justify-content-center">
    <li class="nav-item ">
      <a class="nav-link active">Annonceo</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Qui Sommes Nous ?</a>
    </li>
    <li class="nav-item">
      <a class="nav-link deposer-annonce" href="#">Déposez Votre Annonce</a>
    </li>
    <div class="col-lg-5">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Recherchez..." aria-label="Search for...">
        <span class="input-group-btn">
    <button class="btn btn-secondary" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>
  </span>
</div>
</div>
    <li class="nav-item">
      <a class="nav-link" href="#">Contact</a>
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
