<?php
session_start();

// SI DÉJA CONNECTÉ ENVOIE VERS LA PAGE DE JEU

if (isset($_SESSION['pseudo'])) {
    header('Location: ../../pages/Jeu.php');
    exit;
}

//  CONNEXION DB ET GESTION DES POSSIBLES ERREURS DE CONNEXIONS (EXCEPTIONS)

$host = 'localhost';
$dbname = 'projet_memory';
$dbuser = 'Admin_projet';
$dbpwd = 'adminpwd';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo 'Echec lors de la connexion :' . $e->getmessage();
}

if (isset($_POST['identifiant']) && isset($_POST['password'])) {

        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];

        // REQUETE PREPARÉE POUR RECUPERER LES IDENTIFIANTS DEJA EXISTANTS ET TEST D'EXISTENCE

        $req = $pdo->prepare("SELECT id, identifiant, pseudo, password, insc_date FROM users WHERE identifiant = :identifiant;");
        $req->bindValue(':identifiant', $identifiant);
        $req->execute();
        $tab = $req->fetch(PDO::FETCH_ASSOC);

        if (empty($tab)) {
            unset($_POST);
            header("Location: ../../pages/form_connect.php?erreur=1");
            exit;
        }


        //  TEST DU BON MOT DE PASSE AVEC LA FONCTION : password_verify(password, hach);

        if (password_verify($password, $tab['password'])) {

            // SI AUCUNE ERREUR CONNEXION ET REDIRECTION JEU

            //  DÉCLARATION DES VARIABLES DE SESSIONS

            $_SESSION['id'] = $tab['id'];
            $_SESSION['pseudo'] = $tab['pseudo'];
            $_SESSION['identifiant'] = $tab['identifiant'];
            $_SESSION['insc'] = $tab['insc_date'];
            unset($_POST);
            header('Location: ../../pages/Jeu.php');
            exit;

        } else {
            // ERREUR SUR LE MOT DE PASSE
            unset($_POST);
            header("Location: ../../pages/form_connect.php?erreur=2");
            exit;
        }

} else {
    session_destroy();
    header("Location: ../../pages/form_connect.php");
    exit;
}
