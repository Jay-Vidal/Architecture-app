<!DOCTYPE html>
<html>
<body>
  <div class="container">
    <?php
      session_start();

      if (isset($_SESSION['login'])) {
        $login = $_SESSION['login'];
        echo "<p><b>Bienvenue " . $login . " !</b></p>";
      }
    ?>
    <a href="afficher_drones.php" class="button">Afficher les drones</a>
    <a href="ajouter_drones.php" class="button">Ajouter un drone</a>
    <a href="index.php" class="button_login">Déconnexion</a>
  </div>
</body>

</html>
