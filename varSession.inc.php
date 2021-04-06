<?php
session_start();
// si une connection est détecter : (ta rien a faire ici mec)
$okconnectey = false;
if(isset($_SESSION['user_id']) || isset($_SESSION['user_pseudo'])  ) {
    $okconnectey = true;
     
    $okMonPanierEstVide = false;
    if(empty($_SESSION["user_panier"])) {
         $okMonPanierEstVide = true;
    }
} 

require('php/fctGestionData.php');

$Produits = readJSONFile("boutique.json");

$Data_Users = readUsersXMLFile();

?>