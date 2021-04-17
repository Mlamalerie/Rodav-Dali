<?php
session_start();
// si une connection est détecter : (ta rien a faire ici mec)
$okconnectey = false;
if(isset($_SESSION['user_id']) || isset($_SESSION['user_pseudo'])  ) {
    $okconnectey = true;

    $okMonPanierEstVide = false;
    if(empty($_SESSION["user_panier"]) || !isset($_SESSION["user_panier"])) {
        $okMonPanierEstVide = true;
    }
} 

include('php/fctGestionData.php');

$Produits = readJSONFile("boutique.json");

$Data_Users = readUsersXMLFile();


/*
// JSON TO BDD 
include_once("bdd/connexiondb.php");
$catKeys = array_keys($Produits);
foreach($catKeys as $cat) { // ^pour chaque categorie

    $Pr = $Produits[$cat];

    switch($cat) {
        case "albums" : $CodeCat = 1; break;
        case  "tableaux" : $CodeCat = 2; break;
        case  "mode" : $CodeCat = 3; break;
    }


    foreach($Pr as $p) { // pour chaque produit
        $req = $BDD->prepare("INSERT INTO produit (produit_title, produit_author, produit_price, produit_quantity, produit_src, produit_cat) VALUES (?, ?, ?, ?, ?, ?)"); 

        $req->execute(array($p['Title'], $p['Author'], $p['Price'], $p['Quantity'], $p['src'], $CodeCat));

    }

}
*/

?>