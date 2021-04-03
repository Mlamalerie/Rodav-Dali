<?php

// si une connection est détecter : (ta rien a faire ici mec)
$okconnectey = false;
if(isset($_SESSION['user_id']) || isset($_SESSION['user_pseudo'])  ) {
    $okconnectey = true;
} 


function writeJSONFile($nomFichier,$Produits) {
    $json = json_encode($Produits);
    $bytes = file_put_contents($nomFichier, $json); 
    //echo "The number of bytes written are $bytes.";
}

function readJSONFile($nomFichier) {
    $json = file_get_contents($nomFichier,true); 
    $json=str_replace('},

]',"}

]",$json);
    $data = json_decode($json, true);
    return $data;
}
//$d = readJSONFile("boutique.json");
//var_dump($d);
/*
$albums = [];
$albums[] = array("Title" => "Eyes Of Days","Author" =>"Cruel Santi", "Year" =>"2020", "Price" =>17, "Quantity" => 5,"src" => "img/cover/cover%20(1).jpg");
$albums[] = array("Title" => "I Want","Author" => "Cruel Santi","Year" => "2018", "Price" =>10, "Quantity" => 42,"src" => "img/cover/cover%20(4).jpg");
$albums[] = array("Title" => "Slutt Diez","Author" => "Lil Flip","Year" => "2020", "Price" =>20, "Quantity" => 13,"src" => "img/cover/cover%20(2).jpg");
$albums[] = array("Title" => "La Bonne Epoque","Author" => "Mlamali","Year" => "2005", "Price" =>50, "Quantity" => 1,"src" => "img/cover/cover%20(1).jpeg");
$albums[] = array("Title" => "Silver","Author" => "Amadunsi","Year" => "2020", "Price" =>10, "Quantity" => 33,"src" => "img/cover/cover%20(5).jpg");
$albums[] = array("Title" => "WEB","Author" => "Mlamali & Redouane","Year" => "2021", "Price" =>3, "Quantity" => 3,"src" => "img/cover/cover%20(6).jpg");


$tableaux = [];
$tableaux[] = array("Title" => "Feminine stereo","Author" => "Romina Bant","Year" => "2015", "Price" =>350, "Quantity" => 1,"src" => "img/tableau/tableau%20(2).jpg");
$tableaux[] = array("Title" => "Cloudy","Author" => "Romina Bant","Year" => "2014", "Price" =>150, "Quantity" => 1,"src" => "img/tableau/tableau%20(1).jpg");
$tableaux[] = array("Title" => "Rose Gogh","Author" => "Lauralai","Year" => "2020", "Price" =>90, "Quantity" => 1,"src" => "img/tableau/tableau%20(3).jpg");
$tableaux[] = array("Title" => "Madame","Author" => "Lauralai","Year" => "2020", "Price" =>110, "Quantity" => 1,"src" => "img/tableau/tableau%20(4).jpg");
$tableaux[] = array("Title" => "A touch of glass","Author" => "Xav","Year" => "2020", "Price" =>535, "Quantity" => 2,"src" => "img/tableau/tableau%20(17).jpg");
$tableaux[] = array("Title" => "Bisous d'automne","Author" => "Xav","Year" => "2021", "Price" =>1000, "Quantity" => 3,"src" => "img/tableau/tableau%20(6).jpg");
$tableaux[] = array("Title" => "'20 février.'","Author" => "NameMy","Year" => "2021", "Price" =>75, "Quantity" => 1,"src" => "img/tableau/tableau%20(8).jpg");
$tableaux[] = array("Title" => "'21 février.'","Author" => "NameMy","Year" => "2021", "Price" =>75, "Quantity" => 1,"src" => "img/tableau/tableau%20(14).jpg");
$tableaux[] = array("Title" => "Je te vois","Author" => "Salva Ro","Year" => "2021", "Price" =>175, "Quantity" => 5,"src" => "img/tableau/tableau%20(16).jpg");

$mode = [];
$mode[] = array("Title" => "AJ1 • Hadès","Author" => "@Pako-custom","Year" => "2021", "Price" =>110, "Quantity" => 2, "src" => "img/dress/dress%20(1).JPG");
$mode[] = array("Title" => "AJ1 • FleurRouge","Author" => "@Pako-custom","Year" => "2021", "Price" =>160, "Quantity" => 2, "src" => "img/dress/dress%20(2).JPG");
$mode[] = array("Title" => "AJ1 • ASTROWORLD","Author" => "@Pako-custom","Year" => "2021", "Price" =>165, "Quantity" => 1, "src" => "img/dress/dress%20(3).JPG");
$mode[] = array("Title" => "AJ1 • KEN","Author" => "@Pako-custom","Year" => "2020", "Price" =>125, "Quantity" => 1, "src" => "img/dress/dress%20(4).JPG");
$mode[] = array("Title" => "AJ1 • Sharingan","Author" => "@Pako-custom","Year" => "2021", "Price" =>175, "Quantity" => 8, "src" => "img/dress/dress%20(1).PNG");
$mode[] = array("Title" => "BLOCKS Jeans","Author" => "Marvinha","Year" => "2021", "Price" =>15, "Quantity" => 3, "src" => "img/dress/dress%20(5).JPG");

$Produits = [
    "albums" => $albums,
    "tableaux" => $tableaux,
    "mode" => $mode,
];

writeJSONFile("boutique.json",$Produits);
*/

$Produits = readJSONFile("boutique.json");



?>