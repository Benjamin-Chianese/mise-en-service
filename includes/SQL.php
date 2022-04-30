<?php
require_once('conf.php');
try {
    $bdd = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8', $db_user, $db_mdp);
    $bdd->setAttribute(PDO::ATTR_TIMEOUT,5); 
}
catch(Exception $e) {
    die('Erreur : '.$e->getMessage());
}
?>
