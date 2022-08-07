<?php session_start();

// SI DÉJÀ CONNECTÉ RENVOIE VERS LE JEU

if (isset($_SESSION['pseudo'])) {
    echo "vous etes deja connecte, vous allez etre redirige vers le jeu.";
    header('Refresh: 2; url=Jeu.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8">
      <title>MemoryGame</title>
      <meta name="authors" content="Leo Menude, Remi Labbe" />
      <meta name="desc" content="Memory Game project for university" />
      <meta name="keywords" content="memory, game, MemoryGame, project" />
      <link rel="icon" href="../src/img/card_logo.png">
      <link rel="stylesheet" href="../style/form.css?<?php echo time();?>"/>
      <link rel="stylesheet" href="../style/global.css?<?php echo time();?>"/>
  </head>

  <!-- body -->

  <body class="bodyform">

    <!-- header -->

    <header>

      <!-- logo -->

      <a href="Index.php"><img src="../src/img/card_logo.png" alt="logo" id="headerimg"/></a>

      <!-- menu navigation -->

      <nav class="menu">
        <ul class="menu_list">
          <li class="top_menu"><a href="rules.php">Règles</a></li>
          <li class="top_menu"><a href="Jeu.php">Jouer</a></li>
          <li class="top_menu"><a href="leaderboard.php">Leaderboard</a></li>
          <li id="dropdown_menu" class="top_menu" style="float: right">
            <a id="dropbutton" >| | |</a>
            <div id="dropdown_content">
              <span>Deconnecté</span>
              <a href="../src/traitement/deconnexion.php">Connexion</a>
            </div>
          </li>
        </ul>
      </nav>

    </header>

      <!-- formulaire de connexion -->

      <div id="form">
      <form method="post" action="../src/traitement/connect.php" class="form">

          <p>Connexion</p>
          <hr>
          <div class="alert">
                  <?php

                  // message d'erreur en fonction du renvoie de GET (gérée dans ../src/traitement/connect.php)

                      if(isset($_GET['erreur'])) {
                          $k = $_GET['erreur'];
                          switch ($k) {
                              case 1:
                                  echo "Ce compte n'existe pas !";
                                  break;
                              case 2:
                                  echo "Votre mot de passe ne correspond pas à l'email saisie !";
                                  break;
                              default:
                                  echo "Erreur inconnue";
                                  break;
                          }
                      }

                   ?>
          </div><br/>
          <div class="row">
              <div class="legend">
                  <label for="identifiant">Email :</label>
              </div>
              <div class="input_zone">
                  <input type="text" name="identifiant" id="identifiant" placeholder="Votre E-mail" required autofocus><br /><br />
              </div>
          </div>

          <div class="row">
              <div class="legend">
                  <label for="password">Mot de passe :</label>
              </div>
              <div class="input_zone">
                  <input type="password" name="password" id="password" placeholder="Votre mot de passe" required><br /><br />
              </div>
          </div>

          <div class="row">
              <input type="submit" class="logbutton" value="Connexion">
          </div>

          <div class="go_insc">
              <p>Pas encore inscrit ? <a href="inscription.php">Incrits-toi !</a></p>
          </div>

      </form>
      </div>

      <!-- footer -->

      <footer>

        <div class="menu">
          <ul class="menu_list">
            <li id="copyrights" class="foot_menu">© 2020 Lemis Corp</li>
            <li class="foot_menu"><a href="https://www.facebook.com/lemiscorp/" target="_blank"><img class="social_img" src="../src/img/facebook_logo.png" alt="FB_logo"></a></li>
            <li class="foot_menu"><a href="https://twitter.com/CorpLemis" target="_blank"><img class="social_img" src="../src/img/twitter_logo.png" alt="TW_logo"></a></li>
          </ul>
        </div>
      </footer>

  </body>
</html>
