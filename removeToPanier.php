<?php
include_once("varSession.inc.php");

if(!empty($_GET) && $okconnectey ){
    $uemail = $_SESSION['user_email'];
    extract($_GET);
    print_r($_GET);

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
        $panier = $_SESSION['user_panier'] ;
        var_dump("le panier avant",$panier);
        if(!$okMonPanierEstVide){
            // verif que lelement est bien present
            if(!in_array($key,array_keys($panier))){
                $ok = false;
                echo " # produit $nomCat $codeCat n'était pas pas dans le panier chakal";
            }
        } else {
            $ok = false;
            echo "panier vide";
        }
    }



    if($ok){

        if(isset($diminu) && !empty($diminu)) {
            if(!$okMonPanierEstVide) {
                $x = (int) $panier[$key]['quantity'];
                $panier[$key]['quantity'] = ($x-1);
                echo $key." : ".$panier[$key]['quantity']. " -> ".($x-1);
            }

        } else {

            var_dump($panier);
            unset($panier[$key]); // delete
            var_dump($panier); 
            echo "we c suppr c bon";
        }

        var_dump("le panier après",$panier);



        // writeUsersXMLFile($Data_Users); // mettre à jour le fichier des users ?


        $_SESSION['user_panier'] = $panier; // maj panier
        $Data_Users[$uemail]['panier']['produit'] = $panier; // Data


        echo "***removePanier $key ***";

    }
} else {
    if($okconnectey){ echo "get vide.. ";} else {echo "pas connecté.. ";};
}

?>