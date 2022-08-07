<?php
session_start();

//fonction d'affichage du contenu du dropdown_menu (en fonction de si un utilisateur connecté ou non)

function fill_drop(){
  if (isset($_SESSION['pseudo'])){
    echo "<span>{$_SESSION['pseudo']}</span>";
    echo '<a href="../src/traitement/deconnexion.php">Déconnexion</a>';
  } else {
    echo "<span>Deconnecté</span>";
    echo '<a href="Index.php">Connexion</a>';
  }
}

if (!isset($_SESSION['pseudo']) || !isset($_SESSION['id'])){
  echo "Vous n'etes pas connecte, vous allez etre redirige.";
  header('Refresh: 1; url=Index.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>MemoryGame</title>
      <meta name="authors" content="Leo Menude, Remi Labbe" />
      <meta name="desc" content="Memory Game project for University" />
      <meta name="keywords" content="memory, game, MemoryGame, project, projet" />
    <script src="../src/scripts/game.js"></script>
    <script src="../src/scripts/timer.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../style/global.css?<?php echo time();?>">
    <link rel="stylesheet" href="../style/game.css?<?php echo time();?>">
    <link rel="icon" href="../src/img/card_logo.png">
  </head>

  <!-- body -->

  <body>

      <!-- header -->

      <header>

        <!-- logo -->

        <a href="Index.php"><img src="../src/img/card_logo.png" alt="logo" id="headerimg"/></a>

        <!-- menu navigation -->

        <nav class="menu">
          <ul class="menu_list">
            <li class="top_menu"><a href="rules.php">Règles</a></li>
            <li class="top_menu active"><a href="Jeu.php">Jouer</a></li>
            <li class="top_menu"><a href="leaderboard.php">Leaderboard</a></li>
            <li id="dropdown_menu" class="top_menu" style="float: right">
              <a id="dropbutton" >| | |</a>
              <div id="dropdown_content">
                <?php fill_drop() ?>
              </div>
            </li>
          </ul>
        </nav>

      </header>

  <h1>MEMORY GAME</h1>
  <div id="memory_board"></div><br/>
      <p id="win"></p>

      <!-- Menu pour choisir la difficulté et lancer une partie -->

      <div id="ngmenu">
        <h2>Nouvelle partie:</h2>
        <button class="gamebtn" onclick="start(8);">easy</button>
        <br />
        <button class="gamebtn" onclick="start(16);">medium</button>
        <br />
        <button class="gamebtn" onclick="start(24);">hard</button>
        <h2>Reprendre la partie:</h2>
        <button class="gamebtn" onclick="resume();">Resume</button>
      </div>

      <!-- Tableau des stats de la partie en cours -->

      <div id="infobox">
        <h3>Temps:</h3>
        <p id="timer"></p>
        <h3>Essais:</h3>
        <p id="try"></p>
      </div>

    <!-- Footer -->

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
