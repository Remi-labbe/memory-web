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
    <title>Memory-Game</title>
    <meta name="authors" content="Leo Menude, Remi Labbe" />
    <meta name="desc" content="Memory Game project for university" />
    <meta name="keywords" content="memory, game, MemoryGame, project, rules" />
    <link rel="icon" href="../src/img/card_logo.png">
    <link rel="stylesheet" href="../style/global.css?<?php echo time();?>">
  </head>

  <!-- body -->

  <body class="bodyform">

    <!-- header -->

    <header>

      <!-- logo -->

      <a href="Index.php"><img src="../src/img/card_logo.png" alt="logo" id="headerimg"/></a>

      <!-- menu navigation header -->

      <nav class="menu">
        <ul class="menu_list">
          <li class="top_menu active"><a href="rules.php">Règles</a></li>
          <li class="top_menu"><a href="Jeu.php">Jouer</a></li>
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

      <!-- Rêgles du jeu -->

      <h1>Memory Game</h1><br /><br />
      <h2>Voici les règles du jeu :</h2>
      <ul>
          <li>Connectez-vous après votre inscription au site.</li>
          <li>Choississez un niveau de difficulté pour le jeu :</li>
          <li style="list-style: none">
            <ol>
                <li>Facile (4 paires)</li>
                <li>Moyen (8 paires)</li>
                <li>Difficile (16 paires)</li>
            </ol>
          </li>
          <li>Retourner les cartes deux à deux :</li>
          <li>Si elles correspondent, elles restent retournées.</li>
          <li>Sinon elles se retournent et vous jouer un nouveau tour !</li>
          <li>Quand toutes les cartes sont retournées vous gagnez !</li>
          <li><span id="remarque">Remarque</span> : Le jeu possède plusieurs options pour le joueur :</li>
          <li style="list-style: none">
            <ol>
                <li>Un système de statistiques de vos parties (temps, nombre de tours, difficultés)</li>
                <li>Un leaderboard avec les scores des meilleurs joueurs</li>
                <li>Un système de sauvegarde automatique permettant de protéger vos parties en cas de problèmes !</li>
            </ol>
          </li>
      </ul>
      <hr/>

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
