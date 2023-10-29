<?php
require_once("include.php");

$var = "Hello Inscription";
$valide = (boolean) true;

if (!empty($_POST)) {
  extract($_POST);

  if (isset($_POST["inscription"])) {
    $pseudo = trim($pseudo);
    $email = trim($email);
    $confmail = trim($confmail);
    $password = trim($password);
    $confpassword = trim($confpassword);

    if (empty($pseudo)) {
      $valide = false;
      $err_pseudo = "Ce champ ne peut pas être vide";
    } else {
      $req = $DB->prepare("SELECT id FROM utilisateur
      WHERE pseudo = ? ");

      $req->execute(array($pseudo));

      $req = $req->fetch();

      if (isset($req["id"])) {
        $valide = false;
        $err_pseudo = "Ce pseudo est déjà pris";
      }
    }
    

    if (empty($email)) {
      $valide = false;
      $err_email = "Ce champ ne peut pas être vide";
    }elseif($email <> $confmail) {
      $valide = false;
      $err_email = "Le mail est different de la confirmation";
    } else {
      $req = $DB->prepare("SELECT id FROM utilisateur
      WHERE email = ? ");
      $req->execute(array($email));
      $req = $req->fetch();
      if (isset($req["id"])) {
        $valide = false;
        $err_email = "Ce mail est déjà pris";
      }
    }


    if (empty($password)) {
      $valide = false;
      $err_password= "Ce champ ne peut pas être vide";
    }elseif($password<> $confpassword) {
      $valide = false;
      $err_password= "Le mot de passe est different de la confirmation";
    }


    if ($valide) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $date_creation = date("Y-m-d H:i:s");
      $req =  $DB->prepare(" INSERT INTO utilisateur(pseudo, email, mdp, date_creation, date_connexion) VALUES ( ? , ? , ? , ? , ? )");
      $req->execute(array($pseudo, $email, $password, $date_creation, $date_creation));
      header("location:'connexion.php' ");
      exit;
      // echo "C'est bon";
    } else{
      echo "Pas Ok";
    }
}
}
?>





<!doctype html>
<html lang="fr">
  <head>
  <title>Inscription</title>
  <?php
      include_once("./_head/meta.php");
      include_once("./_head/link.php");
      include_once("./_head/script.php");
    ?>
  </head>
  <body>
    <?php
      require_once("_menu/menu.php");
    ?>
<div class="container">
  <div class="row">
    <div class="col-3"></div>
      <div class="col-6">
      <h1><?php echo $var ?></h1>
      <form action="" method="post">
      <div class="mb-3">
        <span class="text-danger"><?php if(isset($err_pseudo)){ echo '<div>'. $err_pseudo .'</div>';} ?></span>
        <label for="" class="form-label">Pseudo</label>
        <input class="form-control" type="text" name="pseudo" value="<?php if(isset($pseudo)) {echo $pseudo; } ?>" placeholder="Pseudo">
      </div>

      <div class="mb-3">
      <?php if(isset($err_email)){ echo '<div>'. $err_email .'</div>';} ?>
        <label for="" class="form-label">Email</label>
        <input class="form-control" type="email" name="email"value="<?php if(isset($email)) {echo $email; } ?>" placeholder="Email">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Confirmer le mail</label>
        <input class="form-control" type="email" name="confmail" value="<?php if(isset($confmail)) {echo $confmail; } ?>" placeholder="Confirmer le mail">
      </div>

      <div class="mb-3">
      <?php if(isset($err_password)){ echo '<div>'. $err_password .'</div>';} ?>
        <label for="" class="form-label">Mot de passe</label>
        <input class="form-control" type="password" name="password"value="<?php if(isset($password)) {echo $password; } ?>" placeholder="Mot de passe">
      </div>

      <div class="mb-3">
        <label for="" class="form-label">Confirmer le mot passe</label>
        <input class="form-control" type="password" name="confpassword" value="<?php if(isset($confpassword)) {echo $confpassword; } ?>" placeholder="Confirmation mot de passe">
      </div>

      <div class="mb-3">
      <button type="submit" name="inscription" class="btn btn-primary">Inscription</button>
      </div>
      </form>
      </div>
  </div>
</div>

    

  <?php
    require_once("./_footer/footer.php");
  ?>
</body>
</html>