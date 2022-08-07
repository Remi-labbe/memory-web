<?php

function isAjax() {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}

function affiche_tab($tab) {

    // numero de ligne / classement
    $f = 1;

    foreach($tab as $client) {
        echo "<tr><td>$f</td><td>{$client['pseudo']}</td><td>{$client['coups_easy']}</td><td>{$client['tps_easy']}</td>";
        echo "<td>{$client['coups_medium']}</td><td>{$client['tps_medium']}</td>";
        echo "<td>{$client['coups_hard']}</td><td>{$client['tps_hard']}</td></tr>";
        ++ $f;
    }

}

if (isAjax()){
  $host = 'localhost';
  $dbname = 'projet_memory';
  $dbuser = 'Admin_projet';
  $dbpwd = 'adminpwd';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpwd);
    // set the PDO error mode to Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // creating the request
    $order = "coups_" . $_GET['tri'];
    $req = $conn->prepare("SELECT * FROM stats WHERE $order IS NOT NULL ORDER BY $order LIMIT 10;");

    $req->execute();

    $ldb = $req->fetchAll(PDO::FETCH_ASSOC);

    if(empty($ldb)){
      echo "error : no data found";
    } else {
      affiche_tab($ldb);
    }

  }
  catch(PDOException $e){
    echo "error : " . $e->getMessage();
  }

  $conn = null;
} else {
  echo "error : non-ajax request.";
  header('Refresh: 2; url=../../pages/Index.php');
}
?>
