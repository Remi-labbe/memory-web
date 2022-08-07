<?php
session_start();
$_SESSION = array();

echo "Vous êtes bien deconnecté !";

session_destroy();
header("Refresh: 1; url=../../pages/Index.php");
exit;
?>
