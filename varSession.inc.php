<?php

// si une connection est détecter : (ta rien a faire ici mec)
$okconnectey = false;
if(isset($_SESSION['user_id']) || isset($_SESSION['user_pseudo'])  ) {
    $okconnectey = true;
} 


/********************************************************************************/
/*****************************    PRODUITS    ***********************************/
/********************************************************************************/

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
/*
$albums = [];
$albums[] = array("id" => 0, "Title" => "Eyes Of Days","Author" =>"Cruel Santi", "Year" =>"2020", "Price" =>17, "Quantity" => 5,"src" => "img/cover/cover%20(1).jpg");
$albums[] = array("id" => 1,"Title" => "I Want","Author" => "Cruel Santi","Year" => "2018", "Price" =>10, "Quantity" => 42,"src" => "img/cover/cover%20(4).jpg");
$albums[] = array("id" => 2, "Title" => "Slutt Diez","Author" => "Lil Flip","Year" => "2020", "Price" =>20, "Quantity" => 13,"src" => "img/cover/cover%20(2).jpg");
$albums[] = array("id" => 3, "Title" => "La Bonne Epoque","Author" => "Mlamali","Year" => "2005", "Price" =>50, "Quantity" => 1,"src" => "img/cover/cover%20(1).jpeg");
$albums[] = array("id" => 4, "Title" => "Silver","Author" => "Amadunsi","Year" => "2020", "Price" =>10, "Quantity" => 33,"src" => "img/cover/cover%20(5).jpg");
$albums[] = array("id" => 5, "Title" => "WEB","Author" => "Mlamali & Redouane","Year" => "2021", "Price" =>3, "Quantity" => 3,"src" => "img/cover/cover%20(6).jpg");


$tableaux = [];
$tableaux[] = array("id" => 0, "Title" => "Feminine stereo","Author" => "Romina Bant","Year" => "2015", "Price" =>350, "Quantity" => 1,"src" => "img/tableau/tableau%20(2).jpg");
$tableaux[] = array("id" => 1, "Title" => "Cloudy","Author" => "Romina Bant","Year" => "2014", "Price" =>150, "Quantity" => 1,"src" => "img/tableau/tableau%20(1).jpg");
$tableaux[] = array("id" => 2, "Title" => "Rose Gogh","Author" => "Lauralai","Year" => "2020", "Price" =>90, "Quantity" => 1,"src" => "img/tableau/tableau%20(3).jpg");
$tableaux[] = array("id" => 3, "Title" => "Madame","Author" => "Lauralai","Year" => "2020", "Price" =>110, "Quantity" => 1,"src" => "img/tableau/tableau%20(4).jpg");
$tableaux[] = array("id" => 4, "Title" => "A touch of glass","Author" => "Xav","Year" => "2020", "Price" =>535, "Quantity" => 2,"src" => "img/tableau/tableau%20(17).jpg");
$tableaux[] = array("id" => 5, "Title" => "Bisous d'automne","Author" => "Xav","Year" => "2021", "Price" =>1000, "Quantity" => 3,"src" => "img/tableau/tableau%20(6).jpg");
$tableaux[] = array("id" => 6, "Title" => "'20 février.'","Author" => "NameMy","Year" => "2021", "Price" =>75, "Quantity" => 1,"src" => "img/tableau/tableau%20(8).jpg");
$tableaux[] = array("id" => 7, "Title" => "'21 février.'","Author" => "NameMy","Year" => "2021", "Price" =>75, "Quantity" => 1,"src" => "img/tableau/tableau%20(14).jpg");
$tableaux[] = array("id" => 8, "Title" => "Je te vois","Author" => "Salva Ro","Year" => "2021", "Price" =>175, "Quantity" => 5,"src" => "img/tableau/tableau%20(16).jpg");

$mode = [];
$mode[] = array("id" => 0, "Title" => "AJ1 • Hadès","Author" => "@Pako-custom","Year" => "2021", "Price" =>110, "Quantity" => 2, "src" => "img/dress/dress%20(1).JPG");
$mode[] = array("id" => 1, "Title" => "AJ1 • FleurRouge","Author" => "@Pako-custom","Year" => "2021", "Price" =>160, "Quantity" => 2, "src" => "img/dress/dress%20(2).JPG");
$mode[] = array("id" => 2, "Title" => "AJ1 • ASTROWORLD","Author" => "@Pako-custom","Year" => "2021", "Price" =>165, "Quantity" => 1, "src" => "img/dress/dress%20(3).JPG");
$mode[] = array("id" => 3, "Title" => "AJ1 • KEN","Author" => "@Pako-custom","Year" => "2020", "Price" =>125, "Quantity" => 1, "src" => "img/dress/dress%20(4).JPG");
$mode[] = array("id" => 4, "Title" => "AJ1 • Sharingan","Author" => "@Pako-custom","Year" => "2021", "Price" =>175, "Quantity" => 8, "src" => "img/dress/dress%20(1).PNG");
$mode[] = array("id" => 5, "Title" => "BLOCKS Jeans","Author" => "Marvinha","Year" => "2021", "Price" =>15, "Quantity" => 3, "src" => "img/dress/dress%20(5).JPG");

$Produits = [
    "albums" => $albums,
    "tableaux" => $tableaux,
    "mode" => $mode,
];

writeJSONFile("boutique.json",$Produits);
*/
$Produits = readJSONFile("boutique.json");

