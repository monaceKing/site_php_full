<?php
require_once("include.php");
$var = "Hello Connexion";
?>
<!doctype html>
<html lang="fr">
  <head>
  <title>Connexion</title>
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
    <h1><?php echo $var ?></h1>




  <?php
    require_once("./_footer/footer.php");
  ?>
</body>
</html>