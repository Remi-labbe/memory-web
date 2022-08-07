<?php
session_start();

// SI DÉJA CONNECTÉ ENVOIE VERS LA PAGE DE JEU

if (isset($_SESSION['pseudo'])) {

    header('Location: ../../pages/Jeu.php');
    exit;
}

// CONNEXION À LA BASE DE DONNÉES + GESTION DES POSSIBLES ERREURS (EXCEPTIONS)

$host = 'localhost';
$dbname = 'projet_memory';
$dbuser = 'Admin_projet';
$dbpwd = 'adminpwd';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}  catch (PDOException $e) {
    echo 'Echec lors de la connexion' . $e->getmessage();
}

if (isset($_POST['identifiant']) && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['password2'])) {

    // VARIABLES LOCALES ET VARIABLES ENVOYÉ PAR LE FORMULAIRE VIA LA METHODE POST

    $identifiant = $_POST['identifiant'];
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $k = false;

    //TEST ADRESSE MAIL VALIDE SINON REDIRECTION AVEC GET['erreur']

    if (!filter_var($identifiant, FILTER_VALIDATE_EMAIL)) {
        unset($_POST);
        header("Location: ../../pages/inscription.php?erreur=1");
        exit;
    }

    //TEST MOT DE PASSE 1 ET 2 == SINON REDIRECTION AVEC GET['erreur']
    if ($password != $password2) {
        unset($_POST);
        header("Location: ../../pages/inscription.php?erreur=2");
        exit;
    }

    // TEST D'UN POSSIBLE AUTRE COMPTE AU MEME NOM

    // REQUETE PREPARÉE POUR RECUPERER LES IDENTIFIANTS DEJA EXISTANTS ET TEST D'EXISTENCE

    $req = $pdo->prepare('SELECT identifiant FROM users WHERE identifiant = :identifiant;');

    $req->bindParam(':identifiant', $identifiant);

    $req->execute();

    $res = $req->fetchAll(PDO::FETCH_ASSOC);

    if (!empty($res)) {
        unset($_POST);
        header("Location: ../../pages/inscription.php?erreur=3");
        exit;
    }

    // SI AUCUNE ERREUR INSCRIPTION ET ENVOIE BDD DANS CHAQUES TABLES POUR L'INITIALISATION ET LA GESTION PAR ID

    $pseudo = $_POST["pseudo"];
    $identifiant = $_POST["identifiant"];
    $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $req = $pdo->prepare("INSERT INTO users VALUES (NULL, :pseudo, :identifiant, :pwd, CURRENT_TIMESTAMP);");
    $req->bindParam(':pseudo', $pseudo);
    $req->bindParam(':identifiant', $identifiant);
    $req->bindParam(':pwd', $hash);
    $req->execute();

    $req = $pdo->prepare("INSERT INTO saves (id, save_date) VALUES (NULL, CURRENT_TIMESTAMP);");
    $req->execute();

    $req = $pdo->prepare("INSERT INTO stats (id, pseudo) VALUES (NULL, :pseudo);");
    $req->bindParam(':pseudo', $pseudo);
    $req->execute();

    //MESSAGE REUSSIE + REDIRECTION
    echo "Vous êtes bien inscrit !";
    unset($_POST);
    header("Refresh: 2; url=../../pages/form_connect.php");
    exit;

    //SINON REDIRECTION FORMULAIRE
} else {
    session_destroy();
    header("Location: ../../pages//Inscription.php");
    exit;
}?>
