<?php
session_start();

if (!isset($_SESSION['id'])){
  header('500 Internal Server Error', true, 500);
  die ('Pas de session connectee.');
}

function isAjax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

if(isAjax()){
  $host = 'localhost';
  $dbname = 'projet_memory';
  $dbuser = 'Admin_projet';
  $dbpwd = 'adminpwd';

  $levels = array("easy", "medium", "hard");

  $lvlc = 'coups_' . $levels[(int)$_POST['level']];
  $lvlt = 'tps_' . $levels[(int)$_POST['level']];
  $tries = $_POST['tries'];
  $ttf = $_POST['ttf'];

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    // set the PDO error mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // creating the request
    $req = $conn->prepare('SELECT * FROM stats WHERE id = :pid;');
    $req->bindParam(':pid', $pid);

    $pid = $_SESSION['id'];
    $req->execute();

    $stats = $req->fetch(PDO::FETCH_ASSOC);

    if($stats[$lvlc] = $tries && $stats[$lvlt] > $ttf || $stats[$lvlc] > $tries || $stats[$lvlc] == NULL){
      $req = $conn->prepare("UPDATE stats SET $lvlc = :tries, $lvlt = :ttf WHERE id = :pid");
      $req->bindParam(':tries', $tries);
      $req->bindParam(':ttf', $ttf);
      $req->bindParam(':pid', $pid);

      $req->execute();
    }

    echo "success";

  }
  catch(PDOException $e){
    echo "error : " . $e->getMessage();
  }

  $conn = null;
} else {
  echo "error : non-ajax request.";
  header('Refresh: 2; url=../../pages/Jeu.php');
}

?>
