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

?>

<!DOCTYPE html>
<html lang="fr">
  <head>
      <meta charset="UTF-8">
      <title>MemoryGame</title>
      <meta name="authors" content="Leo Menude, Remi Labbe" />
      <meta name="desc" content="Memory Game project for university" />
      <meta name="keywords" content="memory, game, MemoryGame, project, leaderboard" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="../src/scripts/script.js"></script>
      <link rel="icon" href="../src/img/card_logo.png"/>
      <link rel="stylesheet" href="../style/tab.css?<?php echo time();?>"/>
      <link rel="stylesheet" href="../style/global.css?<?php echo time();?>"/>
  </head>

  <!-- body -->

  <body onload="get_ldb('easy')">

    <!-- header -->

    <header>

      <!-- logo -->

      <a href="Index.php"><img src="../src/img/card_logo.png" alt="logo" id="headerimg"/></a>

      <!-- menu navigation -->

      <nav class="menu">
        <ul class="menu_list">
          <li class="top_menu"><a href="rules.php">Règles</a></li>
          <li class="top_menu"><a href="Jeu.php">Jouer</a></li>
          <li class="top_menu active"><a href="leaderboard.php">Leaderboard</a></li>
          <li id="dropdown_menu" class="top_menu" style="float: right">
            <a id="dropbutton" >| | |</a>
            <div id="dropdown_content">
              <?php fill_drop() ?>
            </div>
          </li>
        </ul>
      </nav>

    </header>

      <table>

          <caption>LeaderBoard</caption>

          <thead>
              <tr>
                  <th colspan="2"></th>
                  <th colspan="2" class="sorter" onclick="get_ldb('easy')">Facile</th>
                  <th colspan="2" class="sorter" onclick="get_ldb('medium')">Intermediaire</th>
                  <th colspan="2" class="sorter" onclick="get_ldb('hard')">Difficile</th>
              </tr>
              <tr>

                  <th>Classement</th>
                  <th>Player</th>
                  <th>Coups</th>
                  <th>Temps</th>
                  <th>Coups</th>
                  <th>Temps</th>
                  <th>Coups</th>
                  <th>Temps</th>
              </tr>
          </thead>
          <tbody id="ldb_body">
          </tbody>
      </table>

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
