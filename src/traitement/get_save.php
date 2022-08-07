<?php
session_start();

if (!isset($_SESSION['id'])){
  header('500 Internal Server Error', true, 500);
  die('Pas de session connectee.');
}

function isAjax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

$host = 'localhost';
$dbname = 'projet_memory';
$dbuser = 'Admin_projet';
$dbpwd = 'adminpwd';

if (isAjax()){
  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    // set the PDO error mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // creating the request
    $req = $conn->prepare("SELECT content FROM saves WHERE id = :pid");
    $req->bindParam(':pid', $pid);

    $pid = $_SESSION['id'];
    $req->execute();

    $data = $req->fetch(PDO::FETCH_ASSOC);

    if(empty($data)){
      echo "error : no data found";
    } else {
      if ($data['content'] == NULL){
        echo "no_data";
      } else {
        echo $data['content'];
      }
    }
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
