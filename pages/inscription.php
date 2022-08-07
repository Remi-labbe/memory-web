<?php
session_start();
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

    <h1>Memory Game</h1>

    <p>Vous trouverez ci-dessous les informations relatives à l'inscription</p>
    <br/>
    <p>
        Veuillez renseigner les champs avec les informations suivantes:
    </p>
    <ol>
        <li>Votre pseudo.</li>
        <li>Votre adresse E-mail (valide).</li>
        <li>Votre mot de passe.</li>
        <li>La confirmation de votre mot de passe.</li>
    </ol>
    <br />
    <hr />

    <!-- Formulaire d'inscription -->

    <div id="form">
    <form action="../src/traitement/trait_insc.php" method="POST">

        <p>Création d'un compte</p>
        <hr>
        <div class="alert">
            <?php

            // message d'erreur en fonction du renvoie de GET (gérée dans ../src/traitement/trait_insc.php)

            if(isset($_GET['erreur'])) {
                $k = $_GET['erreur'];
                switch ($k) {
                    case 1:
                        echo "Votre mail n'est pas conforme !";
                        break;
                    case 2:
                        echo "Vos mots de passes ne correspondent pas !";
                        break;
                    case 3:
                        echo "Ce mail est déjà associé à un utilisateur !";
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
                <label for="pseudo">Pseudo:</label>
            </div>
            <div class="input_zone">
                <input type="text" name="pseudo" id="pseudo" maxlength="50" placeholder="Votre pseudo" required autofocus/><br /><br />
            </div>
        </div>

        <div class="row">
            <div class="legend">
                <label for="identifiant">Email :</label>
            </div>
            <div class="input_zone">
                <input type="text" name="identifiant" id="identifiant" maxlength="50"  placeholder="Votre email" required /><br /><br />
            </div>
        </div>

        <div class="row">
            <div class="legend">
                <label for="password">Mot de passe : </label>
            </div>
            <div class="input_zone">
                <input type="password" name="password" id="password" maxlength="20" placeholder="Votre mot de passe" required /><br /><br />
            </div>
        </div>

        <div class="row">
            <div class="legend">
                <label for="password2">Confirmation mot de passe :</label>
            </div>
            <div class="input_zone">
                <input type="password" name="password2" id="password2" maxlength="20" placeholder="Confirmer votre mot de passe" required /><br /><br />
            </div>
        </div>

        <div class="row">
            <input type="submit" name="go" value="Inscription">
        </div>

        <div class="go_connect">
        <p> Déjà inscrit ? <a href="form_connect.php">Connecte toi ici !</a></p>
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
