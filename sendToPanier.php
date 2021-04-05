<?php
session_start();
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
        $LeProduit = $Produits[$nomCat][$codeId];
        $qte = (int) $qte;
        if($qte > $LeProduit['Quantity']) {
            $ok = false;
            echo "pas assez en stock.. $qte > ".$LeProduit['Quantity'];
        } else if ($qte < 1) {
            $ok = false;
            echo "augmente wsh c quoi ça";
        }


    }


    if($ok){

        // le panier 
        // if(isset($_SESSION['panier']) ) {
        $panier = $_SESSION['user_panier'] ;
        //}
        var_dump($panier);



        // si plusieurs produits
        if(count($panier) > 1) {
            //var_dump(array_keys($panier));

            // si le produit est deja dans le panier
            if(in_array($key,array_keys($panier))){
                $qte += (int) $panier[$key]["quantity"]; // add qte
                
            } 
            $ajout = array("id" => $codeId, "title" => $LeProduit['Title'],"type" => $nomCat, "quantity" => $qte, "key" => $key );


            $panier[$key] = $ajout; // ajouter la mise à jour au panier

        }
        // si un produit
        else {

            echo "petit";
             $ajout = array("id" => $codeId, "title" => $LeProduit['Title'],"type" => $nomCat, "quantity" => $qte, "key" => $key );
            $panier = array($panier,$ajout);
        }
        var_dump("a ajouté"); 
        var_dump($ajout); 

        $Data_Users[$uemail]['panier']['produit'] = $panier;

        // writeUsersXMLFile($Data_Users); // mettre à jour le fichier des users ?

        var_dump($panier); 
        $_SESSION['user_panier'] = $panier; // maj panier



        echo "*** sendPanier $key***";

    }
} else {
    if($okconnectey){ echo "get vide.. ";} else {echo "pas connecté.. ";};
}

?>