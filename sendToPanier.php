<?php

include_once("varSession.inc.php");

if(!empty($_GET) && $okconnectey ){
    $uemail = $_SESSION['user_email'];
    extract($_GET);
    print_r($_GET);
    print_r($_SESSION);
    $ok = true;

    $key = (String) $key;
    var_dump($key);
    $codeCat = $key[0];
    if(!in_array($codeCat,array('a','m','t'))){
        $ok = false;
        echo "eagra";
    }
    // la catago

    switch($codeCat) {
        case 'a' : $nomCat = "albums"; break;
        case 't' : $nomCat = "tableaux"; break;
        case 'm' : $nomCat = "mode"; break;
    }
    // le num id
    $codeId = (int) substr($key,  1, strlen($key)-1);

    $LesIds = array_keys($Produits[$nomCat]);
    if(!in_array($codeId,$LesIds)) {
        $ok = false;
        echo " # produit $nomCat $codeCat existe pas dans la boutique!";
    } else {
        // verif que la quantité est résonable
        $LeProduit = $Produits[$nomCat][$codeId]; // le produit dapres la boutique
        $qte = (int) $qte; // la quantité a jouté askip
        $qteDejaPan = 0;
        if(!$okMonPanierEstVide){
            $Produits2MonPan = array_keys($_SESSION['user_panier']); 
            // si le produit est deja dans le panier
            if(in_array($key,$Produits2MonPan)) {
                // recuperer la quantité du produit deja dans le panier
                $qteDejaPan += $_SESSION['user_panier'][$key]['quantity'];
                var_dump("qté deja dans le panier",$qteDejaPan);
            }




        }
        if($qte + $qteDejaPan > $LeProduit['Quantity']) {
            $ok = false;
            echo "pas assez en stock.. ".($qte + $qteDejaPan)." > ".$LeProduit['Quantity'];
        } else if ($qte < 1) {
            $ok = false;
            echo "augmente wsh c quoi ça";
        }


    }

    // juska la le produit peut etre ajouté
    if($ok){

        // le panier 
        $panier = $_SESSION['user_panier'] ;
        //}
        var_dump("panier du boug avant ajout");
        var_dump($panier);

        // si panier pas vide
        if(!$okMonPanierEstVide) {
            // si le produit est deja dans le panier
            if(in_array($key,array_keys($panier))){
                $qte += (int) $panier[$key]["quantity"]; // add qte

            } 
        }
        $ajout = array("id" => $codeId, "title" => $LeProduit['Title'],"type" => $nomCat, "quantity" => $qte, "key" => $key );


        $panier[$key] = $ajout; // ajouter la mise à jour au panier


        var_dump("element a ajouté"); 
        var_dump($ajout); 

  

       
        var_dump("panier du boug APRES jout");
        var_dump($panier); 
        $_SESSION['user_panier'] = $panier; // maj panier
      $Data_Users[$uemail]['panier']['produit'] = $panier; // maj data

        echo "*** sendPanier $key***";

    }
} else {
    if($okconnectey){ echo "get vide.. ";} else {echo "pas connecté.. ";};
}

?>