/********************************************************************************/
/*****************************     USERS      ***********************************/
/********************************************************************************/


function writeUsersXMLFile($data) {

    $nomFichier = "users.xml";
    $xml = new SimpleXMLElement('<?xml version="1.0"?><data-users/>');
    if(!empty($data)){
        $listeKeys = array_keys($data[array_keys($data)[0]]);
        //var_dump($listeKeys);
        foreach($data as $u) {

            $user = $xml->addChild('user');

            foreach($listeKeys as $k) {
                if($k != 'panier'){
                    $user->addChild($k, $u[$k]);
                } else {
                    
                    $panier = $user->addChild('panier'); //** user> panier>
                    
                    $lePanier = $u['panier']['produit']; // array('a1' =>) le panier de u
                    //var_dump($u['pseudo'],$u['panier']);
                    foreach($lePanier as $p ){
                        $panier->addChild("produit",$p); //panier>
                        
                    }



                }
            }

        }
    } else {
        $user = $xml->addChild('user');

        foreach($listeKeys as $k) {
            $user->addChild($k, $u[$k]);
        }
    }

    $res = $xml->asXML();
    $res=str_replace('><',">    \n<",$res);
    //$bytes = file_put_contents($nomFichier,$res);
}
function changerKeys($data,$NEW) {
    $i = 0;
    if(!empty($data[0])){

        foreach($data as $u){
            //if($NEW == "key"){ var_dump($u);}
            
            
            if(!empty($u[$NEW]) && !empty($u)){
                $newkey = $u[$NEW];
                $oldkey = $i;
                $data[$newkey] = $data[$oldkey];
                unset($data[$oldkey]);
            }
            $i++;
        }
    }
    return $data;
}
function readUsersXMLFile() {
    $fic = "users.xml";

    if (file_exists($fic)) {
        $data = simplexml_load_file($fic);

        //var_dump(count($data));
        if(count($data) > 1){
            $res = @json_decode(@json_encode($data),1);

            // changer clé panier
            for($i = 0; $i < count($res['user']); $i++ ) {
                $res['user'][$i]['panier']['produit'] = changerKeys($res['user'][$i]['panier']['produit'],"key");
            }


            return changerKeys($res['user'],"email");
        } else { // un element
            $res = @json_decode(@json_encode(array($data->user)),1);

            // changer clé panier
            
            $res[0]['panier']['produit'] = changerKeys($res[0]['panier']['produit'],"key");

            
            return changerKeys($res,"email");
        } 
    } else { 
        exit("Echec lors de l\'ouverture du fichier $fic.");
    } 

}


$Data_Users = readUsersXMLFile();


?>