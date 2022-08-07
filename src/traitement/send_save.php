<?php
session_start();

if (!isset($_SESSION['id'])){
  header('500 Internal Server Error', true, 500);
  die ('Pas de session connectee.');
}

function isAjax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

$host = 'localhost';
$dbname = 'projet_memory';
$dbuser = 'Admin_projet';
$dbpwd = 'adminpwd';

if(isAjax()){
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    // set the PDO error mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // creating the request
    $req = $conn->prepare("UPDATE saves SET content = :data WHERE id = :pid");
    $req->bindParam(':data', $content);
    $req->bindParam(':pid', $pid);

    $content = $_POST['content'];
    $pid = $_SESSION['id'];
    $req->execute();

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
