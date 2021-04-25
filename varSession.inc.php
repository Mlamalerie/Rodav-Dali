<?php
session_start();
include_once("bdd/connexiondb.php");

include('php/fctGestionData.php');


$okconnectey = false;
$okuserADMIN = false;
// si une connection est détecter 
if(isset($_SESSION['user_id']) || isset($_SESSION['user_pseudo'])  ) {
    $okconnectey = true;
    $_SESSION["user_panier"] = getDataBDDPanier($_SESSION['user_id'],$BDD);

    $okMonPanierEstVide = false;
    if(empty($_SESSION["user_panier"]) || !isset($_SESSION["user_panier"])) {
        $okMonPanierEstVide = true;
    } 
    
    
    if($_SESSION['user_role'] == 0) {
        $okuserADMIN = true;
    }
} 


//$Produits = readJSONFile("boutique.json");
$AllProduits = getAllBDDProduits($BDD);

//$Data_Users = readUsersXMLFile();


// JSON TO BDD 



/*
$catKeys = array_keys($Produits);

foreach($catKeys as $cat) { // ^pour chaque categorie

    $Pr = $Produits[$cat];

    switch($cat) {
        case "albums" : $CodeCat = 1; break;
        case  "tableaux" : $CodeCat = 2; break;
        case  "mode" : $CodeCat = 3; break;
    }


    foreach($Pr as $p) { // pour chaque produit
        $req = $BDD->prepare("INSERT INTO produit (produit_title, produit_author, produit_price, produit_quantity, produit_src, produit_cat, produit_year) VALUES (?, ?, ?, ?, ?, ?, ?)"); 

        $req->execute(array($p['Title'], $p['Author'], $p['Price'], $p['Quantity'], $p['src'], $CodeCat, $p['Year']));

    }

}
*/





?>